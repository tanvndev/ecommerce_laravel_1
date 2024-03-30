<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCatalogueService extends BaseService implements ProductCatalogueServiceInterface
{
    protected $productCatalogueRepository;
    public function __construct(
        ProductCatalogueRepository $productCatalogueRepository,
    ) {
        parent::__construct();
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->controllerName = 'ProductCatalogueController';
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
            'product_catalogues.id',
            'product_catalogues.publish',
            'product_catalogues.image',
            'product_catalogues.level',
            'product_catalogues.user_id',
            'product_catalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'product_catalogue_language as tb2' => ['tb2.product_catalogue_id', '=', 'product_catalogues.id']
        ];
        $orderBy = [
            'product_catalogues.left' => 'asc',
            'product_catalogues.created_at' => 'desc'
        ];

        //////////////////////////////////////////////////////////
        $productCatalogues = $this->productCatalogueRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
        );
        // dd($productCatalogues);

        return $productCatalogues;
    }

    function create()
    {

        DB::beginTransaction();
        try {
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);
            // Lấy ra id của người dùng hiện tại.
            $payload['user_id'] = Auth::id();

            // Create productCatalogue
            $productCatalogue = $this->productCatalogueRepository->create($payload);

            if ($productCatalogue->id > 0) {

                // Format payload language
                $payloadLanguage = $this->formatPayloadLanguage($productCatalogue->id);

                // Tạo ra pivot vào bảng productCatalogue_language
                $this->createPivotLanguage($productCatalogue, $payloadLanguage);

                // create router
                $this->createRouter($productCatalogue);

                // Dùng để tính toán lại các giá trị left right
                $this->initNetedset();
                $this->calculateNestedSet();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }


    function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra dữ liệu của productCatalogue hiện tại để xoá;
            $productCatalogue = $this->productCatalogueRepository->findById($id);
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);

            // Update productCatalogue
            $updateProductCatalogue = $this->productCatalogueRepository->update($id, $payload);

            if ($updateProductCatalogue) {
                // Lây ra payload language và format lai
                $payloadLanguage = $this->formatPayloadLanguage($productCatalogue->id);

                // Xoá bản ghi cũa một pivot
                $productCatalogue->languages()->detach([$payloadLanguage['language_id'], $id]);

                // Tạo ra pivot vào bảng {privotTable}
                $this->createPivotLanguage($productCatalogue, $payloadLanguage);

                // update router
                $this->updateRouter($productCatalogue);

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

    private function formatPayloadLanguage($productCatalogueId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
        // Lấy ra product_catalogue_id
        $payloadLanguage['product_catalogue_id'] = $productCatalogueId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }



    private function createPivotLanguage($productCatalogue, $payloadLanguage)
    {
        $this->productCatalogueRepository->createPivot($productCatalogue, $payloadLanguage, 'languages');
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
            $delete = $this->productCatalogueRepository->delete($id);

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
            'table' => 'product_catalogues',
            'foreignkey' => 'product_catalogue_id',
            'language_id' => session('currentLanguage')
        ]);
    }

    function updateStatus()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value') == 1 ? 0 : 1;
            $update =  $this->productCatalogueRepository->update(request('modelId'), $payload);

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
            $update =  $this->productCatalogueRepository->updateByWhereIn('id', request('id'), $payload);

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
