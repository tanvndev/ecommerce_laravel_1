<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;

use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
    private $orderRepository;



    public function __construct(
        ProductRepository $productRepository,
        ProductVariantRepository $productVariantRepository,
        PromotionRepository $promotionRepository,
        ProductService $productService,
        OrderRepository $orderRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->promotionRepository = $promotionRepository;
        $this->productService = $productService;
        $this->orderRepository = $orderRepository;
    }


    public function getCart()
    {
        $carts = Cart::instance('shopping')->content();
        if (count($carts) == 0 || is_null($carts)) {
            return [];
        }

        $cartTotal = Cart::instance('shopping')->subtotal();
        $cartCount = Cart::instance('shopping')->content()->count();
        $carts = $this->remakeCart($carts);

        foreach ($carts as $key => $cart) {
            $newOption = [
                'image' =>  $cart->image,
                'originalPrice' => $cart->originalPrice,
                'canonical' => $cart->canonical,
                'code' => $cart->code
            ];
            if (count($cart->options) <= 1) {
                $cart->options->push($newOption);
            }
        }

        $carts->total = $cartTotal;
        $carts->count = $cartCount;
        return $carts;
    }
    public function create()
    {
        try {
            $payload = request()->all();
            $productId = $payload['productId'];
            $attributeId = $payload['attributeId'] ?? [];

            $product = $this->productRepository->findById(
                $productId,
                ['id', 'price', 'image'],
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
            return $this->getCart();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function remakeCart($carts)
    {
        if (empty($carts) || count($carts) == 0) {
            return [];
        }

        $cartIds = $carts->pluck('id');

        $ids = ['product' => [], 'variant' => []];

        // Tách ID của sản phẩm và variant
        foreach ($cartIds as $cartId) {
            $extractCartId = explode('_', $cartId);
            if (count($extractCartId) > 1) {
                $ids['variant'][] = $extractCartId[1];
            }
            $ids['product'][] = $extractCartId[0];
        }

        // Loại bỏ các giá trị trùng lặp
        $ids['product'] = array_unique($ids['product']);
        $ids['variant'] = array_unique($ids['variant']);

        // Lấy các variant
        $objects['variants'] = $this->productVariantRepository->findByWhere(
            ['publish' => ['=', config('apps.general.defaultPublish')]],
            ['album', 'uuid', 'price', 'code'],
            [],
            true,
            null,
            ['field' => 'uuid', 'value' => $ids['variant']]
        )->keyBy('uuid');

        // Lấy các product
        $objects['products'] = $this->productRepository->findByWhere(
            ['publish' => ['=', config('apps.general.defaultPublish')]],
            ['id', 'image', 'price'],
            [
                [
                    'languages' => function ($query) {
                        $query->where('language_id', session('currentLanguage', 1));
                    }
                ]
            ],
            true,
            null,
            ['field' => 'id', 'value' => $ids['product']]
        )->keyBy('id');


        // Cập nhật ảnh cho mỗi giỏ hàng
        foreach ($carts as $cart) {
            $extractCartId = explode('_', $cart->id);
            $productId = $extractCartId[0];
            $variantId = $extractCartId[1] ?? '';

            // Mặc định lấy ảnh va gia sản phẩm
            $image = $objects['products'][$productId]->image ?? '';
            $price = $objects['products'][$productId]->price ?? 0;

            // Nếu có variant, lấy ảnh va gia variant
            if (!empty($variantId)) {
                $price = $objects['variants'][$variantId]->price ?? 0;
                $albumVariant = $objects['variants'][$variantId]->album ?? '';
                if (!empty($albumVariant)) {
                    $image = explode(',', $albumVariant)[0];
                }
            }

            $cart->image = $image;
            $cart->originalPrice = $price;
            $cart->canonical = $objects['products'][$productId]->languages->first()->pivot->canonical ?? '';
            $cart->code = $objects['variants'][$variantId]->code ?? '';
        }

        return $carts;
    }


    public function update()
    {
        try {
            $payload = request()->all();
            Cart::instance('shopping')->update($payload['rowId'], $payload['qty']);

            return $this->getCart();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function destroy()
    {
        try {
            $payload = request()->all();
            Cart::instance('shopping')->remove($payload['rowId']);

            return $this->getCart();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function cartPromotion($cartTotal)
    {
        $maxDiscount = 0;
        $selectedPromotion = null;
        $promotions = $this->promotionRepository->getPromtionByCartTotal(0);

        if (empty($promotions)) {
            return [];
        }

        foreach ($promotions as $promotion) {
            $discountInfo = $promotion->discount_infomation['info'];
            $amountFrom = $discountInfo['amountFrom'] ?? [];
            $amountTo = $discountInfo['amountTo'] ?? [];
            $amountValue = $discountInfo['amountValue'] ?? [];
            $amountType = $discountInfo['amountType'] ?? [];

            $length = min(count($amountFrom), count($amountTo), count($amountValue), count($amountType));

            for ($i = 0; $i < $length; $i++) {
                $currentAmountFrom = convertPrice($amountFrom[$i]);
                $currentAmountTo = convertPrice($amountTo[$i]);
                $currentAmountValue = convertPrice($amountValue[$i]);
                $currentAmountType = $amountType[$i];

                if (($cartTotal > $currentAmountFrom && $cartTotal <= $currentAmountTo) || $cartTotal > $currentAmountTo) {
                    if ($currentAmountType == 'cast') {
                        $discount = $currentAmountValue;
                    } elseif ($currentAmountType == 'percent') {
                        $discount = ($currentAmountValue / 100) * $cartTotal;
                    } else {
                        continue;
                    }

                    // Lay ra discount co duoc giam gia nhieu nhat
                    if ($discount > $maxDiscount) {
                        $maxDiscount = $discount;
                        $selectedPromotion = $promotion;
                    }
                }
            }
        }

        return [
            'discount' => $maxDiscount,
            'promotion' => $selectedPromotion,
        ];
    }

    public function order()
    {
        DB::beginTransaction();
        try {
            $payload = $this->handlePayloadOrder();

            $order = $this->orderRepository->create($payload);

            if ($order->id == null || empty($order->id)) {
                throw new \Exception('Error create order.');
            }
            $payload['id'] = $order->id;
            // Dong bo du lieu vao bang order_product
            $this->createOrderProduct($payload, $order);
            // Gui mail cho khach hang
            $this->sendMail($payload);
            DB::commit();
            return $payload;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
            die;
            return [];
        }
    }

    private function sendMail($order)
    {
        $to = $order['email'];
        $cc = env('MAIL_USERNAME');
        Mail::to($to)->cc($cc)->send(new OrderMail($order));
    }



    private function createOrderProduct($payload, $order)
    {
        $data = [];
        foreach ($payload['cart']['detail'] as $key => $cartItem) {
            // tach ra de lay product_id va uuid
            $ids = explode('_', $cartItem->id);

            $data[] = [
                'product_id' => $ids[0],
                'uuid' => $ids[1] ?? 0,
                'name' => $cartItem->name,
                'quantity' => $cartItem->qty,
                'price' => $cartItem->originalPrice,
                'price_sale' => $cartItem->price,
                'promotion' => json_encode($payload['promotion']),
                'option' => json_encode($cartItem->options)
            ];
        }

        $order->products()->sync($data);
    }

    private function handlePayloadOrder()
    {
        $carts = $this->getCart();
        $cartPromotion = $this->cartPromotion($carts->total);

        // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
        $payload = request()->except('_token');
        $payload['code'] = $this->generateOrderCode();
        $payload['created_at'] = date('Y-m-d H:i:s');
        $payload['user_id'] = Auth::id();

        $payload['cart'] = [
            'detail' => $carts,
            'total' => $carts->total,
            'count' => $carts->count
        ];
        $payload['promotion'] = [
            'discount' => $cartPromotion['discount'],
            'name' => $cartPromotion['promotion']->name ?? '',
            'start_at' => $cartPromotion['promotion']->start_at ?? '',
            'end_at' => $cartPromotion['promotion']->end_at ?? '',
        ];
        $payload['confirm'] = 'pending';
        $payload['delivery'] = 'pending';
        $payload['payment'] = 'unpaid';
        return $payload;
    }

    private function generateOrderCode($prefix = 'ORD')
    {
        $prefix = strtoupper($prefix);
        $date = date('Ymd');
        $uniqueId = uniqid();
        $uniqueHash = substr(md5($uniqueId), 0, 6);
        $orderCode = $prefix  . $date  . strtoupper($uniqueHash);
        return $orderCode;
    }
}
