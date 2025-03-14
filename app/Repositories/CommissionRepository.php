<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Commission;
use App\Repositories\Interfaces\CommissionRepositoryInterface;

class CommissionRepository extends BaseRepository implements CommissionRepositoryInterface
{
    protected $model;
    public function __construct(
        Commission $model
    ) {
        $this->model = $model;
    }
}
