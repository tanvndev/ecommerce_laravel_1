<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\ProductCatalogue;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;

class ProductCatalogueRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        ProductCatalogue $model
    ) {
        $this->model = $model;
    }

    public function getProductCatalogueLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'product_catalogues.id',
            'product_catalogues.parent_id',
            'product_catalogues.left',
            'product_catalogues.right',
            'product_catalogues.publish',
            'product_catalogues.image',
            'product_catalogues.icon',
            'product_catalogues.album',
            'product_catalogues.follow',
            'product_catalogues.attribute',
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
            ->join('product_catalogue_language as tb2', 'product_catalogues.id', '=', 'tb2.product_catalogue_id')
            ->where('tb2.language_id', $languageId)
            ->find($id);
    }
}
