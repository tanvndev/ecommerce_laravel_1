<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'rate' => 'required',
            'fullname' => 'required|string',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'email' => 'required|string|email',
            'description' => 'required',

        ];
    }

    public function attributes()
    {
        return [
            'rate' => 'Số sao',
            'email' => 'Email',
            'fullname' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'description' => 'Cảm nhận',
        ];
    }

    public function messages()
    {
        return __('request.messages') + ['regex' => 'Số điện thoại khhông hợp lệ.'];
    }
}
