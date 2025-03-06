<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RequiredApproval implements ValidationRule
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->user->hasRole(['worker', 'client']) && is_null($value)) {
            $fail("The {$attribute} field is required.");
        }
    }
}
