<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Services\Interfaces\OrderServiceInterface;

/**
 * Class OrderService
 * @package App\Services
 */
class OrderService implements OrderServiceInterface
{
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'dropdown' => [],
            'created_at' => request('created_at'),
        ];
        foreach (__('cart') as $key => $value) {
            $condition['dropdown'][$key] = request($key);
        }


        $select = [
            'id',
            'email',
            'phone',
            'fullname',
            'code',
            'payment_method',
            'payment',
            'delivery',
            'shipping',
            'created_at',
            'promotion',
            'cart',
            'delivery',
            'payment',
            'confirm',
            'phone',
            'address'
        ];

        $orders = $this->orderRepository->pagination(
            $select,
            $condition,
            request('perpage'),
        );

        // dd($orders);

        return $orders;
    }
}
