<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\AttributeCatalogueServiceInterface;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeCatalogueService extends BaseService implements AttributeCatalogueServiceInterface
{
    protected $attributeCatalogueRepository;
    public function __construct(
        AttributeCatalogueRepository $attributeCatalogueRepository,
    ) {
        parent::__construct();
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
        $this->controllerName = 'AttributeCatalogueController';
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
            'attribute_catalogues.id',
            'attribute_catalogues.publish',
            'attribute_catalogues.image',
            'attribute_catalogues.level',
            'attribute_catalogues.user_id',
            'attribute_catalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'attribute_catalogue_language as tb2' => ['tb2.attribute_catalogue_id', '=', 'attribute_catalogues.id']
        ];
        $orderBy = [
            'attribute_catalogues.left' => 'asc',
            'attribute_catalogues.created_at' => 'desc'
        ];

        //////////////////////////////////////////////////////////
        $attributeCatalogues = $this->attributeCatalogueRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
        );
        // dd($attributeCatalogues);

        return $attributeCatalogues;
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


            // Create attributeCatalogue
            $attributeCatalogue = $this->attributeCatalogueRepository->create($payload);

            if ($attributeCatalogue->id > 0) {

                // Format payload language
                $payloadLanguage = $this->formatPayloadLanguage($attributeCatalogue->id);

                // Tạo ra pivot vào bảng attributeCatalogue_language
                $this->createPivotLanguage($attributeCatalogue, $payloadLanguage);

                // create router
                $this->createRouter($attributeCatalogue);

                // Dùng để tính toán lại các giá trị left right
                $this->initNetedset();
                $this->calculateNestedSet();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return false;
        }
    }


    function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra dữ liệu của attributeCatalogue hiện tại để xoá;
            $attributeCatalogue = $this->attributeCatalogueRepository->findById($id);
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');

            // Update attributeCatalogue
            $updateAttributeCatalogue = $this->attributeCatalogueRepository->update($id, $payload);

            if ($updateAttributeCatalogue) {
                // Lây ra payload language và format lai
                $payloadLanguage = $this->formatPayloadLanguage($attributeCatalogue->id);

                // Xoá bản ghi cũa một pivot
                $attributeCatalogue->languages()->detach([$payloadLanguage['language_id'], $id]);

                // Tạo ra pivot vào bảng {privotTable}
                $this->createPivotLanguage($attributeCatalogue, $payloadLanguage);

                // update router
                $this->updateRouter($attributeCatalogue);

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

    private function formatPayloadLanguage($attributeCatalogueId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
        // Lấy ra attribute_catalogue_id
        $payloadLanguage['attribute_catalogue_id'] = $attributeCatalogueId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }



    private function createPivotLanguage($attributeCatalogue, $payloadLanguage)
    {
        $this->attributeCatalogueRepository->createPivot($attributeCatalogue, $payloadLanguage, 'languages');
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
            $delete = $this->attributeCatalogueRepository->delete($id);

            // Xoa router
            $this->deleteRouter($id);

            // Dùng để tính toán lại các giá trị left right
            $this->initNetedset();
            $this->calculateNestedSet();

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
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
            'language_id' => session('currentLanguage')
        ]);
    }
}
