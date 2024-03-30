<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService extends BaseService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(
        ProductRepository $productRepository,
    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->controllerName = 'ProductController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'product_catalogue_id' => request('product_catalogue_id'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];

        $select = [
            'products.id',
            'products.publish',
            'products.image',
            'products.user_id',
            'products.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'product_language as tb2' => ['tb2.product_id', '=', 'products.id'],
            'product_catalogue_product as tb3' => ['tb3.product_id', '=', 'products.id'],
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        $products = $this->productRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
            ['product_catalogues'],
            $select,
            $this->whereRaw()

        );

        // dd($products);
        return $products;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $product_catalogue_id = request('product_catalogue_id');
        if ($product_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.product_catalogue_id IN (
                        SELECT id 
                        FROM product_catalogues
                        INNER JOIN product_catalogue_language as pcl ON pcl.product_catalogue_id = product_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM product_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM product_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$product_catalogue_id, $product_catalogue_id, session('currentLanguage')]
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
            $payload = $this->formatAlbum($payload);
            // Lấy ra id người dùng hiện tại
            $payload['user_id'] = Auth::id();

            // Create product
            $product = $this->productRepository->create($payload);
            if ($product->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($product->id);
                // Create pivot and sync
                $this->createPivotAndSync($product, $payloadLanguage);

                // create router
                $this->createRouter($product);
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
            // Lấy ra dữ liệu của product hiện tại để xoá;
            $product = $this->productRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);
            // Update product
            $updateProduct = $this->productRepository->update($id, $payload);

            if ($updateProduct) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $product->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($product, $payloadLanguage);

                // update router
                $this->updateRouter($product);
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
        return array_unique(array_merge(
            request('catalogue'),
            [request('product_catalogue_id')],
        ));
    }


    private function formatPayloadLanguage($productId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra product_id 
        $payloadLanguage['product_id'] = $productId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($product, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng product_language
        $this->productRepository->createPivot($product, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng product_catalogue_product
        $product->product_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->productRepository->delete($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    function updateStatus()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value') == 1 ? 0 : 1;
            $update =  $this->productRepository->update(request('modelId'), $payload);

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
            $update =  $this->productRepository->updateByWhereIn('id', request('id'), $payload);

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

    private function payload()
    {
        return ['product_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
