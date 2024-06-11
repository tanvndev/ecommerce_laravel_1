<?php

namespace App\Http\Controllers\Clients\Payments;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Services\Interfaces\OrderServiceInterface as OrderService;


use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{

    private $orderRepository;
    private $orderService;

    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService
    ) {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    public function success(Request $request)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        dd($response);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $payload['payment'] = 'paid';
        } else {
            $payload['payment'] = 'unpaid';
        }

        $updatePayment = $this->orderService->updatePayment($request->order_id, $payload);


        if ($updatePayment) {

            $request->session()->put('paymentReturn',  $response);
            $request->session()->put('templatePayment',  'clients.includes.paypal');

            return redirect()->route('cart.success')->with('toast_success', 'Đặt hàng thành công.');
        }

        // Xoa orderSuccess
        $request->session()->forget('orderSuccess');
        return redirect()->route('checkout')->with('toast_error', 'Đặt hàng thất bại, vui lòng thử lại!');
    }

    public function cancel(Request $request)
    {
        $request->session()->forget('orderSuccess');
        return redirect()->route('checkout')->with('toast_error', 'Đặt hàng thất bại, vui lòng thử lại!');
    }
}
