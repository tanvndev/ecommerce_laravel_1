<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Widget;
use App\Repositories\Interfaces\WidgetRepositoryInterface;

class WidgetRepository extends BaseRepository implements WidgetRepositoryInterface
{
    protected $model;
    public function __construct(
        Widget $model
    ) {
        $this->model = $model;
    }

    public function getWidgetWhereIn($keyword = [], $whereInField = 'keyword')
    {
        return $this->model
            ->where('publish', config('apps.general.defaultPublish'))
            ->whereIn($whereInField, $keyword)
            ->orderByRaw("FIELD(keyword, '" . implode("','", $keyword) . "')")
            ->get();
    }
}
