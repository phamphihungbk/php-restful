<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use TinnyApi\Traits\ResponseTrait;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception): Response
    {
        dd($exception->getMessage());
        $exceptionInstance = get_class($exception);

        switch ($exceptionInstance) {
            case AuthenticationException::class:
                $status = Response::HTTP_UNAUTHORIZED;
                $message = $exception->getMessage();
                break;

            case LockedException::class:
                $status = Response::HTTP_LOCKED;
                $message = $exception->getMessage();
                break;

            case ThrottleRequestsException::class:
                $status = Response::HTTP_TOO_MANY_REQUESTS;
                $message = 'Too many Requests';
                break;

            case ValidationException::class:
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                $message = $exception->getMessage();
                break;

            default:
                $status = $exception->getCode();
                $message = $exception->getMessage();
                break;
        }

        if (!empty($status) && !empty($message)) {
            return $this->respondWithCustomData(['message' => $message], $status);
        }

        return parent::render($request, $exception);
    }
}
