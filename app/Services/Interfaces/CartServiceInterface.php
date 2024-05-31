<?php

namespace App\Services\Interfaces;

/**
 * Interface CartServiceInterface
 * @package App\Services\Interfaces
 */
interface CartServiceInterface
{
    public function getCart();
    public function create();
    public function update();
    public function destroy();
    public function order();
    public function remakeCart($carts);
    public function cartPromotion($cartTotal);
}
