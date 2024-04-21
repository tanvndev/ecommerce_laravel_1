<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuChildrenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'menu.name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'menu.name' => 'Tên menu',
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
