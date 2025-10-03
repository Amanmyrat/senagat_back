<?php

namespace App\Services;

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

    /**
     * Request OTP for registration or login
     *
     * @throws Exception
     */
    public function requestOtp(array $data): void
    {
        $phone = $data['phone'];
        $purpose = $data['purpose'];

        if ($purpose === 'register') {
            if (User::where('phone', $phone)->exists()) {
                throw new Exception('This phone number is already registered');
            }
        }

        if ($purpose === 'login') {
            if (! User::where('phone', $phone)->exists()) {
                throw new Exception('Phone number not registered');
            }
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
        OtpService::confirmOtp($data);

        $token = Str::random(60);

        OtpSession::create([
            'phone' => $data['phone'],
            'token' => $token,
            'purpose' => $data['purpose'],
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
        $otpSession = OtpSession::where('token', $registerData['otp_session_token'])
            ->where('purpose', 'register')
            ->where('is_verified', true)
            ->first();

        if (! $otpSession || $otpSession->isExpired()) {
            throw new Exception('Invalid or expired OTP session token');
        }

        $existingUser = User::where('phone', $otpSession->phone)->first();
        if ($existingUser) {
            throw new Exception('This phone number is already registered');
        }

        $user = User::create([
            'phone' => $otpSession->phone,
            'password' => Hash::make($registerData['password']),
        ]);

        $otpSession->delete();

        return $user;
    }

    /**
     * Pre-login: validate password and send OTP
     *
     * @throws Exception
     */
    public function preLogin(PreLoginRequest $request): void
    {
        $phone = $request->input('phone');
        $password = $request->input('password');

        $user = User::where('phone', $phone)->first();
        if (! $user) {
            throw new Exception('Phone number not registered');
        }

        if (! Hash::check($password, $user->password)) {
            throw new Exception('Incorrect password');
        }

        $this->otpService->sendOtp([
            'phone' => $phone,
            'purpose' => 'login',
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
        $otp = $request->input('otp');

        OtpService::confirmOtp([
            'phone' => $phone,
            'code' => $otp,
        ]);

        $user = User::with('profile')->where('phone', $phone)->
        first();
        if (! $user) {
            throw new Exception('Phone number not registered');
        }

        return $user;
    }
}
