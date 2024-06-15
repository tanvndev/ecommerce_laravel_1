<?php

namespace App\Http\Controllers\Clients;

use App\Classes\{
    Momo,
    Vnpay,
    Paypal
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\CartServiceInterface as CartService;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;



class CartController extends Controller
{
    private $provinceRepository;
    private $cartService;

    public function __construct(
        ProvinceRepository $provinceRepository,
        CartService $cartService
    ) {
        parent::__construct();

        $this->provinceRepository = $provinceRepository;
        $this->cartService = $cartService;
    }

    public function checkout()
    {
        $carts = $this->cartService->getCart();

        if (empty($carts) || count($carts) == 0) {
            return redirect()->route('home')->with('toast_warning', 'Giỏ hàng trống, hãy thêm sản phẩm để thanh toán!');
        }

        $cartPromotion = $this->cartService->cartPromotion($carts->total);
        // dd($cartPromotion);

        $provinces = $this->provinceRepository->all();
        $user = Auth::user() ?? null;
        $seo = [
            'meta_title' => 'Thanh toán',
            'meta_description' => '',
            'meta_keywords' => '',
            'meta_image' => '',
            'canonical' => write_url('checkout'),
        ];

        return view('clients.cart.checkout', compact(
            'seo',
            'carts',
            'provinces',
            'cartPromotion',
            'user'
        ));
    }

    public function store(StoreCartRequest $request)
    {
        // Tra ve mot mang
        $order = $this->cartService->order();
        if (!empty($order)) {
            $request->session()->put('orderSuccess', $order);

            $response = $this->methodPayment($order);
            if ($response['code'] == 00) {
                return redirect()->away($response['url']);
            }

            return redirect()->route('cart.success')->with('toast_success', 'Đặt hàng thành công.');
        }
        return redirect()->back()->with('toast_error', 'Đặt hàng thất bại, vui lòng đặt lại!');
    }

    private function methodPayment($order = null)
    {


        switch ($order['payment_method']) {
            case 'vnp_payment':
                $response = Vnpay::payment($order);
                break;
            case 'momo_payment':
                $response = Momo::payment($order);
                break;
            case 'paypal_payment':
                $response = Paypal::payment($order);
                break;

            default:
                # code...
                break;
        }

        return $response;
    }


    public function success(Request $request)
    {
        if (!session('orderSuccess') || empty(session('orderSuccess')) || session('orderSuccess') != true) {
            return redirect()->route('checkout')->with('toast_error', 'Đặt hàng thất bại, vui lòng thử lại!');
        }

        $order = $request->session()->get('orderSuccess');
        $paymentReturn = $request->session()->get('paymentReturn') ?? [];
        $template = $request->session()->get('templatePayment') ?? '';
        $seo = [
            'meta_title' => 'Đặt hàng thành công',
            'meta_description' => '',
            'meta_keywords' => '',
            'meta_image' => '',
            'canonical' => write_url('cart/success'),
        ];

        // Xoa gio hang
        Cart::instance('shopping')->destroy();

        return view('clients.cart.success', compact(
            'seo',
            'order',
            'paymentReturn',
            'template'
        ));
    }
}
