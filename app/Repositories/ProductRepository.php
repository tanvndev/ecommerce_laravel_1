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
        // dd($query->toSql());

        return $query->paginate(10);
    }
}
