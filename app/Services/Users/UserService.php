<?php

namespace App\Services\Users;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/**
 * Class CommentService
 *
 * @package App\Services
 */
class UserService implements UserServiceInterface
{

    /**
     * UserService constructor.
     *
     * @param  UserRepositoryInterface  $repository User repository instance.
     */
    public function __construct(
      protected UserRepositoryInterface $repository
    ) {
    }

    /**
     * Registers a user.
     *
     * @param  LoginRequest  $request  The request containing user data.
     *
     * @return array
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request): array
    {
        $user = $this->repository->findByCriteria(['email' => $request->email]);
        if (!Hash::check($request->password, $user->password)) {
            throw new AuthenticationException();
        }
        Auth::login($user);
        $token = $request->user()->createToken('api_token', ['*']
        )->plainTextToken;
        return compact('token', 'user');
    }

    /**
     * Registers a user.
     *
     * @param  RegisterRequest  $request  The request containing user data.
     *
     * @return array
     */
    public function register(RegisterRequest $request): array
    {
        $user = $this->repository->create($request->validated());
        Auth::login($user);
        $token = $request->user()->createToken('api_token', ['*']
        )->plainTextToken;
        return compact('token', 'user');
    }

}
