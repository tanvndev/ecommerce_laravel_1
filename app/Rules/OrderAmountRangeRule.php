<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderAmountRangeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (
            !isset($this->data['amountFrom'])
            || !isset($this->data['amountTo'])
            || !isset($this->data['amountValue'])
            || empty($this->data['amountFrom'])
            || empty($this->data['amountTo'])
            || empty($this->data['amountValue'])
        ) {
            $fail('Bạn phải khởi tạo giá trị cho khoảng khuyến mãi.');
        }

        if (in_array(0, $this->data['amountValue']) || in_array('', $this->data['amountValue'])) {
            $fail('Cấu hình giá trị chiết khấu không hợp lệ.');
        }
        // dd($this->data);

        $conflict = false;
        foreach ($this->data['amountFrom'] as $key1 => $from_1) {
            $from1 = floatval(str_replace('.', '', $from_1));
            $to1 = floatval(str_replace('.', '', $this->data['amountTo'][$key1]));

            if ($from1 >= $to1) {
                $conflict = true;
                break;
            }
            foreach ($this->data['amountFrom'] as $key2 => $from_2) {
                if ($key1 != $key2) {
                    $from2 = floatval(str_replace('.', '', $from_2));
                    $to2 = floatval(str_replace('.', '', $this->data['amountTo'][$key2]));

                    if ($from1 <= $to2 && $to1 >= $from2) {
                        $conflict = true;
                        break;
                    }
                }
            }
        }




        if ($conflict) {
            $fail('Có xung đột giữa các khoảng giá trị khuyến mãi, vui lòng kiêm tra lại.');
        }
    }
}
