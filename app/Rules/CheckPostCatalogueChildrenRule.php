<?php

namespace App\Rules;

use App\Models\PostCatalogue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPostCatalogueChildrenRule implements ValidationRule
{
    protected $_id;
    public function __construct($id)
    {
        $this->_id = $id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $flag = PostCatalogue::isChildrenNode($this->_id);

        if ($flag == false) {
            $fail('Không thể xoá do vẫn còn danh mục con.');
        }
    }
}
