<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuCatalogueRequest extends FormRequest
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
            'name' => 'required|string',
            'keyword' => 'required|unique:menu_catalogues',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tiêu đề',
            'keyword' => 'Nhóm từ khoá',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
