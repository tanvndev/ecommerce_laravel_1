<?php

namespace App\Http\Requests\Source;

use Illuminate\Foundation\Http\FormRequest;

class StoreSourceRequest extends FormRequest
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
            'keyword' => 'required|string|unique:sources',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên nguồn khách',
            'keyword' => 'Từ khoá',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
