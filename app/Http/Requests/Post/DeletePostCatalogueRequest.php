<?php

namespace App\Http\Requests\Post;

use App\Rules\CheckPostCatalogueChildrenRule;
use Illuminate\Foundation\Http\FormRequest;

class DeletePostCatalogueRequest extends FormRequest
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
        $_id = request('_id');
        return [
            '_id' => [
                new CheckPostCatalogueChildrenRule($_id),
            ]
        ];
    }
}
