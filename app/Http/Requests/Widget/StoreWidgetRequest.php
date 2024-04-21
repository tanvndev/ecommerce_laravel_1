<?php

namespace App\Http\Requests\Widget;

use Illuminate\Foundation\Http\FormRequest;

class StoreWidgetRequest extends FormRequest
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
            'name' => 'required',
            'keyword' => 'required|unique:widgets',
            'short_code' => 'required|unique:widgets',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên widget',
            'keyword' => 'Từ khoá',
            'short_code' => 'Shortcode',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
