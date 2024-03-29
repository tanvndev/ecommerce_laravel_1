<?php

namespace App\Rules;

use App\Models\{ModuleTemplate};
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Check{ModuleTemplate}ChildrenRule implements ValidationRule
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
        $flag = {ModuleTemplate}::isChildrenNode($this->_id);

        if ($flag == false) {
            $fail(__('messages.errorChildDelete'));
        }
    }
}
