<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\ProductVariantLanguageRepositoryInterface as ProductVariantLanguageRepository;
use App\Repositories\Interfaces\ProductVariantAttributeRepositoryInterface as ProductVariantAttributeRepository;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ProductService extends BaseService implements ProductServiceInterface
{
    protected $productRepository;
    protected $productVariantLanguageRepository;
    protected $productVariantAttributeRepository;
    protected $promotionRepository;
    protected $attributeCatalogueRepository;
    protected $attributeRepository;
    protected $productCatalogueService;


    public function __construct(
        ProductRepository $productRepository,
        ProductVariantLanguageRepository $productVariantLanguageRepository,
        ProductVariantAttributeRepository $productVariantAttributeRepository,
        PromotionRepository $promotionRepository,
        AttributeCatalogueRepository $attributeCatalogueRepository,
        AttributeRepository $attributeRepository,
        ProductCatalogueService $productCatalogueService

    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->productVariantLanguageRepository = $productVariantLanguageRepository;
        $this->productVariantAttributeRepository = $productVariantAttributeRepository;
        $this->promotionRepository = $promotionRepository;
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
        $this->attributeRepository = $attributeRepository;
        $this->controllerName = 'ProductController';
        $this->productCatalogueService = $productCatalogueService;
    }
    public function paginate($productCatalogue = null)
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            // 'product_catalogue_id' => request('product_catalogue_id'),
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
            'products.price',
            'products.product_catalogue_id',
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
            request('perpage', 18),
            $orderBy,
            $join,
            ['product_catalogues'],
            $select,
            $this->whereRaw($productCatalogue)

        );
        // dd($products);
        return $products;
    }

    private function whereRaw($productCatalogue = null)
    {
        $rawConditions = [];
        $product_catalogue_id = request('product_catalogue_id');
        if ($product_catalogue_id > 0 || !is_null($productCatalogue)) {

            $product_catalogue_id = ($product_catalogue_id > 0) ? $product_catalogue_id : $productCatalogue->id;

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

    public function create()
    {

        DB::beginTransaction();
        try {
            //   Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            // $payload = $this->formatPayloadtoJson($payload);
            $payload['price'] = convertPrice($payload['price'] ?? 0);
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
                $attribute = request('attribute') ?? '';

                if (null !== $attribute && !empty($attribute)) {
                    // Tạo ra nhiều phiên bản
                    $this->createVariant($product);
                    $this->productCatalogueService->setAttribute($product);
                }
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

    public function update($id)
    {

        DB::beginTransaction();
        try {
            // Lấy ra dữ liệu của product hiện tại để xoá;
            $product = $this->productRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());


            // $payload = $this->formatJson($payload, 'album');
            $payload['price'] = convertPrice($payload['price'] ?? 0);
            // Update product
            $updateProduct = $this->productRepository->save($id, $payload);

            if ($updateProduct) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $product->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($product, $payloadLanguage);

                // update router
                $this->updateRouter($product);


                // Xoa cac bản ghi của của sản phẩm đó
                $product->product_variants()->each(function ($variant) {
                    $variant->attributes()->detach();
                    $variant->languages()->detach();
                    $variant->delete();
                });

                $attribute = request('attribute') ?? '';
                if (null !== $attribute && !empty($attribute)) {
                    // Tạo ra nhiều phiên bản
                    $this->createVariant($product);
                    $this->productCatalogueService->setAttribute($updateProduct);
                }
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

    private function createVariant($product)
    {
        $payload = request()->only(['variant', 'productVariant', 'attribute']);
        $variantPayload = $this->formatPayloadVariant($product, $payload);


        // Tạo ra bản ghi cho product_variant
        $variants = $product->product_variants()->createMany($variantPayload);
        $productVariantLangue = [];
        $variantAttribute = [];
        // Lấy ra id các bản ghi product_variant
        $productVariantId = $variants->pluck('id');
        // Lấy ra kết hợp attribute
        $attributeCombine = $this->combineAttribute(array_values($payload['attribute']));

        if (count($productVariantId) > 0) {
            $productVariantLangue = [];
            foreach ($productVariantId as $key => $value) {
                $productVariantLangue[] = [
                    'product_variant_id' => $value,
                    'language_id' => session('currentLanguage'),
                    'name' => $payload['productVariant']['name'][$key] ?? '',
                ];

                if (count($attributeCombine) > 0) {
                    foreach ($attributeCombine[$key] as $keyAttr => $valueAttr) {
                        $variantAttribute[] = [
                            'product_variant_id' => $value,
                            'attribute_id' => $valueAttr,
                        ];
                    }
                }
            }
        }

        // Tạo ra bản ghi cho variant_language
        $variantLanguage = $this->productVariantLanguageRepository->createBatch($productVariantLangue);

        // Tạo ra bản ghi cho product_variant_attribute
        $this->productVariantAttributeRepository->createBatch($variantAttribute);
    }

    private function combineAttribute($attribute, $index = 0)
    {
        // Nếu chỉ số index đã vượt qua chỉ số lớn nhất của mảng
        if ($index >= count($attribute)) {
            return [[]];
        }

        // Lấy mảng con ứng với chỉ số index hiện tại
        $currentAttribute = $attribute[$index];
        // Lấy kết quả của các mảng con tiếp theo
        $nextCombinations = $this->combineAttribute($attribute, $index + 1);

        // Tạo mảng kết quả mới
        $result = [];
        // Lặp qua từng phần tử trong mảng con hiện tại
        foreach ($currentAttribute as $item) {
            // Lặp qua từng kết hợp trong kết quả của các mảng con tiếp theo
            foreach ($nextCombinations as $combination) {
                // Thêm phần tử của mảng con hiện tại vào mảng kết hợp và thêm vào mảng kết quả
                $result[] = array_merge([$item], $combination);
            }
        }

        return $result;
    }

    private function formatPayloadVariant($product, $payload)
    {
        $variantPayload = [];
        if (isset($payload['variant']['sku']) && count($payload['variant']['sku']) > 0) {
            foreach ($payload['variant']['sku'] as $key => $value) {
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $product->id . ', ' . $payload['productVariant']['id'][$key] ?? '');

                $code = $this->sortVariantId($payload['productVariant']['id'][$key] ?? '');
                $variantPayload[] = [
                    'uuid' => $uuid,
                    'code' => $code ?? '',
                    'quantity' => convertPrice($payload['variant']['quantity'][$key] ?? 0),
                    'price' => convertPrice($payload['variant']['price'][$key] ?? 0),
                    'sku' => $value ?? '',
                    'barcode' => $payload['variant']['barcode'][$key] ?? '',
                    'file_name' => $payload['variant']['file_name'][$key] ?? '',
                    'file_url' => $payload['variant']['file_url'][$key] ?? '',
                    'album' => $payload['variant']['album'][$key] ?? '',
                    'user_id' => Auth::id(),
                ];
            }
        }
        return $variantPayload;
    }

    private function sortVariantId($productVariantId)
    {
        if ($productVariantId == '') {
            return '';
        }

        $numberArray = explode(", ", $productVariantId);
        sort($numberArray, SORT_NUMERIC);
        $sortedNumbers = implode(", ", $numberArray);
        return $sortedNumbers;
    }

    private function catalogue()
    {
        if (!empty(request('catalogue'))) {
            return array_unique(array_merge(
                request('catalogue'),
                [request('product_catalogue_id')],
            ));
        }
        return [request('product_catalogue_id')];
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
        return ['product_catalogue_id', 'image', 'follow', 'publish', 'album', 'attributeCatalogue', 'attribute', 'variant', 'sku', 'price', 'origin'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }

    // Service Client

    public function combineProductAndPromotion($productId = [],  $products = null, $flag = false)
    {
        $promotions = $this->promotionRepository->findByProduct($productId);
        if (count($promotions)) {

            if ($flag == true) {
                $products->promotion = $promotions;
                return $products;
            }

            foreach ($products as $index => $product) {
                foreach ($promotions as $key => $promotion) {
                    if ($promotion->product_id == $product->id) {
                        $products[$index]->promotion = $promotion;
                    }
                }
            }
        }
        return $products;
    }

    public function getAttribute($product)
    {
        $languageId = session('currentLanguage');
        $attributeCatalogueIds = array_keys($product->attribute);
        $attributeIds = array_merge(...$product->attribute);

        // Lấy attribute catalogues và attributes liên quan
        $attributeCatalogues = $this->attributeCatalogueRepository->getAttributeCatalogueLanguageWhereIn($attributeCatalogueIds, 'id', $languageId);
        $attributes = $this->attributeRepository->findAttributeByIdArray($attributeIds, $languageId);

        // Gán attributes cho các attribute catalogues tương ứng
        if (!is_null($attributeCatalogues)) {
            $attributeCatalogues->each(function ($attributeCatalogue) use ($attributes) {
                $attributeCatalogue->attributes = $attributes->filter(function ($attribute) use ($attributeCatalogue) {
                    return $attribute->attribute_catalogue_id == $attributeCatalogue->id;
                });
            });
        }

        $product->attributeCatalogues = $attributeCatalogues;

        return $product;
    }

    public function filter()
    {
        // Lam cau truy van loc theo gia tien
        $params['priceQuery'] = $this->priceQuery(request()->input('price'));
        // Lam cau truy van loc theo thuoc tinh
        $params['attributeQuery'] = $this->attributeQuery(request()->input('attributes'));
        // Lam cau truy van loc theo danh gia
        $params['rateQuery'] = $this->rateQuery(request()->input('rate'));
        // Lam cau truy van loc theo danh muc
        $params['productCatalogueQuery'] = $this->productCatalogueQuery(request()->input('product_catalogue_id'));
        // Ket hop tat ca cac cau truy van
        $query = $this->compineFilterQuery($params);

        $perpage = request('perpage', 18);
        $products = $this->productRepository->filter($query, $perpage);
        $paginate = $products->links('pagination::bootstrap-5')->render();

        return [
            'code' => empty($products) ? 400 : 200,
            'message' => empty($products) ? 'Không tìm thấy sản phẩm' : 'OK',
            'data' => $products ?? [],
            'paginate' => $paginate ?? [],
        ];
    }


    private function compineFilterQuery($params)
    {
        $query['groupBy'] = [
            'products.id',
            'products.price',
            'products.image',
        ];
        foreach ($params  as $array) {
            foreach ($array as $key => $value) {
                if (!isset($query[$key])) {
                    $query[$key] = [];
                }
                if (!is_null($value) && !empty($value)) {
                    if (is_array($value)) {
                        $query[$key] = array_merge($query[$key], $value);
                    } else {
                        $query[$key][] = $value;
                    }
                }
            }
        }

        $where = [
            'products.publish' => ['=', config('apps.general.defaultPublish')]
        ];

        $query['where'] += $where;

        return $query;
    }
    private function productCatalogueQuery($catalogueId)
    {
        $query = [
            'select' => null,
            'join' => null,
            'whereRaw' => null
        ];
        if ($catalogueId > 0) {
            $query['join'] = [
                'product_catalogue_product as pcp' => ['pcp.product_id', '=', 'products.id'],
            ];
            $query['whereRaw'] = [
                [
                    'pcp.product_catalogue_id IN (
                        SELECT id 
                        FROM product_catalogues
                        WHERE `left` >= (SELECT `left` FROM product_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM product_catalogues as pc WHERE pc.id = ?)
                    )',
                    [$catalogueId, $catalogueId]
                ]
            ];
        }
        return $query;
    }

    private function rateQuery($rates)
    {
        $query = [
            'select' => null,
            'join' => null,
            'having' => null,
            'where' => null
        ];

        if (!empty($rates)) {

            $query['select'] = ['AVG(comments.rate) as avg_rate'];
            $query['join'] = [
                'comments' => ['comments.commentable_id', '=', 'products.id'],
            ];


            $rateCondition = [];
            $bildings = [];

            foreach ($rates as $key => $rate) {
                if ($rate != 5) {
                    $minRate = $rate . '.1';
                    $maxRate = $rate . '.9';
                    $rateCondition[] = '(AVG(comments.rate) BETWEEN ? AND ?)';
                    $bildings[] = $minRate;
                    $bildings[] = $maxRate;
                } else {
                    $rateCondition[] = 'AVG(comments.rate) = ?';
                    $bildings[] = 5;
                }
            }

            $query['where'] = function ($query) {
                $query->where('comments.commentable_type', '=', 'App\Models\Product');
            };

            $query['having'] = function ($query) use ($rateCondition, $bildings) {
                $query->havingRaw(implode(' OR ', $rateCondition), $bildings);
            };
        }
        return $query;
    }

    private function attributeQuery($attributes)
    {


        $query = [
            'select' => null,
            'join' => null,
            'where' => null,
            'groupBy' => null
        ];



        if (!empty($attributes)) {

            $query['groupBy'] = [
                'pv.album',
                'pv.code',
                'pv.price',
                'pl.name',
                'pvl.name',
                'pl.canonical',
            ];
            $query['select'] = [
                'pv.code',
                'pv.price as variant_price',
                'pv.album as variant_album',
                'pl.canonical',
                "CONCAT(pl.name, ' - ', COALESCE(pvl.name)) as variant_name",
            ];
            $query['join'] = [
                'product_language as pl' => ['pl.product_id', '=', 'products.id'],
                'product_variants as pv' => ['pv.product_id', '=', 'products.id'],
                'product_variant_language as pvl' => ['pv.id', '=', 'pvl.product_variant_id'],

            ];
            foreach ($attributes as $key => $attribute) {
                foreach ($attributes as $key => $attribute) {
                    $joinKey = "tbl$key";
                    $query['join']["product_variant_attribute as {$joinKey}"] = ["$joinKey.product_variant_id", '=', 'pv.id'];

                    $query['where'][] = function ($query) use ($attribute, $joinKey) {
                        foreach ($attribute as $attr) {
                            $query->orWhere("{$joinKey}.attribute_id", $attr);
                        }
                    };
                }
            }
        }

        return $query;
    }

    private function priceQuery($price)
    {
        $price = $this->formatPriceFilter($price);
        $minPrice = $price['min'];
        $maxPrice = $price['max'];

        $query = [
            'select' => null,
            'join' => null,
            'having' => null
        ];

        if ($maxPrice > $minPrice) {
            $query['join'] = [
                'promotion_product_variant as ppv' => ['ppv.product_id', '=', 'products.id'],
                'promotions' => ['promotions.id', '=', 'ppv.promotion_id'],
            ];

            $query['select'] = "
                (products.price - MAX(
                    IF(promotions.max_discount != 0,
                        LEAST(
                            CASE
                            WHEN promotions.discount_type = 'cast' THEN promotions.discount_value
                            WHEN promotions.discount_type = 'percent' THEN promotions.discount_value * products.price / 100
                            ELSE 0
                            END,
                            promotions.max_discount
                        ),
                        CASE 
                            WHEN promotions.discount_type = 'cast' THEN promotions.discount_value
                            WHEN promotions.discount_type = 'percent' THEN promotions.discount_value * products.price / 100
                            ELSE 0
                            END
                        )
                    )) as discounted_price
                ";

            $query['having'] = function ($query) use ($minPrice, $maxPrice) {
                $query->havingBetween('discounted_price', [$minPrice, $maxPrice]);
            };

            return $query;
        }
    }

    private function formatPriceFilter($price)
    {
        if (!is_array($price)) {
            return [
                'min' => 0,
                'max' => 0
            ];
        }
        foreach ($price as $key => $value) {
            $cleanedString = str_replace("₫", "", $value);
            $formattedAmount = convertPrice($cleanedString);
            $price[$key] = $formattedAmount;
        }

        return $price;
    }
}
