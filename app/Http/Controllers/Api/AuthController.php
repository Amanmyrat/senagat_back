<?php

namespace App\Http\Controllers\Api;

use App\Enum\ErrorMessage;
use App\Enum\SuccessMessage;
use App\Http\Requests\CheckPhoneExistenceRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PreLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RequestOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Resources\UserInformationResource;
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
     * User Informations
     *
     * @localizationHeader
     *
     * @throws Exception
     */
    public function userInfo(): JsonResponse
    {

        $user = auth('sanctum')->user();

        if (! $user) {
            return new JsonResponse([
                'success' => false,
                'code' => ErrorMessage::UNAUTHORIZED->value,
            ], 401);
        }

        $user->load(['certificates.certificateType', 'applications', 'cards']);

        return new JsonResponse([
            'success' => true,
            'code' => SuccessMessage::USER_INFO_RETRIEVED->value,
            'data' => new UserInformationResource($user),
        ], 200);
    }

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
                'code' => SuccessMessage::OTP_SENT->value,
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
//                'code' => ErrorMessage::OTP_DID_NOT_SENT_ERROR->value,
                'error_message' => $e->getMessage(),
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
                'code' => SuccessMessage::OTP_VERIFIED->value,
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
               // 'code' => ErrorMessage::OTP_DID_NOT_MATCH_ERROR->value,
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
            $user->token = $token;

            return new JsonResponse([
                'success' => true,
               // 'code' => SuccessMessage::USER_REGISTERED->value,
                'data' => new UserResource($user),
            ], 201);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
              //  'code' => ErrorMessage::REGISTRATION_FAILED->value,
                'error_message' => $e->getMessage(),
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

            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
             //   'code' => ErrorMessage::PRE_LOGIN_FAILED->value,
                'error_message' => $e->getMessage(),
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
            $user->token = $token;

            return new JsonResponse([
                'success' => true,
                'data' => new UserResource($user),
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
              //  'code' => ErrorMessage::LOGIN_FAILED->value,
                'error_message' => $e->getMessage(),
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

            if ($exists) {
                return new JsonResponse([
                    'success' => true,
                    'exists' => true,
                ], 200);
            }

            return new JsonResponse([
                'success' => false,
                'code' => ErrorMessage::PHONE_NOT_FOUND->value,
                'exists' => false,
            ], 404);

        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
              //  'code' => ErrorMessage::SERVER_ERROR->value,
                'error_message' => $e->getMessage(),
            ], 500);
        }
    }
}
