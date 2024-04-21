<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string|phone|unique:users',
            'fullname' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
            'password' => 'required|string|min:6',
            're_password' => 'string|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'fullname' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'user_catalogue_id' => 'Nhóm thành viên',
            'password' => 'Mật khẩu',
            're_password' => 'Mật khẩu',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
