<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model;
    public function __construct(
        Product $model
    ) {
        $this->model = $model;
    }

    public function getProductLanguageById($id = 0, $languageId = 1)
    {
        $select = [
            'products.id',
            'products.product_catalogue_id',
            'products.publish',
            'products.image',
            'products.icon',
            'products.album',
            'products.follow',
            'products.price',
            'products.sku',
            'products.origin',
            'products.attributeCatalogue',
            'products.attribute',
            'products.variant',
            'tb2.name',
            'tb2.description',
            'tb2.content',
            'tb2.meta_keyword',
            'tb2.meta_title',
            'tb2.meta_description',
            'tb2.canonical',
        ];
        return $this->model
            ->select($select)
            ->join('product_language as tb2', 'products.id', '=', 'tb2.product_id')
            ->where('tb2.language_id', $languageId)
            ->with([
                'product_catalogues',
                'product_variants.attributes.languages' => function ($query) use ($languageId) {
                    $query->where('language_id', $languageId);
                },
                'comments' => function ($query) {
                    $query->where('publish', config('apps.general.defaultPublish'))
                        ->orderBy('created_at', 'desc');
                }
            ]) //Lấy từ product_variants.attributes.languages để lấy những attribute có trong product
            ->find($id);
    }

    public function findProductForPromotion($condition = [], $relation = [])
    {
        $query = $this->model->newQuery();
        $query->select(
            'products.id',
            'products.image',
            'tb2.name',
            'tb3.id as product_variant_id',
            'tb3.uuid',
            DB::raw("CONCAT(tb2.name, ' - ', COALESCE(tb4.name, 'Default')) as variant_name"),
            DB::raw("COALESCE(tb3.sku, products.sku) as sku"),
            DB::raw("COALESCE(tb3.price, products.price) as price")

        )
            ->where('tb3.deleted_at', null)
            ->join('product_language as tb2', 'products.id', '=', 'tb2.product_id')
            ->leftJoin('product_variants as tb3', 'products.id', '=', 'tb3.product_id')
            ->leftJoin('product_variant_language as tb4', 'tb3.id', '=', 'tb4.product_variant_id');

        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $column => $value) {
                // dd($column, ...$value);
                $query->where($column, ...$value);
            }
        }

        if (count($relation)) {
            $query->with($relation);
        }

        $query->orderBy('products.id', 'DESC');

        // return $query->paginate(10);
    }

    public function filter($params, $perPage = 18)
    {
        // dd($params);
        $query = $this->model->newQuery();
        $query->select(
            'products.id',
            'products.price',
            'products.image',
        );

        if (isset($params['select']) && !empty($params['select'])) {
            foreach ($params['select'] as $param) {
                $query->selectRaw($param);
            }
        }
        if (isset($params['join']) && !empty($params['join'])) {
            foreach ($params['join'] as $table => $constraints) {
                $query->leftJoin($table, ...$constraints);
            }
        }

        if (isset($params['where']) && !empty($params['where'])) {
            foreach ($params['where'] as $column => $value) {
                // dd($column, ...$value);
                if (is_array($value)) {
                    $query->where($column, ...$value);
                } else {
                    $query->where($value);
                }
            }
        }

        if (isset($params['having']) && !empty($params['having'])) {
            foreach ($params['having'] as $value) {
                $query->having($value);
            }
        }

        if (isset($params['whereRaw']) && !empty($params['whereRaw'])) {
            $query->customWhereRaw($params['whereRaw'] ?? null);
        }

        if (isset($params['groupBy']) && !empty($params['groupBy'])) {
            $query->customGroupBy($params['groupBy'] ?? null);
        }

        $query->with('languages', function ($query) {
            $query->where('language_id', session('currentLanguage', 1));
        });

        // dd($query->toSql());

        return $query->paginate($perPage);
    }
}
