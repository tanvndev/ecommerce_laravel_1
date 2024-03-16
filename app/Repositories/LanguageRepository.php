<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    protected $model;
    public function __construct(
        Language $model
    ) {
        $this->model = $model;
    }

    public function pagination(
        $column = ['*'],
        $condition = [],
        $perPage = 1,
        $orderBy = ['id' => 'DESC'],
        $join = [],
        $relations = [],
    ) {
        $query = $this->model->select($column)->orderBy('id', 'desc')->where(function ($query) use ($condition) {

            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'like', '%' . $condition['keyword'] . '%')
                    ->orWhere('canonical', 'like', '%' . $condition['keyword'] . '%');
            }

            if (isset($condition['publish']) && $condition['publish'] != '-1') {
                $query->where('publish', $condition['publish']);
            }
        })->with($relations);


        if (!empty($join)) {
            foreach ($join as $table => $constraints) {
                $query->join($table, ...$constraints);
            }
        }
        return $query->paginate($perPage)->withQueryString();
        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
    }
}
