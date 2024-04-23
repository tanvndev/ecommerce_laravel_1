<?php

namespace App\Http\Requests\Promotion;;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
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
        // dd($this->all());
        $rules = [
            'name' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d\TH:i',

        ];

        if (!$this->has('neverEndDate')) {
            $rules['end_date'] = 'required|date_format:Y-m-d\TH:i|after:start_date';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên chương trình',
            'code' => 'Mã khuyến mãi',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
