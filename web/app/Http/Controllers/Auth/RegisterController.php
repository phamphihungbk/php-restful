<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Http\Response;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\Rules\WeakPasswordRule;
use TinnyApi\Traits\ResponseTrait;
use TinnyApi\User\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use ResponseTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }

    /**
     * The user has been registered.
     *
     * @param Request $request
     * @param UserModel $user
     * @return mixed
     */
    private function registered(Request $request, UserModel $user)
    {
        Auth::guard()->logout();

        $message = __(
            'We sent a confirmation email to :email. Please follow the instructions to complete your registration.',
            ['email' => $user->email]
        );

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_CREATED);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return Validator
     */
    private function getValidator(array $data): Validator
    {
        return ValidatorFactory::make($data, [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    new WeakPasswordRule(),
                ],
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Model
     */
    private function create(array $data): Model
    {
        return $this->userRepository->store([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_active' => 1,
            'email_verified_at' => null,
            'facebook' => $data['facebook'] ?? '',
            'twitter' => $data['twitter'] ?? '',
        ]);
    }
}
