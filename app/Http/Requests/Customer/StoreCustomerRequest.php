<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the customer is authorized to make this request.
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
            'email' => 'required|string|email|unique:customers',
            'fullname' => 'required|string',
            'customer_catalogue_id' => 'required|integer|gt:0',
            'password' => 'required|string|min:6',
            're_password' => 'string|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'fullname' => 'Họ và tên',
            'customer_catalogue_id' => 'Nhóm thành viên',
            'password' => 'Mật khẩu',
            're_password' => 'Mật khẩu',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
