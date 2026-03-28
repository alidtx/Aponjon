<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NidNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d+$/', $value)) {
            $fail('The :attribute must contain only numbers.');
            return;
        }

        $length = strlen($value);

        if (!in_array($length, [10, 13, 17])) {
            $fail('NID নম্বরটি অবশ্যই ১০, ১৩ অথবা ১৭ সংখ্যার হতে হবে।');
        }
    }
}
