<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\LockedException;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use TinnyApi\Models\UserModel;
use TinnyApi\Notifications\VerifyEmailNotification;
use TinnyApi\Traits\ResponseTrait;

class LoginController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests, ResponseTrait;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * @var VerifyEmailNotification
     */
    private $verifyEmailNotification;

    /**
     * Create a new controller instance.
     *
     * @param CacheRepository $cacheRepository
     * @param VerifyEmailNotification $verifyEmailNotification
     */
    public function __construct(CacheRepository $cacheRepository, VerifyEmailNotification $verifyEmailNotification)
    {
        $this->middleware('guest')->except('logout');
        $this->cacheRepository = $cacheRepository;
        $this->verifyEmailNotification = $verifyEmailNotification;
    }

    /**
     * {@inheritdoc}
     */
    protected function attemptLogin(Request $request): bool
    {
        return $this->guard()->attempt($this->credentials($request));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function sendLoginResponse(Request $request): JsonResponse
    {
        $user = $request->user();

        try {
            $this->checkUserIfIsActive($user, $request);
            $this->checkIfUserHasVerifiedEmail($user, $request);
        } catch (LockedException $exception) {
            return $this->respondWithCustomData([
                'message' => $exception->getMessage(),
            ], Response::HTTP_LOCKED);
        }

        $this->clearLoginAttempts($request);

        $token = $user->createToken('TINNY-API Personal Access Client');
        $expiration = Carbon::parse($token->token->expires_at)->toDateTimeString();

        return $this->respondWithCustomData([
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $expiration
        ]);
    }

    /**
     * @param UserModel $user
     * @param Request $request
     */
    private function checkUserIfIsActive(UserModel $user, Request $request)
    {
        if (!$user->is_active) {
            $this->logout($request);

            $supportLink = config('support.support_url');

            $message = __(
                'Your account has been disabled, to enable it again, ' .
                'please contact :support_link to start the process.',
                ['support_link' => '<a href="' . $supportLink . '">' . $supportLink . '</a>']
            );

            throw new LockedException($message);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function logout(Request $request)
    {
        $id = $this->guard()->id();

        $this->cacheRepository->forget($id);
        $this->cacheRepository->tags('users:' . $id)->flush();

        $this->guard()->user()->token()->revoke();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return $request->wantsJson() ? $this->respondWithNoContent() : redirect('/');
    }

    /**
     * @param UserModel $user
     * @param Request $request
     */
    private function checkIfUserHasVerifiedEmail(UserModel $user, Request $request)
    {
        if (!$user->hasVerifiedEmail()) {
            Notification::send($user, $this->verifyEmailNotification->setToken($user->email_token_confirmation));

            $this->logout($request);

            $message = __(
                'We sent a confirmation email to :email. Please follow the instructions to complete your registration.',
                ['email' => $user->email]
            );

            throw new LockedException($message);
        }
    }
}
