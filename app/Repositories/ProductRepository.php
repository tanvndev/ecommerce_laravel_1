<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model;
    public function __construct(
        Product $model
    ) {
        $this->model = $model;
    }

    public function getProductLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'products.id',
            'products.parent_id',
            'products.publish',
            'products.image',
            'products.icon',
            'products.album',
            'products.follow',
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
            ->with('product_catalogues')
            ->find($id);
    }
}
