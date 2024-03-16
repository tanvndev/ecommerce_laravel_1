<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\PostCatalogue;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface;

class PostCatalogueRepository extends BaseRepository implements PostCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        PostCatalogue $model
    ) {
        $this->model = $model;
    }

    public function pagination(
        $column = ['*'],
        $condition = [],
        $join = [],
        $perPage = 1,
        $relations = [],
        $orderBy = [],
        $where = []
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {

            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'like', '%' . $condition['keyword'] . '%');
            }

            if (isset($condition['publish']) && $condition['publish'] != '-1') {
                $query->where('publish', $condition['publish']);
            }
        });

        if (isset($relations) && !empty($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
            }
        }

        // dd($join);
        // 'table_name_1' => ['constraint1', 'constraint2'],
        if (!empty($join)) {
            foreach ($join as $table => $constraints) {
                $query->join($table, ...$constraints);
            }
        }

        // 'column' => 'value',
        if (!empty($where)) {
            foreach ($where as $column => $value) {
                $query->where($column, $value);
            }
        }

        // OrderBy

        //  'name' => 'ASC',
        //  'created_at' => 'DESC'
        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy('id', 'DESC');
        }

        return $query->paginate($perPage)->withQueryString();
        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
    }

    public function getPostCatalogueLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'post_catalogues.id',
            'post_catalogues.parent_id',
            'post_catalogues.publish',
            'post_catalogues.image',
            'post_catalogues.icon',
            'post_catalogues.album',
            'post_catalogues.follow',
            'tb2.name',
            'tb2.description',
            'tb2.content',
            'tb2.meta_keyword',
            'tb2.meta_title',
            'tb2.meta_description',
            'tb2.canonical',
        ];
        return $this->model
            ->select($select)
            ->join('post_catalogue_language as tb2', 'post_catalogues.id', '=', 'tb2.post_catalogue_id')
            ->where('tb2.language_id', $languageId)
            ->findOrFail($id);
    }
}
