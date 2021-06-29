<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckNumberCAN implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        if (request()->has('field') && request()->get('field') === 'MyValueSuccess') {
            if (is_string($value)) {
                return true;
            } else {
                $this->error = '- not valid field';
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
