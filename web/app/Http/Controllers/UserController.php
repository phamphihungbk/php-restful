<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use TinnyApi\User\RepositoryContract as UserRepository;

class UserController extends Controller
{
    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function index(UserRepository $userRepository): JsonResponse
    {
        $data = $userRepository->getAll();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function store(Request $request, UserRepository $userRepository): JsonResponse
    {
        $userRepository->store($request->all());
        $data = [
            'message' => 'Create successfully'
        ];

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * @param string $email
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function show(string $email , UserRepository $userRepository): JsonResponse
    {
        $data = $userRepository->select($email);

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param string $email
     * @param Request $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function update(string $email, Request $request, UserRepository $userRepository): JsonResponse
    {
        $userRepository->update($email ,$request->all());
        $data = [
            'message' => 'Update successfully'
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param string $email
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function destroy(string $email ,UserRepository $userRepository): JsonResponse
    {
        $userRepository->delete($email);
        $data = [
            'message' => 'Delete successfully'
        ];

        return response()->json($data, Response::HTTP_NO_CONTENT);
    }
}
