<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\Resources\UserCollection;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * List all users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = [
            'message' => 'Get all data successfully',
            'data' => $this->userRepository->getAll(),
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->userRepository->store($request->all());
        $data = [
            'message' => 'Create successfully'
        ];

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * @param string $email
     * @return JsonResponse
     */
    public function show(string $email): JsonResponse
    {
        $data = [
            'message' => 'Find user successfully',
            'data' => $this->userRepository->select($email),
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param string $email
     * @param Request $request
     * @return JsonResponse
     */
    public function update(string $email, Request $request): JsonResponse
    {
        $this->userRepository->update($email, $request->all());
        $data = [
            'message' => 'Update successfully'
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param string $email
     * @return JsonResponse
     */
    public function destroy(string $email): JsonResponse
    {
        $this->userRepository->delete($email);
        $data = [
            'message' => 'Delete successfully'
        ];

        return response()->json($data, Response::HTTP_NO_CONTENT);
    }
}
