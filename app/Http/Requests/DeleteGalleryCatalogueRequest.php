<?php

namespace App\Http\Requests;

use App\Rules\CheckGalleryCatalogueChildrenRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteGalleryCatalogueRequest extends FormRequest
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
                new CheckGalleryCatalogueChildrenRule($_id),
            ]
        ];
    }
}
