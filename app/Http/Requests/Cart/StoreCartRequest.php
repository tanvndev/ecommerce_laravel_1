<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required|string',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'email' => 'required|string|email',
            'address' => 'required',
            'province_id' => 'gt:0',
            'district_id' => 'gt:0',
            'ward_id' => 'gt:0',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'fullname' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'province_id' => 'Tỉnh/Thành phố',
            'district_id' => 'Quận/Huyện',
            'ward_id' => 'Phường/Xã',

        ];
    }

    public function messages()
    {
        return __('request.messages') + ['regex' => 'Số điện thoại khhông hợp lệ.'];
    }
}
