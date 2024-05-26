<?php

namespace App\Repositories\Interfaces;

interface ProductVariantRepositoryInterface extends BaseRepositoryInterface
{
    public function findVariant($code, $productId);
}
