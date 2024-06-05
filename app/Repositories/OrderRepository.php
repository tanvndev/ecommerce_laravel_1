<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected $model;
    public function __construct(
        Order $model
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
        $groupBy = [],
        $rawQuery = [],
    ) {
        $query = $this->model->select($column);
        $query->keyword(
            $condition['keyword'] ?? null,
            ['fullname', 'phone', 'email', 'address', 'code'],
            ['field' => 'name', 'relation' => 'products']
        )
            ->publish($condition['publish'] ?? null)
            ->customWhere($condition['where'] ?? null)
            ->filterDropdown($condition['dropdown'] ?? null)
            ->createdAt($condition['created_at'] ?? null)
            ->customWhereRaw($rawQuery['whereRaw'] ?? null)
            ->relation($relations ?? null)
            ->relationCount($relations ?? null)
            ->customJoin($join ?? null)
            ->customGroupBy($groupBy ?? null)
            ->customOrderBy($orderBy ?? null);

        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
        return $query->paginate($perPage)->withQueryString();
    }

    public function getOrderById($id)
    {
        $query = $this->model->select(
            'orders.*',
            'provinces.name as province_name',
            'districts.name as district_name',
            'wards.name as ward_name',
        )
            ->leftJoin('provinces', 'provinces.code', '=', 'orders.province_id')
            ->leftJoin('districts', 'districts.code', '=', 'orders.district_id')
            ->leftJoin('wards', 'wards.code', '=', 'orders.ward_id')
            ->find($id);
        return $query;
    }
}
