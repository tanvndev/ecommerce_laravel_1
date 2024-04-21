<?php

namespace App\Http\Requests\Generate;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenerateRequest extends FormRequest
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
            'name' => 'required|unique:generates',
            'module_type' => 'required',
            'schema' => 'required',
            'module' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên module',
            'schema' => 'Schema',
            'module_type' => 'Loại module',
            'module' => 'Tên chức năng'
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
