<?php

namespace TinnyApi\Requests;

use TinnyApi\Rules\CurrentPasswordRule;
use TinnyApi\Rules\WeakPasswordRule;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * @var CurrentPasswordRule
     */
    private $currentPasswordRule;

    /**
     * @var WeakPasswordRule
     */
    private $weakPasswordRule;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                $this->currentPasswordRule,
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                $this->weakPasswordRule,
            ],
        ];
    }

    /**
     * @param $currentPasswordRule
     * @return $this
     */
    public function setCurrentPasswordRuleInstance($currentPasswordRule): PasswordUpdateRequest
    {
        $this->currentPasswordRule = $currentPasswordRule;

        return $this;
    }

    /**
     * @param $weakPasswordRule
     * @return $this
     */
    public function setWeakPasswordRuleInstance($weakPasswordRule): PasswordUpdateRequest
    {
        $this->weakPasswordRule = $weakPasswordRule;

        return $this;
    }
}
