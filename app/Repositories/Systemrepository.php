<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\System;
use App\Repositories\Interfaces\SystemRepositoryInterface;

class SystemRepository extends BaseRepository implements SystemRepositoryInterface
{
    protected $model;
    public function __construct(
        System $model
    ) {
        $this->model = $model;
    }
}
