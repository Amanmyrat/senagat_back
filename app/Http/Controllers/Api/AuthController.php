<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CheckPhoneExistenceRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PreLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RequestOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function __construct(
        protected AuthService $service
    ) {}

    /**
     * Request OTP for registration or login
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function requestOtp(RequestOtpRequest $request): JsonResponse
    {
        try {
            $this->service->requestOtp($request->validated());

            return new JsonResponse([
                'success' => true,
                'message' => 'OTP sent successfully',
            ]);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'Failed to send OTP',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Verify OTP and get session token
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        try {
            $token = $this->service->verifyOtp($request->validated());

            return new JsonResponse([
                'success' => true,
                'otp_session_token' => $token,
                'message' => 'OTP verified successfully',
            ]);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'OTP verification failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Create User with OTP session token
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->service->register($request->validated());
            $token = $user->createToken('mobile')->plainTextToken;

            return (new UserResource($user))
                ->additional(['token' => $token])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Pre-login: validate password and send OTP
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function preLogin(PreLoginRequest $request): JsonResponse
    {
        try {
            $this->service->preLogin($request);

            return new JsonResponse([
                'success' => true,
                'message' => 'Password verified, OTP sent for final authentication',
            ]);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'Pre-login failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Complete login with OTP
     *
     * @unauthenticated
     *
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->service->login($request);
            $token = $user->createToken('mobile')->plainTextToken;

            return (new UserResource($user))
                ->additional(['token' => $token])
                ->response()
                ->setStatusCode(200);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Check phone number
     */
    public function checkPhoneExists(CheckPhoneExistenceRequest $request): JsonResponse
    {
        try {
            $phone = $request->validated('phone');
            $exists = User::where('phone', $phone)->exists();

            return new JsonResponse([
                'exists' => $exists,
            ]);
        } catch (Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
