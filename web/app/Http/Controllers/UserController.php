<?php

namespace App\Http\Controllers;

use TinnyApi\User\Repository as UserRepository;

class UserController extends Controller
{
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->getAll();
        return response()->json($users, Response::HTTP_OK);

    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param UserRepository $userRepository
     */
    public function show(UserRepository $userRepository)
    {
        //
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     */
    public function update(Request $request, UserRepository $userRepository)
    {
        //
    }

    /**
     * @param UserRepository $userRepository
     */
    public function destroy(UserRepository $userRepository)
    {
        //
    }
}
