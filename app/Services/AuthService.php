<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PreLoginRequest;
use App\Models\OtpSession;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    private function otpEnabled(): bool
    {
        return (bool) config('app.otp.enabled', false);
    }

    /**
     * Request OTP for registration or login
     *
     * @throws Exception
     */
    public function requestOtp(array $data): void
    {
        if (! $this->otpEnabled()) {
            throw new Exception(ErrorMessage::OTP_DISABLED->value);
        }

        $phone = $data['phone'];
        if (User::where('phone', $phone)->exists()) {
            throw new Exception(ErrorMessage::PHONE_ALREADY_REGISTERED->value);
        }


        $this->otpService->sendOtp($data);
    }

    /**
     * Verify OTP and create session token
     *
     * @throws Exception
     */
    public function verifyOtp(array $data): string
    {
        if (! $this->otpEnabled()) {
            throw new Exception(ErrorMessage::OTP_DISABLED->value);
        }
        OtpService::confirmOtp($data);

        if (User::where('phone', $data['phone'])->exists()) {
            throw new Exception(ErrorMessage::PHONE_ALREADY_REGISTERED->value);
        }

        $token = Str::random(60);

        OtpSession::create([
            'phone' => $data['phone'],
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(10),
            'is_verified' => true,
        ]);

        return $token;
    }

    /**
     * Register user with OTP session token
     *
     * @throws Exception
     */
    public function register(array $registerData): User
    {
        if ($this->otpEnabled()) {
            $otpSession = OtpSession::where('token', $registerData['otp_session_token'])
                ->where('is_verified', true)
                ->first();

            if (! $otpSession || $otpSession->isExpired()) {
                throw new \Exception(ErrorMessage::OTP_SESSION_INVALID->value);
            }
            $phone = $otpSession->phone;
        } else {
            $phone = $registerData['phone'];
        }

        if (User::where('phone', $phone)->exists()) {
            throw new Exception(ErrorMessage::PHONE_ALREADY_REGISTERED->value);
        }

        //        $existingUser = User::where('phone', $otpSession->phone)->first();
        //        if ($existingUser) {
        //            throw new \Exception(ErrorMessage::PHONE_ALREADY_REGISTERED->value);
        //        }

        $user = User::create([
            'phone' => $phone,
            'password' => Hash::make($registerData['password']),
        ]);

        if ($this->otpEnabled()) {
            $otpSession->delete();
        }

        return $user;
    }

    /**
     * Pre-login: validate password and send OTP
     *
     * @throws Exception
     */
    public function preLogin(PreLoginRequest $request): void
    {
        if (! $this->otpEnabled()) {
            throw new \Exception(ErrorMessage::OTP_DISABLED->value);
        }
        $phone = $request->input('phone');
        $password = $request->input('password');

        $user = User::where('phone', $phone)->first();
        if (! $user) {
            throw new \Exception(ErrorMessage::PHONE_NOT_REGISTERED->value);
        }

        if (! Hash::check($password, $user->password)) {
            throw new \Exception(ErrorMessage::INCORRECT_PASSWORD->value);
        }

        $this->otpService->sendOtp([
            'phone' => $phone,
        ]);
    }

    /**
     * Complete login with OTP
     *
     * @throws Exception
     */
    public function login(LoginRequest $request): User
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $user = User::with('profile')->where('phone', $phone)->first();
        if (! $user) {
            throw new \Exception(ErrorMessage::PHONE_NOT_REGISTERED->value);
        }
        if ($this->otpEnabled()) {
            $otp = $request->input('otp');
            if (! $otp) {
                throw new \Exception(ErrorMessage::OTP_REQUIRED->value);
            }
            OtpService::confirmOtp([
                'phone' => $phone,
                'code' => $otp,
            ]);
        } else {
            if (! $password || ! Hash::check($password, $user->password)) {
                throw new \Exception(ErrorMessage::INCORRECT_PASSWORD->value);
            }
        }

        //        $user = User::with('profile')->where('phone', $phone)->
        //        first();
        //        if (! $user) {
        //
        //            throw new \Exception(ErrorMessage::PHONE_NOT_REGISTERED->value);
        //        }

        return $user;
    }
}
