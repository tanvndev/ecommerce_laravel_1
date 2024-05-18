<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Enums\PromotionEnum;
use App\Services\Interfaces\PromotionServiceInterface;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PromotionService extends BaseService implements PromotionServiceInterface
{
    protected $promotionRepository;

    public function __construct(
        PromotionRepository $promotionRepository,
    ) {
        parent::__construct();
        $this->promotionRepository = $promotionRepository;
        $this->controllerName = 'PromotionController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
        ];

        $select = [
            'id',
            'code',
            'name',
            'method',
            'discount_infomation',
            'description',
            'publish',
            'order',
            'start_at',
            'end_at',
            'never_end'
        ];

        //////////////////////////////////////////////////////////
        $promotions = $this->promotionRepository->pagination(
            $select,
            $condition,
            request('perpage'),
        );

        // dd($promotions);
        return $promotions;
    }


    public function create()
    {
        DB::beginTransaction();
        try {
            $payload = $this->handlePayload();
            $promotion = $this->promotionRepository->create($payload);
            // dd($promotion);

            // Nếu tạo thành công, thêm sản phẩm và biến thể vào khuyến mãi sản phẩm
            if ($payload['method'] == PromotionEnum::PRODUCT_AND_QUANTITY && $promotion->id > 0) {
                $this->createPromtionProductVariant($promotion, 'create');
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage() . ' ' . $e->getLine();

            die;
            return false;
        }
    }


    public function update($id)
    {
        DB::beginTransaction();
        try {
            $payload = $this->handlePayload();
            $promotion = $this->promotionRepository->save($id, $payload);

            // Nếu tạo thành công, thêm sản phẩm và biến thể vào khuyến mãi sản phẩm
            if ($payload['method'] == PromotionEnum::PRODUCT_AND_QUANTITY && $promotion->id > 0) {
                $this->createPromtionProductVariant($promotion, 'update');
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function handlePayload()
    {
        // dd(request()->all());
        $payload = request()->only('name', 'code', 'start_at', 'end_at', 'never_end', 'description');
        if (!is_null(request()->input(PromotionEnum::PRODUCT_AND_QUANTITY))) {
            $payload += request()->input(PromotionEnum::PRODUCT_AND_QUANTITY);
            $payload['discount_value'] = convertPrice($payload['discount_value']);
            $payload['max_discount'] = convertPrice($payload['max_discount']);
            // dd($payload);
        }
        $payload['method'] = request('promotion_method');
        $payload['code'] = Str::upper((empty($payload['code'])) ? Str::random(10) : $payload['code']);

        switch ($payload['method']) {
            case PromotionEnum::ORDER_AMOUNT_RANGE:
                $payload[PromotionEnum::DISCOUNT] = $this->orderByRange($payload);
                break;
            case PromotionEnum::PRODUCT_AND_QUANTITY:
                $payload[PromotionEnum::DISCOUNT] = $this->productAndQuantity($payload);
                break;
        }

        return $payload;
    }

    private function createPromtionProductVariant($promotion = null, $method = 'create')
    {
        $object = request()->input('object');
        $dataRelation = [];
        foreach ($object['id'] as $key => $value) {
            $dataRelation[] = [
                'promotion_id' => $promotion->id,
                'product_id' => $value,
                'variant_uuid' => $object['product_variant_id'][$key] ?? 0,
                'model' => request()->input(PromotionEnum::MODULE_TYPE)
            ];
        }

        if ($method == 'update') {
            $promotion->products()->detach();
        }

        $promotion->products()->sync($dataRelation);
    }

    private function handleSourceAndCondition()
    {
        $payload = [
            'source' => [
                'status' => request()->input('sourceStatus'),
                'data' => request()->input('sourceValue'),
            ],
            'apply' => [
                'status' => request()->input('applyStatus'),
                'data' => request()->input('applyValue'),
            ]
        ];

        if ($payload['apply']['status'] == 'choose') {
            foreach ($payload['apply']['data'] as $key => $value) {
                $payload['apply']['condition'][$value] = request()->input($value);
            }
        }
        return $payload;
    }

    private function orderByRange()
    {
        $payload['info'] = request()->input('promotion_order_amount_range');
        return $payload + $this->handleSourceAndCondition();
    }

    private function productAndQuantity()
    {
        $data['info'] = request()->input('product_and_quantity');
        $data['info']['model'] = request()->input(PromotionEnum::MODULE_TYPE);
        $data['info']['object'] = request()->input('object');

        return $data + $this->handleSourceAndCondition();
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $promotion = $this->promotionRepository->findById($id);
            $promotion->products()->detach();
            $this->promotionRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
