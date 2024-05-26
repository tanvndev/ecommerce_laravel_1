<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CartServiceInterface as CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;
    private $productRepository;
    public function __construct(
        CartService $cartService,
    ) {
        parent::__construct();

        $this->cartService = $cartService;
    }

    public function create()
    {
        if ($this->cartService->create()) {
            $cart = Cart::instance('shopping')->content();
            return response()->json([
                'code' => 200,
                'message' => 'Thêm sản phẩm vào giỏ hàng thành công.',
                'cart' => $cart
            ]);
        }
    }
}
