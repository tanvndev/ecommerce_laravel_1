<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\CustomerCatalogue;
use App\Repositories\Interfaces\CustomerCatalogueRepositoryInterface;

class CustomerCatalogueRepository extends BaseRepository implements CustomerCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        CustomerCatalogue $model
    ) {
        $this->model = $model;
    }
}
