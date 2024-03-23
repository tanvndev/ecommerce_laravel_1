<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Router;
use App\Repositories\Interfaces\RouterRepositoryInterface;

class RouterRepository extends BaseRepository implements RouterRepositoryInterface
{
    protected $model;
    public function __construct(
        Router $model
    ) {
        $this->model = $model;
    }
}
