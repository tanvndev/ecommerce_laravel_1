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

    // Truyen vao ham updateByWhereIn (Field name, array field name, va mang data can update)
    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }

    public function delete($modelId)
    {
        $delete = $this->findById($modelId);
        return $delete->delete();
    }

    // Xoá cứng
    public function forceDelete($modelId)
    {
        $delete = $this->findById($modelId);
        return $delete->forceDelete();
    }


    public function pagination(
        $column = ['*'],
        $condition = [],
        $perPage = 1,
        $orderBy = ['id' => 'DESC'],
        $join = [],
        $relations = [],
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {

            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'like', '%' . $condition['keyword'] . '%');
            }

            if (isset($condition['publish']) && $condition['publish'] != '-1') {
                $query->where('publish', $condition['publish']);
            }

            // 'column' => 'value',
            // 'column' => ['<>', 100]
            if (isset($condition['where']) && !empty($condition['where'])) {
                foreach ($condition['where'] as $column => $value) {
                    $query->where($column, $value);
                }
            }
        });


        if (isset($relations) && !empty($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
            }
        }

        // 'table_name_1' => ['constraint1', 'constraint2'],
        if (!empty($join)) {
            foreach ($join as $table => $constraints) {
                $query->join($table, ...$constraints);
            }
        }

        // OrderBy
        //  'name' => 'ASC',
        //  'created_at' => 'DESC'
        if (!empty($orderBy) && is_array($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy('id', 'DESC');
        }

        return $query->paginate($perPage)->withQueryString();
        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
    }

    public function createPivot($model, $payload = [], $relation = '')
    {
        // attach($model->id, $payload) là phương thức được gọi để thêm một bản ghi mới vào bảng pivot.
        return $model->{$relation}()->attach($model->id, $payload);
    }
}
