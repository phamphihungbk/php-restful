<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use TinnyApi\User\Repository as UserRepository;

class UserController extends Controller
{
    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
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
        $userRepository->update($request->all());
    }

    /**
     * @param UserRepository $userRepository
     * @throws \Exception
     */
    public function destroy(UserRepository $userRepository)
    {
        $userRepository->delete();
    }
}
