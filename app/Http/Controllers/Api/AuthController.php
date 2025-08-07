<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CheckRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\CheckService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiBaseController
{
    public function __construct(
        protected AuthService $service,
        protected CheckService $checkService
    ) {}


    /**
     * Create User
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->service->register($request->validated());

            $token = $user->createToken('mobile', ['role:user'])->plainTextToken;

            return (new UserResource($user))
                ->additional(['token' => $token])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return  new JsonResponse([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {

            $this->service->login($request);

            $user = $request->user();

            $token = $user->createToken('mobile', ['role:user'])->plainTextToken;

            return (new UserResource($user))
                ->additional(['token' => $token])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return  new JsonResponse([
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Check Number
     *
     *
     */
    public function check(CheckRequest $request): JsonResponse
    {
        try {
            $phone = $request->validated('phone');
            $exists = $this->checkService->checkPhoneExists($phone);

            if ($exists) {
                return response()->json([
                    'exists' => true,
                    'message' => 'Phone number already registered.',
                ]);
            } else {
                return response()->json([
                    'exists' => false,
                    'message' => 'Phone number not found, can be registered.',
                ]);
            }
        }catch (Exception $e){
            return new JsonResponse([
                'error'=>$e->getMessage(),
            ]);
        }
    }
}
