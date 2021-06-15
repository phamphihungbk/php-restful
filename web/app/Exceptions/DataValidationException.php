<?php

namespace App\Exceptions;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class DataValidationException extends ValidationException
{
    /**
     * @var Validator
     */
    public $validator;

    /**
     * Create a new exception instance.
     *
     * @param Validator $validator
     * @param Response $response
     * @param string $errorBag
     * @return void
     */
    public function __construct(Validator $validator, $response = null, $errorBag = 'default')
    {
        parent::__construct($validator);

        $this->response = $response;
        $this->errorBag = $errorBag;
        $this->validator = $validator;
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return new JsonResponse([
            'data' => [
                'message' => 'The given data was invalid.',
                'errors' => $this->validator->errors()->messages(),
            ],
            'meta' => [
                'timestamp' => intdiv((int)now()->format('Uu'), 1000)
            ],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
