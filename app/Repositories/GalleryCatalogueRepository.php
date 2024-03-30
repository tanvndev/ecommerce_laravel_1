<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\GalleryCatalogue;
use App\Repositories\Interfaces\GalleryCatalogueRepositoryInterface;

class GalleryCatalogueRepository extends BaseRepository implements GalleryCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        GalleryCatalogue $model
    ) {
        $this->model = $model;
    }

    public function getGalleryCatalogueLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'gallery_catalogues.id',
            'gallery_catalogues.parent_id',
            'gallery_catalogues.publish',
            'gallery_catalogues.image',
            'gallery_catalogues.icon',
            'gallery_catalogues.album',
            'gallery_catalogues.follow',
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
            ->join('gallery_catalogue_language as tb2', 'gallery_catalogues.id', '=', 'tb2.gallery_catalogue_id')
            ->where('tb2.language_id', $languageId)
            ->find($id);
    }
}
