<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckMenuItemExist;
use Illuminate\Validation\Rule;

class StoreMenuRequest extends FormRequest
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
            'menu_catalogue_id' => 'gt:0',
            'menu.name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'menu_catalogue_id' => 'Vị trí hiển thị',
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