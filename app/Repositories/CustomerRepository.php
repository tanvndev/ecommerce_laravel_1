<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    protected $model;
    public function __construct(
        Customer $model
    ) {
        $this->model = $model;
    }

    public function pagination(
        $column = ['*'],
        $condition = [],
        $perPage = 1,
        $orderBy = [],
        $join = [],
        $relations = [],
        $groupBy = [],
        $whereRaw = [],
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {

            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('fullname', 'like', '%' . $condition['keyword'] . '%')
                    ->orWhere('email', 'like', '%' . $condition['keyword'] . '%')
                    ->orWhere('phone', 'like', '%' . $condition['keyword'] . '%')
                    ->orWhere('address', 'like', '%' . $condition['keyword'] . '%');
            }

            if (isset($condition['customer_catalogue_id']) && $condition['customer_catalogue_id'] != '') {
                $query->where('customer_catalogue_id', $condition['customer_catalogue_id']);
            }

            if (isset($condition['publish']) && $condition['publish'] != '-1') {
                $query->where('publish', $condition['publish']);
            }
        })->with($relations);


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

        // 'table_name_1' => ['constraint1', 'constraint2'],
        if (!empty($join)) {
            foreach ($join as $table => $constraints) {
                $query->join($table, ...$constraints);
            }
        }


        return $query->paginate($perPage)->withQueryString();
        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
    }
}
