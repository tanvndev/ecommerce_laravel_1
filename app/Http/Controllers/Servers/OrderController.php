<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Requests\Update;
use Illuminate\Http\Request;
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;



class OrderController extends Controller
{
    protected $orderService;
    protected $orderRepository;
    protected $provinceRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository,
        ProvinceRepository $provinceRepository
    ) {
        parent::__construct();

        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->provinceRepository = $provinceRepository;
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
        $provinces = $this->provinceRepository->all();

        $config['seo'] = __('messages.order')['detail'];

        return view('servers.orders.detail', compact([
            'order',
            'config',
            'provinces',
        ]));
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('order', 'success', 'detail');
        $errorMessage = $this->getToastMessage('order', 'error', 'detail');

        if ($this->orderService->update($id)) {
            return redirect()->route('order.detail', $id)->with('toast_success', $successMessage);
        }
        return redirect()->route('order.detail', $id)->with('toast_error', $errorMessage);
    }
}
