<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Source;
use App\Repositories\Interfaces\SourceRepositoryInterface;

class SourceRepository extends BaseRepository implements SourceRepositoryInterface
{
    protected $model;
    public function __construct(
        Source $model
    ) {
        $this->model = $model;
    }

    public function getSourceLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'sources.id',
            'sources.source_catalogue_id',
            'sources.publish',
            'sources.image',
            'sources.icon',
            'sources.album',
            'sources.follow',
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
            ->join('source_language as tb2', 'sources.id', '=', 'tb2.source_id')
            ->where('tb2.language_id', $languageId)
            ->with('source_catalogues')
            ->find($id);
    }
}
