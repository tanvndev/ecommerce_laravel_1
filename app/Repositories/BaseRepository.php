<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }

    function all()
    {
        return $this->model->all();
    }
    function findById($modelId, $column = ['*'], $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }
    function create($payload = [])
    {
        $create = $this->model->create($payload);
        return $create->fresh();
    }
    public function update($modelId, $payload = [])
    {
        $update = $this->findById($modelId);
        return $update->update($payload);
    }
}
