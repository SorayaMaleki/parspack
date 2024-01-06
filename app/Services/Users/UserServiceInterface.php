<?php

namespace App\Services\Users;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

interface UserServiceInterface
{

    /**
     * Registers a user.
     *
     * @param  LoginRequest  $request  The request containing user data.
     *
     * @return array
     */
    public function login(LoginRequest $request): array;

    /**
     * Registers a user.
     *
     * @param  RegisterRequest  $request  The request containing user data.
     *
     * @return array
     */
    public function register(RegisterRequest $request): array;

}
