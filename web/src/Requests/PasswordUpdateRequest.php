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
     * PasswordUpdateRequest constructor.
     *
     * @param CurrentPasswordRule $currentPasswordRule
     * @param WeakPasswordRule $weakPasswordRule
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(
        CurrentPasswordRule $currentPasswordRule,
        WeakPasswordRule $weakPasswordRule,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->currentPasswordRule = $currentPasswordRule;
        $this->weakPasswordRule = $weakPasswordRule;
    }

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
}
