<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\LockedException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use TinnyApi\Models\UserModel;
use TinnyApi\Traits\ResponseTrait;

class LoginController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests, ResponseTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * {@inheritdoc}
     */
    protected function attemptLogin(Request $request): bool
    {
        $token = $this->guard()->attempt($this->credentials($request));

        if ($token) {
            $this->guard()->setToken($token);
            return true;
        }

        return false;
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
            $data['user_id'] = $user->id;
        } catch (LockedException $exception) {
            return $this->respondWithCustomData([
                'message' => $exception->getMessage(),
                'isVerify2fa' => false,
            ], Response::HTTP_LOCKED);
        }

        $this->clearLoginAttempts($request);

        $token = (string)$this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return $this->respondWithCustomData([
            'token' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => $expiration - time(),
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

            $supportLink = config('app.support_url');

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
     * @return void
     */
    public function logout(Request $request): void
    {
        $id = $this->guard()->id();

        Cache::forget($id);
        Cache::tags('users:' . $id)->flush();

        $this->guard()->logout();
    }
}
