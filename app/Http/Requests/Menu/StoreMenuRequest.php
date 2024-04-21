<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

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
        return __('request.messages');
    }
}
