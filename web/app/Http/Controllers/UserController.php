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
        $userRepository->update($request->all());
        $data = [
            'message' => ''
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function show(UserRepository $userRepository): JsonResponse
    {
        $data = [
            'message' => ''
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function update(Request $request, UserRepository $userRepository): JsonResponse
    {
        $userRepository->update($request->all());
        $data = [
            'message' => ''
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function destroy(UserRepository $userRepository): JsonResponse
    {
        $userRepository->delete();

        $data = [
            'message' => ''
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
