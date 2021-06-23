<?php

namespace TinnyApi\Requests;

use App\Exceptions\DataValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new DataValidationException($validator);
    }
}
