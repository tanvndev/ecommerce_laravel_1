<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Slide;
use App\Repositories\Interfaces\SlideRepositoryInterface;

class SlideRepository extends BaseRepository implements SlideRepositoryInterface
{
    protected $model;
    public function __construct(
        Slide $model
    ) {
        $this->model = $model;
    }

    public function getSlideLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'slides.id',
            'slides.slide_catalogue_id',
            'slides.publish',
            'slides.image',
            'slides.icon',
            'slides.album',
            'slides.follow',
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
            ->join('slide_language as tb2', 'slides.id', '=', 'tb2.slide_id')
            ->where('tb2.language_id', $languageId)
            ->with('slide_catalogues')
            ->find($id);
    }
}
