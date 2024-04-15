<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

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
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            '{moduleTemplate}_catalogue_id' => request('{moduleTemplate}_catalogue_id'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];

        $select = [
            '{moduleTemplate}s.id',
            '{moduleTemplate}s.publish',
            '{moduleTemplate}s.image',
            '{moduleTemplate}s.user_id',
            '{moduleTemplate}s.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            '{moduleTemplate}_language as tb2' => ['tb2.{moduleTemplate}_id', '=', '{moduleTemplate}s.id'],
            '{moduleTemplate}_catalogue_{moduleTemplate} as tb3' => ['tb3.{moduleTemplate}_id', '=', '{moduleTemplate}s.id'],
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        ${moduleTemplate}s = $this->{moduleTemplate}Repository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
            ['{moduleTemplate}_catalogues'],
            $select,
            $this->whereRaw()

        );

        // dd(${moduleTemplate}s);
        return ${moduleTemplate}s;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        ${moduleTemplate}_catalogue_id = request('{moduleTemplate}_catalogue_id');
        if (${moduleTemplate}_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.{moduleTemplate}_catalogue_id IN (
                        SELECT id 
                        FROM {moduleTemplate}_catalogues
                        INNER JOIN {moduleTemplate}_catalogue_language as pcl ON pcl.{moduleTemplate}_catalogue_id = {moduleTemplate}_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM {moduleTemplate}_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM {moduleTemplate}_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [${moduleTemplate}_catalogue_id, ${moduleTemplate}_catalogue_id, session('currentLanguage')]
                ]
            ];
        }
        return $rawConditions;
    }

    function create()
    {

        DB::beginTransaction();
        try {

            //   Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Lấy ra id người dùng hiện tại
            $payload['user_id'] = Auth::id();

            // Create {moduleTemplate}
            ${moduleTemplate} = $this->{moduleTemplate}Repository->create($payload);
            if (${moduleTemplate}->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage(${moduleTemplate}->id);
                // Create pivot and sync
                $this->createPivotAndSync(${moduleTemplate}, $payloadLanguage);

                // create router
                $this->createRouter(${moduleTemplate});
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
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                ${moduleTemplate}->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync(${moduleTemplate}, $payloadLanguage);

                // update router
                $this->updateRouter(${moduleTemplate});
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

    private function catalogue()
        {
            if (!empty(request('catalogue'))) {
                return array_unique(array_merge(
                    request('catalogue'),
                    [request('{moduleTemplate}_catalogue_id')],
                ));
            }
            return [request('{moduleTemplate}_catalogue_id')];
        }


    private function formatPayloadLanguage(${moduleTemplate}Id)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra {moduleTemplate}_id 
        $payloadLanguage['{moduleTemplate}_id'] = ${moduleTemplate}Id;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync(${moduleTemplate}, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng {moduleTemplate}_language
        $this->{moduleTemplate}Repository->createPivot(${moduleTemplate}, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng {moduleTemplate}_catalogue_{moduleTemplate}
        ${moduleTemplate}->{moduleTemplate}_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->{moduleTemplate}Repository->delete($id);

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

    private function payload()
    {
        return ['{moduleTemplate}_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
