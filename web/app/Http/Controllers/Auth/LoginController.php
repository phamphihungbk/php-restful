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
use TinnyApi\Models\UserModel;
use TinnyApi\Traits\ResponseTrait;

class LoginController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests, ResponseTrait;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * Create a new controller instance.
     *
     * @param CacheRepository $cacheRepository
     */
    public function __construct(CacheRepository $cacheRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->cacheRepository = $cacheRepository;
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
        } catch (LockedException $exception) {
            return $this->respondWithCustomData([
                'message' => $exception->getMessage(),
            ], Response::HTTP_LOCKED);
        }

        $this->clearLoginAttempts($request);

        $personalToken = $user->createToken('Personal Token');
        $user->withAccessToken($personalToken->token);

        return $this->respondWithCustomData([
            'access_token' => $personalToken->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($personalToken->token->expires_at)->toDateTimeString()
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
        $id = $request->user()->id;

        $this->cacheRepository->forget($id);
        $this->cacheRepository->tags('users:' . $id)->flush();
        $request->user()->token()->revoke();

        return $request->wantsJson() ?
            $this->respondWithCustomData(['message' => 'Logout successfully']) : redirect('/');
    }
}
