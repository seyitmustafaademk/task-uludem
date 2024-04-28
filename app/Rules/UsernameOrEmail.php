<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UsernameOrEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail = (strlen($value) <= 100) ? null : $fail('Email must not be greater than 100 characters');
        } else {
            $fail = (strlen($value) <= 30) ? null : $fail('Username must not be greater than 30 characters');
        }
    }
}
