<?php

namespace App\Services;

use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;

use Gloudemans\Shoppingcart\Facades\Cart;



/**
 * Class CartService
 * @package App\Services
 */
class CartService implements CartServiceInterface
{

    private $productRepository;
    private $productVariantRepository;
    private $promotionRepository;
    private $productService;


    public function __construct(
        ProductRepository $productRepository,
        ProductVariantRepository $productVariantRepository,
        PromotionRepository $promotionRepository,
        ProductService $productService
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->promotionRepository = $promotionRepository;
        $this->productService = $productService;
    }
    public function create()
    {
        try {
            $payload = request()->all();
            $productId = $payload['productId'];
            $attributeId = $payload['attributeId'] ?? [];

            $product = $this->productRepository->findById(
                $productId,
                ['id', 'price'],
                [
                    'languages' => function ($query) {
                        $query->where('language_id', session('currentLanguage', 1));
                    }
                ]
            );

            if (!$product) {
                throw new \Exception('Product not found');
            }

            $productName = $product->languages->first()->pivot->name;

            $data = [
                'id' => $productId,
                'name' => $productName,
                'qty' => $payload['quantity'],
            ];
            if (isset($attributeId) && !empty($attributeId)) {

                $attributeId = sortAttributeId($attributeId);
                $variant = $this->productVariantRepository->findVariant($attributeId, $productId);

                if (!$variant) {
                    throw new \Exception('Product variant not found');
                }

                $data['id'] = $productId . '_' . $variant->uuid;
                $data['name'] = $productName . ' ' . $variant->languages->first()->pivot->name;
                $variantPromotion = $this->promotionRepository->findPromotionProductVariant($variant->uuid);
                $variantPrice = getVariantPrice($variant, $variantPromotion);
                $data['price'] = $variantPrice['priceSale'];
                $data['options'] = [
                    'attribute' => $attributeId,
                ];
            } else {
                $product = $this->productService->combineProductAndPromotion([$productId], $product, true);
                $price = getPrice($product);
                $data['price'] = $price['priceSale'];
            }

            Cart::instance('shopping')->add($data);
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update($id)
    {
    }

    public function destroy($id)
    {
    }
}
