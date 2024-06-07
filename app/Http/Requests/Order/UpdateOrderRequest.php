<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
        return [
            'phone' => 'regex:/^[0-9]{10}$/',
            'email' => 'email',
            'confirm' => 'in:pending,success,cancel',
            'delivery' => 'in:pending,processing,success'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'confirm' => 'Trạng thái đơn hàng',
            'delivery' => 'Trạng thái giao hàng',
        ];
    }

    public function messages()
    {
        return __('request.messages') + ['regex' => 'Số điện thoại khhông hợp lệ.', 'in' => ':attribute không hợp lệ, vui lòng chọn lại.'];
    }
}
