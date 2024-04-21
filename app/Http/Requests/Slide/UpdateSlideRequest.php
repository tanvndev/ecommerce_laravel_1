<?php

namespace App\Http\Requests\Slide;;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideRequest extends FormRequest
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
            'keyword' => 'required|unique:slides,keyword,' . $this->id,
            'slide.image' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên slide',
            'keyword' => 'Từ khoá',
            'slide.image' => 'Ảnh slide',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
