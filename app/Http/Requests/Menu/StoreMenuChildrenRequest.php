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
        return __('request.messages');
    }
}
