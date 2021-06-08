<?php

namespace TinnyApi\Rules;

use Illuminate\Contracts\Validation\Rule;

class WeakPasswordRule implements Rule
{

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool|void
     */
    public function passes($attribute, $value)
    {
        // TODO: Implement passes() method.
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'This password is just too common. Please try another!';
    }
}
