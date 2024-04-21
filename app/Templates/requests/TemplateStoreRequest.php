<?php

namespace App\Http\Requests\{ModuleTemplate};

use Illuminate\Foundation\Http\FormRequest;

class Store{ModuleTemplate}Request extends FormRequest
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
            'canonical' => 'required|string|unique:routers',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tiêu đề',
            'canonical' => 'Đường dẫn',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
