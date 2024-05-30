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

        $carts = Cart::instance('shopping')->content();

        if (is_null($carts) || count($carts) == 0) {
            return redirect()->back()->with('toast_success', 'Giỏ hàng trống, hãy thêm sản phẩm vào để thanh toán!');
        }

        $cartTotal = Cart::instance('shopping')->subtotal();
        $carts = $this->cartService->remakeCart($carts);
        $carts->total = $cartTotal;

        $cartPromotion = $this->cartService->cartPromotion($cartTotal);
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
    }
}
