<?php

namespace TinnyApi\Rules;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Hashing\HashManager;

class CurrentPasswordRule implements Rule
{
    /**
     * @var HashManager
     */
    private $hashManager;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * CurrentPasswordRule constructor.
     *
     * @param HashManager $hashManager
     * @param Guard $auth
     */
    public function __construct(HashManager $hashManager, Guard $auth)
    {
        $this->hashManager = $hashManager;
        $this->auth = $auth;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->hashManager->check($value, $this->auth->user()->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('Your current password is not valid');
    }
}
