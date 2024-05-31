<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
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
        // Cart::instance('shopping')->destroy();

        $carts = $this->cartService->getCart();

        if (empty($carts) || count($carts) == 0) {
            return redirect()->route('home')->with('toast_warning', 'Giỏ hàng trống, hãy thêm sản phẩm để thanh toán!');
        }

        $cartPromotion = $this->cartService->cartPromotion($carts->total);
        // dd($cartPromotion);

        $provinces = $this->provinceRepository->all();
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
            'cartPromotion'
        ));
    }

    public function store(StoreCartRequest $request)
    {
        $order = $this->cartService->order();
        if (!empty($order)) {
            $request->session()->put('orderSuccess', $order);
            return redirect()->route('cart.success')->with('toast_success', 'Đặt hàng thành công.');
        }
        return redirect()->back()->with('toast_error', 'Đặt hàng thất bại, vui lòng đặt lại!');
    }

    public function success(Request $request)
    {
        if (!session('orderSuccess') || empty(session('orderSuccess')) || session('orderSuccess') != true) {
            return redirect()->route('checkout')->with('toast_error', 'Đặt hàng thất bại, vui lòng thử lại!');
        }

        // $order = $request->session()->pull('orderSuccess');
        $order = $request->session()->get('orderSuccess');
        $seo = [
            'meta_title' => 'Đặt hàng thành công',
            'meta_description' => '',
            'meta_keywords' => '',
            'meta_image' => '',
            'canonical' => write_url('cart/success'),
        ];


        return view('clients.cart.success', compact(
            'seo',
            'order'
        ));
    }
}
