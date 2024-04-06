<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\{ModuleTemplate}ServiceInterface;
use App\Repositories\Interfaces\{ModuleTemplate}RepositoryInterface as {ModuleTemplate}Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class {ModuleTemplate}Service extends BaseService implements {ModuleTemplate}ServiceInterface
{
    protected ${moduleTemplate}Repository;
    public function __construct(
        {ModuleTemplate}Repository ${moduleTemplate}Repository,
    ) {
        parent::__construct();
        $this->{moduleTemplate}Repository = ${moduleTemplate}Repository;
        $this->controllerName = '{ModuleTemplate}Controller';
    }


    public function paginate()
    {
        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];
        // dd($condition);

        $select = [
            '{tableName}.id',
            '{tableName}.publish',
            '{tableName}.image',
            '{tableName}.level',
            '{tableName}.user_id',
            '{tableName}.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            '{pivotTable} as tb2' => ['tb2.{foreignKey}', '=', '{tableName}.id']
        ];
        $orderBy = [
            '{tableName}.left' => 'asc',
            '{tableName}.created_at' => 'desc'
        ];

        //////////////////////////////////////////////////////////
        ${moduleTemplate}s = $this->{moduleTemplate}Repository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
        );
        // dd(${moduleTemplate}s);

        return ${moduleTemplate}s;
    }

    function create()
    {

        DB::beginTransaction();
        try {
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Lấy ra id của người dùng hiện tại.
            $payload['user_id'] = Auth::id();

            // Create {moduleTemplate}
            ${moduleTemplate} = $this->{moduleTemplate}Repository->create($payload);

            if (${moduleTemplate}->id > 0) {

                // Format payload language
                $payloadLanguage = $this->formatPayloadLanguage(${moduleTemplate}->id);

                // Tạo ra pivot vào bảng {moduleTemplate}_language
                $this->createPivotLanguage(${moduleTemplate}, $payloadLanguage);

                // create router
                $this->createRouter(${moduleTemplate});

                // Dùng để tính toán lại các giá trị left right
                $this->initNetedset();
                $this->calculateNestedSet();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }


    function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra dữ liệu của {moduleTemplate} hiện tại để xoá;
            ${moduleTemplate} = $this->{moduleTemplate}Repository->findById($id);
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');

            // Update {moduleTemplate}
            $update{ModuleTemplate} = $this->{moduleTemplate}Repository->update($id, $payload);

            if ($update{ModuleTemplate}) {
                // Lây ra payload language và format lai
                $payloadLanguage = $this->formatPayloadLanguage(${moduleTemplate}->id);

                // Xoá bản ghi cũa một pivot
                ${moduleTemplate}->languages()->detach([$payloadLanguage['language_id'], $id]);

                // Tạo ra pivot vào bảng {privotTable}
                $this->createPivotLanguage(${moduleTemplate}, $payloadLanguage);

                // update router
                $this->updateRouter(${moduleTemplate});

                // Dùng để tính toán lại các giá trị left right
                $this->initNetedset();
                $this->calculateNestedSet();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function formatPayloadLanguage(${moduleTemplate}Id)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
        // Lấy ra {foreignKey}
        $payloadLanguage['{foreignKey}'] = ${moduleTemplate}Id;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }



    private function createPivotLanguage(${moduleTemplate}, $payloadLanguage)
    {
        $this->{moduleTemplate}Repository->createPivot(${moduleTemplate}, $payloadLanguage, 'languages');
    }

   
    private function payload()
    {
        return ['parent_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }

    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->{moduleTemplate}Repository->delete($id);

            // Dùng để tính toán lại các giá trị left right
            $this->initNetedset();
            $this->calculateNestedSet();

            // Xoa router
            $this->deleteRouter($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => '{tableName}',
            'foreignkey' => '{foreignKey}',
            'language_id' => session('currentLanguage')
        ]);
    }

    function updateStatus()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value') == 1 ? 0 : 1;
            $update =  $this->{moduleTemplate}Repository->update(request('modelId'), $payload);

            if (!$update) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function updateStatusAll()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value');
            $update =  $this->{moduleTemplate}Repository->updateByWhereIn('id', request('id'), $payload);

            if (!$update) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

}
