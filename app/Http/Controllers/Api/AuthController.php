<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Transformers\UserTransformer;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiBaseController
{
    public function __construct(protected AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Create User
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->service->register($request->validated());

        $user->token = $user->createToken('mobile', ['role:user'])->plainTextToken;



        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Login user
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $this->service->login($request);

        $user = $request->user();

        $user->token = $user->createToken('mobile', ['role:user'])->plainTextToken;



        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
