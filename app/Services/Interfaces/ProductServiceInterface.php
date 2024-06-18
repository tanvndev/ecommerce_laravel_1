<?php

namespace App\Services\Interfaces;

interface ProductServiceInterface
{
    public function paginate($productCatalogue = null);
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusAll();
    public function combineProductAndPromotion($productId = [],  $products = null, $flag = false);
    public function getAttribute($product);
    public function filter();
}
