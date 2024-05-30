<?php

namespace App\Repositories\Interfaces;

interface PromotionRepositoryInterface extends BaseRepositoryInterface
{
    public function findByProduct($productId = []);
    public function findPromotionProductVariant($variantUuid);
    public function getPromtionByCartTotal($cartTotal);
}
