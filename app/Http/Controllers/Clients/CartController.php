<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkout()
    {
        // Cart::instance('shopping')->destroy();

        $cart = Cart::instance('shopping')->content();
        dd($cart);
    }
}
