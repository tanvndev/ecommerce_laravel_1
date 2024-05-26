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

    public function getAttributeCatalogueLanguageById($id = 0, $languageId = 1)
    {
        $select = [
            'attribute_catalogues.id',
            'attribute_catalogues.parent_id',
            'attribute_catalogues.publish',
            'attribute_catalogues.image',
            'attribute_catalogues.icon',
            'attribute_catalogues.album',
            'attribute_catalogues.follow',
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
            ->join('attribute_catalogue_language as tb2', 'attribute_catalogues.id', '=', 'tb2.attribute_catalogue_id')
            ->where('tb2.language_id', $languageId)
            ->find($id);
    }

    public function getAll($languageId = 0)
    {
        $query = $this->model->select();
        return $query->with(['attribute_catalogue_language' => function ($query) use ($languageId) {
            $query->where('language_id', $languageId);
        }])->get();
    }

    public function getAttributeCatalogueLanguageWhereIn($whereIn = [], $whereInField = 'id', $languageId = 1)
    {
        $query = $this->model
            ->select(
                'attribute_catalogues.id',
                'tb2.name',

            )
            ->where('publish', config('apps.general.defaultPublish'))
            ->join('attribute_catalogue_language as tb2', 'attribute_catalogues.id', '=', 'tb2.attribute_catalogue_id')
            ->where('tb2.language_id', $languageId)
            ->whereIn($whereInField, $whereIn)
            ->get();
        return $query;
    }
}
