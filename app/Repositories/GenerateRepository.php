<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Generate;
use App\Repositories\Interfaces\GenerateRepositoryInterface;

class GenerateRepository extends BaseRepository implements GenerateRepositoryInterface
{
    protected $model;
    public function __construct(
        Generate $model
    ) {
        $this->model = $model;
    }
}
