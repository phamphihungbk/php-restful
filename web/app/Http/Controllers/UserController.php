<?php

namespace App\Http\Controllers;

use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\Models\UserModel as User;
use TinnyApi\Requests\PasswordUpdateRequest;
use TinnyApi\Requests\UserUpdateRequest;
use TinnyApi\Resources\UserCollection;
use TinnyApi\Resources\UserResource;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     * @param CacheRepository $cacheRepository
     */
    public function __construct(UserRepository $userRepository, CacheRepository $cacheRepository)
    {
        $this->resourceItem = UserResource::class;
        $this->resourceCollection = UserCollection::class;
        $this->userRepository = $userRepository;
        $this->cacheRepository = $cacheRepository;
        $this->authorizeResource(User::class);
    }

    /**
     * List all users.
     */
    public function index(): UserCollection
    {
        $cacheTag = 'users';
        $cacheKey = 'users:' . auth()->id() . json_encode(request()->all());

        return $this->cacheRepository->tags($cacheTag)->remember($cacheKey, now()->addHour(), function () {
            $collection = $this->userRepository->findByFilters();

            return $this->respondWithCollection($collection);
        });
    }

    /**
     * Show a current logged user.
     *
     * @param Request $request
     * @return UserResource
     */
    public function profile(Request $request): UserResource
    {
        $user = $request->user();
        return $this->show($request, $user);
    }

    /**
     * Show an user.
     *
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function show(Request $request, User $user): UserResource
    {
        $allowedIncludes = [];

        if ($request->has('include')) {
            $with = array_intersect($allowedIncludes, explode(',', strtolower($request->get('include'))));

            $cacheTag = 'users';
            $cacheKey = implode($with) . $user->id;

            $user = $this->cacheRepository->tags($cacheTag)->remember(
                $cacheKey,
                now()->addHour(),
                function () use ($with, $user) {
                    return $user->load($with);
                }
            );
        }

        return $this->respondWithItem($user);
    }

    /**
     * Update the current logged user.
     *
     * @param UserUpdateRequest $request
     * @return UserResource
     */
    public function updateMe(UserUpdateRequest $request): UserResource
    {
        $user = $request->user();
        return $this->update($request, $user);
    }

    /**
     * Update an user.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $data = $request->validated();
        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }

    /**
     * Update password of logged user.
     *
     * @param PasswordUpdateRequest $request
     * @return UserResource
     */
    public function updatePassword(PasswordUpdateRequest $request): UserResource
    {
        $user = $request->user();
        $data = $request->only(['password']);

        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }
}
