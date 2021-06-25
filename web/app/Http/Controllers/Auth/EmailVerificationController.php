<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\Events\EmailWasVerifiedEvent;

class EmailVerificationController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Dispatcher
     */
    private $event;
    /**
     * @var EmailWasVerifiedEvent
     */
    private $emailWasVerifiedEvent;

    /**
     * EmailVerificationController constructor.
     *
     * @param UserRepository $userRepository
     * @param Dispatcher $event
     * @param EmailWasVerifiedEvent $emailWasVerifiedEvent
     */
    public function __construct(
        UserRepository $userRepository,
        Dispatcher $event,
        EmailWasVerifiedEvent $emailWasVerifiedEvent
    ) {
        $this->userRepository = $userRepository;
        $this->event = $event;
        $this->emailWasVerifiedEvent = $emailWasVerifiedEvent;
    }

    public function verify($token): JsonResponse
    {
        try {
            $user = $this->userRepository->findOneBy(['email_token_confirmation' => $token]);
        } catch (Exception $exception) {
            $message = __('Invalid token for email verification');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
        }

        if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            $this->event->dispatch(new EmailWasVerifiedEvent($user));

            $message = __('Email successfully verified');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_OK);
        }

        $message = __('Invalid token for email verification');

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
    }
}
