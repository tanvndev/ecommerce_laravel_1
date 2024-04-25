<?php

namespace App\Http\Requests\Promotion;;

use App\Enums\PromotionEnum;
use App\Rules\OrderAmountRangeRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string',
            'code' => 'unique:promotions,code,' . $this->id,
            'start_at' => 'required|date_format:Y-m-d\TH:i:s',
            'promotion_method' => 'required',

        ];

        if (!$this->has('never_end')) {
            $rules['end_at'] = 'required|date_format:Y-m-d\TH:i:s|after:start_at';
        }

        $method = $this->input('promotion_method');
        switch ($method) {
            case PromotionEnum::ORDER_AMOUNT_RANGE:
                $rules['promotion_method'] = [new OrderAmountRangeRule($this->input('promotion_order_amount_range'))];
                break;

            case PromotionEnum::PRODUCT_AND_QUANTITY:
                $rules['product_and_quantity.quantity'] = 'required|gt:0';
                $rules['product_and_quantity.discount_value'] = 'required|gt:0';
                $rules['object.id'] = 'required';
                break;
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên chương trình',
            'start_at' => 'Ngày bắt đầu',
            'end_at' => 'Ngày kết thúc',
            'product_and_quantity.quantity' => 'Số lượng tối thiểu',
            'product_and_quantity.discount_value' => 'Giá trị triết khấu',
            'object.id' => 'Sản phẩm mua',
            'promotion_method' => 'Hình thức khuyến mãi',
        ];
    }

    public function messages()
    {
        $messages = __('request.messages');
        $messages['gt'] = ':attribute phải có giá trị lớn hơn 0.';
        $messages['promotion_method.required'] = ':attribute bắt buộc phải chọn.';
        return $messages;
    }
}
