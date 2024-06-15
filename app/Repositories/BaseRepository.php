<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }

    public function all($relation = [], $column = ['*'], $orderBy = null)
    {
        $query = $this->model->select($column);

        if (!is_null($orderBy)) {
            $query->customOrderBy($orderBy);
        }

        if (!empty($relation)) {
            return $query->relation($relation)->get();
        }


        return $query->get();
    }
    public function findById($modelId, $column = ['*'], $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

    public function findByWhere($conditions = [], $column = ['*'], $relation = [], $all = false, $orderBy = null, $whereInParams = [], $withCount = [])
    {
        $query = $this->model->select($column);

        if (!empty($relation)) {
            $query->relation($relation);
        }

        $query->customWhere($conditions);

        if (!empty($whereInParams)) {
            $query->whereIn($whereInParams['field'], $whereInParams['value']);
        }

        if (!is_null($orderBy)) {
            $query->customOrderBy($orderBy);
        }

        if (!empty($withCount)) {
            $query->withCount($withCount);
        }

        return $all ? $query->get() : $query->first();
    }



    public function findByWhereHas($condition = [], $column = ['*'], $relation = [], $alias = '', $all = false)
    {

        $query = $this->model->select($column);
        $query->whereHas($relation, function ($query) use ($condition, $alias) {
            foreach ($condition as $key => $value) {
                $query->where($alias . '.' . $key, $value);
            }
        });

        return $all ? $query->get() : $query->first();
    }

    public function pagination(
        $column = ['*'],
        $condition = [],
        $perPage = 1,
        $orderBy = ['id' => 'DESC'],
        $join = [],
        $relations = [],
        $groupBy = [],
        $rawQuery = [],
    ) {
        $query = $this->model->select($column);
        $query->keyword($condition['keyword'] ?? null)
            ->publish($condition['publish'] ?? null)
            ->customWhere($condition['where'] ?? null)
            ->customWhereRaw($rawQuery['whereRaw'] ?? null)
            ->relation($relations ?? null)
            ->relationCount($relations ?? null)
            ->customJoin($join ?? null)
            ->customGroupBy($groupBy ?? null)
            ->customOrderBy($orderBy ?? null);

        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
        return $query->paginate($perPage)->withQueryString();
    }

    public function create($payload = [])
    {
        $create = $this->model->create($payload);
        return $create->fresh();
    }

    public function createBatch($payload = [])
    {
        return $this->model->insert($payload);
    }

    public function createPivot($model, $payload = [], $relation = '')
    {
        // attach($model->id, $payload) là phương thức được gọi để thêm một bản ghi mới vào bảng pivot.
        return $model->{$relation}()->attach($model->id, $payload);
    }

    public function update($modelId, $payload = [])
    {
        $model = $this->findById($modelId);
        return $model->update($payload);
    }

    public function save($modelId, $payload = [])
    {
        $model = $this->findById($modelId);
        $model->fill($payload);
        $model->save();
        return $model;
    }

    // Truyen vao ham updateByWhereIn (Field name, array field name, va mang data can update)
    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }
    public function updateByWhere($conditions = [], $payload = [])
    {
        $query = $this->model->newQuery();
        return  $query->customWhere($conditions)->update($payload);
    }

    public function updateOrInsert($payload = [], $conditions = [])
    {
        $this->model->updateOrInsert($conditions, $payload);
    }

    public function delete($modelId)
    {
        $delete = $this->findById($modelId);
        return $delete->delete();
    }

    public function deleteByWhere($conditions = [])
    {
        $query = $this->model->newQuery();
        return  $query->customWhere($conditions)->delete();
    }


    // Xoá cứng
    public function forceDelete($modelId)
    {
        $delete = $this->findById($modelId);
        return $delete->forceDelete();
    }

    public function forceDeleteByWhere($conditions)
    {
        $query = $this->model->newQuery();
        return  $query->customWhere($conditions)->forceDelete();
    }




    public function findWidgetItem($condition = [], $column = ['*'], $alias = '', $languageId = 1)
    {
        return $this->model
            ->select($column)
            ->with([
                'languages' => function ($query) use ($languageId) {
                    $query->where('language_id', $languageId);
                }
            ])
            ->when($condition, function ($query) use ($condition, $alias) {
                $query->whereHas('languages', function ($query) use ($condition, $alias) {
                    foreach ($condition as $column => $value) {
                        $query->where($alias . '.' . $column, ...$value);
                    }
                });
            })
            ->get();
    }

    public function recursiveCategory($ids = [], $table)
    {
        $ids = (array) $ids;
        // Kiểm tra và xác thực đầu vào
        if (empty($ids) || !is_array($ids)) {
            throw new InvalidArgumentException('The first parameter should be a non-empty array of IDs.');
        }

        // Xác thực tên bảng
        if (!preg_match('/^[a-zA-Z_]+$/', $table)) {
            throw new InvalidArgumentException('Invalid table name.');
        }

        $table = $table . '_catalogues';

        // Tạo chuỗi placeholders
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        // Truy vấn SQL
        $query = "
        WITH RECURSIVE category_tree AS (
            SELECT id, parent_id, deleted_at 
            FROM $table 
            WHERE id IN ($placeholders) AND deleted_at IS NULL
            UNION ALL
            SELECT c.id, c.parent_id, c.deleted_at
            FROM $table as c
            INNER JOIN category_tree ct ON c.parent_id = ct.id
        )
        SELECT id FROM category_tree WHERE deleted_at IS NULL
    ";

        // Thực thi truy vấn với các giá trị id
        return DB::select($query, $ids);
    }

    public function findObjectByCategoryIds($ids, $model, $languageId)
    {

        $query = $this->model
            ->select($model . 's.*')
            ->where(
                'publish',
                config('apps.general.defaultPublish')
            )
            ->with('languages', function ($query) use ($languageId) {
                $query->where('language_id', $languageId ?? 1);
            });

        if ($model == 'product') {
            $query->with('product_variants');
        }
        $query->join($model . '_catalogue_' . $model . ' as tb2', 'tb2.' . $model . '_id', '=', $model . 's.id')
            ->whereIn('tb2.' . $model . '_catalogue_id', $ids)
            ->orderBy('order', 'desc')
            ->get();

        return $query;
    }

    public function breadcrumb($model, $languageId = 1)
    {
        $query = $this->findByWhere([
            'left' => ['<=', $model->left],
            'right' => ['>=', $model->right],
            'publish' => ['=', config('apps.general.defaultPublish')]
        ], ['*'], [
            [
                'languages' => function ($query) use ($languageId) {
                    $query->where('language_id', $languageId);
                }
            ]
        ], true, ['left' => 'asc']);

        return $query;
    }
}
