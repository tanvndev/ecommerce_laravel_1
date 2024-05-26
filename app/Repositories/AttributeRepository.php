<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\Interfaces\AttributeRepositoryInterface;

class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{
    protected $model;
    public function __construct(
        Attribute $model
    ) {
        $this->model = $model;
    }

    public function getAttributeLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'attributes.id',
            'attributes.attribute_catalogue_id',
            'attributes.publish',
            'attributes.image',
            'attributes.icon',
            'attributes.album',
            'attributes.follow',
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
            ->join('attribute_language as tb2', 'attributes.id', '=', 'tb2.attribute_id')
            ->where('tb2.language_id', $languageId)
            ->with('attribute_catalogues')
            ->find($id);
    }

    public function searchAttributes($search = '', $option = '', $languageId = 0)
    {
        return $this->model->select('id')
            ->whereHas('attribute_catalogues', function ($query) use ($option) {
                $query->where('attribute_catalogue_id', $option['attributeCatalogueId']);
            })->whereHas('attribute_language', function ($query) use ($search, $languageId) {
                $query
                    ->select('name')
                    ->where('language_id', $languageId);
                $query->where('name', 'like', '%' . $search . '%');
            })->get();
    }

    public function findAttributeByIdArray($attributeArr = [], $languageId = 1)
    {
        return $this->model
            ->select('attributes.id', 'attributes.attribute_catalogue_id', 'tb2.name')
            ->join('attribute_language as tb2', 'attributes.id', '=', 'tb2.attribute_id')
            ->whereIn('id', $attributeArr)
            ->where('tb2.language_id', $languageId)
            ->where('publish', config('apps.general.defaultPublish'))
            ->get();
    }
}
