<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateTranslateRequest extends FormRequest
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
            'translate_name' => 'required|string',
            'translate_canonical' => [
                'required',
                function ($attribute, $value, $fail) {
                    // dd($value, $this->input('option')['languageId'], $this->id);
                    $flag = DB::table('routers')
                        ->where('canonical', $value)
                        ->where('language_id', '<>', $this->input('option')['languageId'])
                        ->where('module_id', '=', $this->id)
                        ->exists();
                    if ($flag) {
                        $fail(':attribute đã tồn tại.');
                    }
                }
            ]
        ];
    }

    public function attributes()
    {
        return [
            'translate_name' => 'Tiêu đề',
            'translate_canonical' => 'Đường dẫn',
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
