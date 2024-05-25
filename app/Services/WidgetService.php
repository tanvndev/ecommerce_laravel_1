<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\WidgetServiceInterface;
use App\Repositories\Interfaces\WidgetRepositoryInterface as WidgetRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use Illuminate\Support\Facades\DB;

class WidgetService extends BaseService implements WidgetServiceInterface
{
    protected $widgetRepository;
    protected $promotionRepository;
    protected $productService;
    protected $productCatalogueRepository;

    public function __construct(
        WidgetRepository $widgetRepository,
        PromotionRepository $promotionRepository,
        ProductService $productService,
        ProductCatalogueRepository $productCatalogueRepository,
    ) {
        parent::__construct();
        $this->widgetRepository = $widgetRepository;
        $this->productService = $productService;
        $this->promotionRepository = $promotionRepository;
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->controllerName = 'WidgetController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),

        ];
        $select = [
            'id',
            'name',
            'keyword',
            'model',
            'publish',
            'short_code',
            'description'
        ];

        //////////////////////////////////////////////////////////
        $widgets = $this->widgetRepository->pagination(
            $select,
            $condition,
            request('perpage'),
        );

        // dd($widgets);
        return $widgets;
    }

    public function create()
    {

        DB::beginTransaction();
        try {

            $payload = request()->only('name', 'keyword', 'album', 'short_code', 'model');
            $payload['model_id'] = request('modelItem.id');
            $payload['description'] = [
                session('currentLanguage', 1) => request('description'),
            ];

            $this->widgetRepository->create($payload);

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

            $payload = request()->only('name', 'keyword', 'album', 'short_code', 'model');
            $payload['model_id'] = request('modelItem.id');

            // Lấy mô tả hiện tại của widget
            $widget = $this->widgetRepository->findById($id);
            $widgetDescription = $widget->description;

            $widgetDescription[session('currentLanguage')] = request('description');

            // Cập nhật mô tả của widget với mô tả mới
            $payload['description'] = $widgetDescription;

            $this->widgetRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->widgetRepository->delete($id);

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

    public function saveTranslate()
    {
        DB::beginTransaction();
        try {
            $widget = $this->widgetRepository->findById(request('widgetId'));

            // Lấy ra danh sách ngôn ngữ
            $widgetDescription = $widget->description;

            // Cập nhật mô tả dịch cho ngôn ngữ cụ thể
            $widgetDescription[request('languageId')] = request('translate_description');

            // Cập nhật mô tả của widget với mô tả dịch mới
            $widget->description = $widgetDescription;
            $widget->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    // Frontend services


    public function getWidget($params = [])
    {
        $whereIn = [];
        $whereInField = 'keyword';
        if (count($params)) {
            foreach ($params as $key => $value) {
                $whereIn[] = $value['keyword'];
            }
        }
        // Lay ra toan bo widget
        $widgets = $this->widgetRepository->getWidgetWhereIn($whereIn, $whereInField);

        if (is_null($widgets)) {
            return false;
        }

        $temp = [];
        foreach ($widgets as $key => $widget) {
            if (!isset($params[$key])) {
                continue;
            }

            $agrument = $this->widgetAgrument($widget, $params[$key]);
            $repository = $this->getRepositoryInstance($widget->model);
            $object = $repository->findByWhere(...$agrument);

            $model = lcfirst(str_replace('Catalogue', '', $widget->model));

            if (isset($params[$key]['object']) && count($object)) {

                // Lay ra cac danh muc con cua danh muc do
                if (isset($params[$key]['children']) && strpos($widget->model, 'Catalogue') !== false) {
                    $repository2 = $this->getRepositoryInstance(ucfirst($model));
                    $replace = $model . 's';
                    foreach ($object as $valueObject) {

                        $agrumentChildren = $this->childrenAgrument([$valueObject->id]);
                        $valueObject->childrens = $repository->findByWhere(...$agrumentChildren);

                        // Lay ra san pham cua danh muc do
                        $childIds = $repository->recursiveCategory($valueObject->id, $model);
                        $ids = [];
                        foreach ($childIds as $childId) {
                            $ids[] = $childId->id;
                        }

                        // dd($valueObject);
                        if ($valueObject->right - $valueObject->left > 1) {
                            $valueObject->{$replace} = $repository2->findObjectByCategoryIds($ids, $model, session('currentLanguage', 1));
                        }
                    }
                }

                // Lấy ra promotion của sản phẩm tương ứng nếu có
                if ($model == 'product' && isset($params[$key]['object']) && count($object) && isset($params[$key]['promotion'])) {
                    $productIds = [];

                    if ($widget->model == 'Product') {
                        $productIds = $object->pluck('id')->toArray();
                        if (!empty($productIds)) {
                            $this->productService->combineProductAndPromotion($productIds, $object);
                        }
                    } else {
                        foreach ($object as $valueProduct) {
                            $productIds = $valueProduct->products->pluck('id')->toArray();
                            if (!empty($productIds)) {
                                $valueProduct->products = $this->productService->combineProductAndPromotion($productIds, $valueProduct->products);
                            }
                        }
                    }
                }
                $widget->object = $object;
            }

            $temp[$widget->keyword] = $widgets[$key];
        }
        return $temp;
    }

    private function childrenAgrument($objectId)
    {
        return [
            'conditions' => [
                'publish' => ['=', config('apps.general.defaultPublish')]
            ],
            'column' => '*',
            'relation' => [
                [
                    'languages' => function ($query) {
                        $query->where('language_id', session('currentLanguage', 1));
                    }
                ]
            ],
            'all' => true,
            'orderBy' => null,
            'whereInParams' => ['field' => 'parent_id', 'value' => $objectId],
        ];
    }

    private function widgetAgrument($widget, $param)
    {

        $relation[] = ['languages' => function ($query) {
            $query->where('language_id', session('currentLanguage', 1));
        }];

        $model = $widget->model;
        $modelId = $widget->model_id;

        $withCount = [];

        // Neu co param object thi se lay ra cac san pham ben trong danh muc do
        if (strpos($model, 'Catalogue') !== false && isset($param['object'])) {
            $relatedModel = lcfirst(str_replace('Catalogue', '', $model)) . 's';

            $relation[] = [$relatedModel => function ($query) use ($param, $relatedModel) {
                $query
                    ->limit($param['limit'] ?? 10)
                    ->with('languages', function ($query) {
                        $query->where('language_id', session('currentLanguage', 1));
                    });

                if ($relatedModel == 'products') {
                    $query->with('product_variants');
                }

                $query->where('publish', config('apps.general.defaultPublish'))
                    ->take($param['limit'] ?? 10)
                    ->orderBy('order', 'DESC');
            }];

            // Neu co count Object se dem so san pham trong danh muc do
            if (isset($param['countObject'])) {
                $withCount[] = $relatedModel;
            }
        }

        // Lay them bien the cho san pham
        if ($model == 'Product' && isset($param['object'])) {
            $relation[] = 'product_variants';
        }

        return [
            'conditions' => [
                'publish' => ['=', config('apps.general.defaultPublish')],
            ],
            'column' => '*',
            'relation' => $relation,
            'all' => true,
            'orderBy' => null,
            'whereInParams' => ['field' => 'id', 'value' => $modelId],
            'withCount' => $withCount
        ];
    }
}
