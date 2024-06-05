<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\Interfaces\OrderServiceInterface as OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;


class OrderController extends Controller
{
    protected $orderService;
    protected $orderRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository,
    ) {
        parent::__construct();

        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }


    public function index()
    {
        $this->authorize('modules', 'order.index');

        $orders = $this->orderService->paginate();
        // dd($orders);
        $config['seo'] = __('messages.order')['index'];

        return view('servers.orders.index', compact([
            'orders',
            'config',
        ]));
    }

    public function detail($id)
    {
        $this->authorize('modules', 'order.detail');

        $order = $this->orderRepository->getOrderById($id);
        // dd($order);
        $config['seo'] = __('messages.order')['detail'];

        return view('servers.orders.detail', compact([
            'order',
            'config',
        ]));
    }
}
