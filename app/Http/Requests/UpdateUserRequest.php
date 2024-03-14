<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users,email,' . $this->id,
            'fullname' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',

        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'fullname' => 'Họ và tên',
            'user_catalogue_id' => 'Nhóm thành viên',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute bắt buộc nhập.',
            'unique' => ':attribute đã tồn tại.',
            'email' => ':attribute sai định dạng.',
            'string' => ':attribute phải là dạng ký tự.',
            'integer' => ':attribute phải là dạng số.',
            'email' => ':attribute sai định dạng.',
            'min' => ':attribute phải tối thiểu :min ký tự.',
            'same' => ':attribute chưa khớp.',
            'gt' => ':attribute bắt buộc phải chọn.',
        ];
    }
}
