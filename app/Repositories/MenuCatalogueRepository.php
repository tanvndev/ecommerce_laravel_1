<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\MenuCatalogue;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface;

class MenuCatalogueRepository extends BaseRepository implements MenuCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        MenuCatalogue $model
    ) {
        $this->model = $model;
    }
}
