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
}
