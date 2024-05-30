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

    public function getCart()
    {
        return $this->handleResponse($this->cartService->getCart(), 'Lấy sản phẩm');
    }

    public function create()
    {
        return $this->handleResponse($this->cartService->create(), 'Thêm sản phẩm vào giỏ hàng');
    }

    public function update()
    {
        return $this->handleResponse($this->cartService->update(), 'Cập nhập số lượng');
    }

    public function destroy()
    {
        return $this->handleResponse($this->cartService->destroy(), 'Xóa sản phẩm');
    }

    protected function handleResponse($carts, $action)
    {
        if ($carts === false) {
            return response()->json([
                'code' => 400,
                'message' => $action . ' thất bại.',
                'data' => []
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => $action . ' thành công.',
            'data' => [
                'carts' => $carts,
                'count' => $carts->count ?? 0,
                'total' => $carts->total ?? 0
            ]
        ]);
    }
}
