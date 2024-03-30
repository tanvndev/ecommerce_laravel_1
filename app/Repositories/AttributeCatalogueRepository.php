<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\AttributeCatalogue;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface;

class AttributeCatalogueRepository extends BaseRepository implements AttributeCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        AttributeCatalogue $model
    ) {
        $this->model = $model;
    }

    public function getAttributeCatalogueLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'attributeCatalogues.id',
            'attributeCatalogues.parent_id',
            'attributeCatalogues.publish',
            'attributeCatalogues.image',
            'attributeCatalogues.icon',
            'attributeCatalogues.album',
            'attributeCatalogues.follow',
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
            ->join('attributeCatalogue_language as tb2', 'attributeCatalogues.id', '=', 'tb2.attributeCatalogue_id')
            ->where('tb2.language_id', $languageId)
            ->find($id);
    }
}
