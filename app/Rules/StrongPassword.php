<?php

namespace App\Rules;

use App\Policies\PasswordPolicy;
use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    protected $policy;
    
    public function __construct()
    {
        $this->policy = new PasswordPolicy();
    }
    
    public function passes($attribute, $value)
    {
        return $this->policy->validatePassword($value);
    }

    public function message()
    {
        return $this->policy->getPasswordRequirementsMessage();
    }
}