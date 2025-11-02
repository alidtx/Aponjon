<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class BdPhoneNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^(?:\+?88|0088)?01[3-9]\d{8}$/', $value)) {
            $fail('দয়া করে বৈধ ১১ অঙ্কের বাংলাদেশি ফোন নম্বর লিখুন।.');
        }
    }
}
