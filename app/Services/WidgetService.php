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
                session('currentLanguage') ?? 1 => request('description'),
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
    public function findWidgetByKeyword($keyword, $params = [])
    {
        $widget = $this->widgetRepository->findByWhere([
            'keyword' => ['=', $keyword],
            'publish' => ['=', config('apps.general.defaultPublish')],
        ]);

        if (is_null($widget)) {
            return false;
        }

        $model = $widget->model;
        $modelId = $widget->model_id;

        $relation = [];
        $withCount = [];

        $relation[] = ['languages' => function ($query) {
            $query->where('language_id', session('currentLanguage', 1));
        }];


        // Neu co param object thi se lay ra cac san pham ben trong danh muc do
        if (strpos($model, 'Catalogue') !== false && isset($params['object'])) {
            $relatedModel = lcfirst(str_replace('Catalogue', '', $model)) . 's';

            $relation[] = [$relatedModel => function ($query) use ($params) {
                $query->limit($params['limit'] ?? 10)
                    ->whereHas('languages', function ($query) {
                        $query->where('language_id', session('currentLanguage', 1));
                    })
                    ->where('publish', config('apps.general.defaultPublish'))
                    ->take($params['limit'] ?? 10)
                    ->orderBy('order', 'DESC');
            }];

            // Neu co count Object se dem so san pham trong danh muc do
            if (isset($params['countObject'])) {
                $withCount[] = $relatedModel;
            }
        }


        $object = $this->getRepositoryInstance($model)->findByWhere([
            'publish' => ['=', config('apps.general.defaultPublish')],
        ], ['*'], $relation, true, [], ['field' => 'id', 'value' => $modelId], $withCount);

        $model = lcfirst(str_replace('Catalogue', '', $model));

        // Neu la san pham thi se lay ra cac promotion
        if ($model == 'product' && isset($params['object']) && count($object)) {
            foreach ($object as $key => $value) {
                $productId = $value->products->pluck('id')->toArray();
                if (!empty($productId)) {
                    $value->products = $this->productService->combineProductAndPromotion($productId, $value->products);
                }

                // Lay ra cac danh muc con cua danh muc do
                if (isset($params['children'])) {
                    $condition = [
                        'left' => ['>', $value->left],
                        'right' => ['<', $value->right],
                        'publish' => ['=', config('apps.general.defaultPublish')]
                    ];
                    $value->childrens = $this->productCatalogueRepository->findByWhere(
                        $condition,
                        ['*'],
                        [],
                        true
                    );
                }
            }
        }

        return $object;
    }
}
