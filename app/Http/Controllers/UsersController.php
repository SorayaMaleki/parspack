<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Users\UserServiceInterface;
use App\Traits\Response\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController
{
    use ApiResponse;

    /**
     * Bind service.
     *
     * @param UserServiceInterface $userService The user service implementation.
     */
    public function __construct(
        protected UserServiceInterface $userService
    ) {
    }

    /**
     * Register the new user.
     *
     * @param RegisterRequest $request The request instance.
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->userService->register($request);
        return $this->successResponse($data, [__('api.success_register')], 201);
    }

    /**
     * Login with password.
     *
     * @param LoginRequest $request The request instance.
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->userService->login($request);
        return $this->successResponse($data, [__('api.success_login')]);
    }

    /**
     * Logout.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return $this->successResponse([], [__('api.logged_out')]);
    }
}
