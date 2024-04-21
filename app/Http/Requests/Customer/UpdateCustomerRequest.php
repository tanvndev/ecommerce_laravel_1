<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'email' => 'required|string|email|unique:customers,email,' . $this->id,
            'phone' => 'required|string|phone|unique:customers,phone,' . $this->id,
            'fullname' => 'required|string',
            'customer_catalogue_id' => 'required|integer|gt:0',

        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'fullname' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'customer_catalogue_id' => 'Nhóm khách hàng',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
