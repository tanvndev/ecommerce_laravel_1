<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Promotion;
use App\Repositories\Interfaces\PromotionRepositoryInterface;

class PromotionRepository extends BaseRepository implements PromotionRepositoryInterface
{
    protected $model;
    public function __construct(
        Promotion $model
    ) {
        $this->model = $model;
    }

    public function findByProduct($productId = [])
    {
        return $this->model->select(
            'promotions.id as promotion_id',
            'promotions.discount_value',
            'promotions.discount_type',
            'promotions.max_discount',
            'p.id as product_id',
            'p.price as product_price',
        )
            ->selectRaw(
                "
                    MAX(
                        IF(promotions.max_discount != 0,
                            LEAST(
                                CASE
                                WHEN promotions.discount_type = 'cast' THEN promotions.discount_value
                                WHEN promotions.discount_type = 'percent' THEN promotions.discount_value * p.price / 100
                                ELSE 0
                                END,
                                promotions.max_discount
                            ),
                            CASE 
                                WHEN promotions.discount_type = 'cast' THEN promotions.discount_value
                                WHEN promotions.discount_type = 'percent' THEN promotions.discount_value * p.price / 100
                                ELSE 0
                                END
                            )
                        ) as discount
                "
            )
            ->join('promotion_product_variant as ppv', 'promotions.id', '=', 'ppv.promotion_id')
            ->join('products as p', 'ppv.product_id', '=', 'p.id')
            ->where('p.publish', config('apps.general.defaultPublish'))
            ->where('promotions.publish', config('apps.general.defaultPublish'))
            ->whereIn('p.id', $productId)
            ->whereDate('promotions.start_at', '<=', date('Y-m-d H:i:s'))
            ->whereDate('promotions.end_at', '>', date('Y-m-d H:i:s'))
            ->groupBy(
                'promotions.id',
                'promotions.discount_value',
                'promotions.discount_type',
                'promotions.max_discount',
                'p.id',
                'p.price'
            )
            ->get();
    }

    public function findPromotionProductVariant($variantUuid)
    {
        return $this->model->select(
            'promotions.id as promotion_id',
            'promotions.discount_value',
            'promotions.discount_type',
            'promotions.max_discount',
            'pv.price'
        )
            ->selectRaw(
                "
                    MAX(
                        IF(promotions.max_discount != 0,
                            LEAST(
                                CASE
                                WHEN promotions.discount_type = 'cast' THEN promotions.discount_value
                                WHEN promotions.discount_type = 'percent' THEN promotions.discount_value * pv.price / 100
                                ELSE 0
                                END,
                                promotions.max_discount
                            ),
                            CASE 
                                WHEN promotions.discount_type = 'cast' THEN promotions.discount_value
                                WHEN promotions.discount_type = 'percent' THEN promotions.discount_value * pv.price / 100
                                ELSE 0
                                END
                            )
                        ) as discount
                "
            )
            ->join('promotion_product_variant as ppv', 'promotions.id', '=', 'ppv.promotion_id')
            ->join('product_variants as pv', 'pv.uuid', '=', 'ppv.variant_uuid')
            ->where('promotions.publish', config('apps.general.defaultPublish'))
            ->where('ppv.variant_uuid', $variantUuid)
            ->whereDate('promotions.start_at', '<=', date('Y-m-d H:i:s'))
            ->whereDate('promotions.end_at', '>', date('Y-m-d H:i:s'))
            ->groupBy(
                'promotions.id',
                'promotions.discount_value',
                'promotions.discount_type',
                'promotions.max_discount',
                'pv.price'
            )
            ->first();
    }

    public function getPromtionByCartTotal($cartTotal)
    {
        return $this->model->select('promotions.*')
            ->where('promotions.publish', config('apps.general.defaultPublish'))
            ->where('promotions.method', 'order_amount_range')
            ->whereDate('promotions.start_at', '<=', date('Y-m-d H:i:s'))
            ->whereDate('promotions.end_at', '>', date('Y-m-d H:i:s'))
            ->get();
    }
}
