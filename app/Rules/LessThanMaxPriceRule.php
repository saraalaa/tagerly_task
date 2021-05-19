<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LessThanMaxPriceRule implements Rule
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
    public function passes($attribute, $value) : bool
    {
        if (request()->has('max_price'))
            return $value <= request('max_price');
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() : string
    {
        return ':attribute should be less than max price';
    }
}
