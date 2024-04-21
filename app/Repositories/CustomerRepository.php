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

    public function getCustomerLanguageById($id = 0, $languageId = 0)
    {
        $select = [
            'customers.id',
            'customers.customer_catalogue_id',
            'customers.publish',
            'customers.image',
            'customers.icon',
            'customers.album',
            'customers.follow',
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
            ->join('customer_language as tb2', 'customers.id', '=', 'tb2.customer_id')
            ->where('tb2.language_id', $languageId)
            ->with('customer_catalogues')
            ->find($id);
    }
}
