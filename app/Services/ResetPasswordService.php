<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\OtpCode;
use App\Models\OtpSession;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordService
{
    public function __construct(
        private OtpService $otpService
    ) {}

    private function otpEnabled(): bool
    {
        return (bool) config('app.otp.enabled', false);
    }

    private function authUser(): User
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            throw new Exception(ErrorMessage::PHONE_MISMATCH->value);
        }

        return $user;
    }

    /**
     * Step 1: Request reset password (send OTP)
     */
    public function request(string $phone): void
    {

        if (! $this->otpEnabled()) {
            throw new Exception(ErrorMessage::OTP_DISABLED->value);
        }
        $user = $this->authUser();
        if ($user->phone !== $phone) {
            throw new Exception(ErrorMessage::PHONE_MISMATCH->value);
        }

        OtpSession::where('phone', $phone)
            ->delete();

        $this->otpService->sendOtp([
            'phone' => $phone,
        ]);
    }

    /**
     * Step 2: Confirm OTP and create reset token
     */
    public function confirm(string $phone, string $code): string
    {
        if (! $this->otpEnabled()) {
            throw new Exception(ErrorMessage::OTP_DISABLED->value);
        }

        $user = $this->authUser();

        if ($user->phone !== $phone) {
            throw new Exception(ErrorMessage::PHONE_MISMATCH->value);
        }

        OtpService::confirmOtp([
            'phone' => $phone,
            'code' => $code,
        ]);

        $token = Str::random(60);

        $session = OtpSession::create([
            'phone' => $phone,
            'token' => $token,
            'is_verified' => true,
            'expires_at' => now()->addMinutes(5),
        ]);

        return $session->token;
    }

    /**
     * Step 3: Reset password with token
     */
    public function reset(string $phone, string $token, string $password): void
    {
        if (! $this->otpEnabled()) {
            throw new Exception(ErrorMessage::OTP_DISABLED->value);
        }
        $user = $this->authUser();

        if ($user->phone !== $phone) {
            throw new Exception(ErrorMessage::PHONE_MISMATCH->value);
        }
        $session = OtpSession::where('phone', $phone)
            ->where('token', $token)
            ->where('is_verified', true)
            ->where('expires_at', '>', now())
            ->first();

        if (! $session) {
            throw new Exception(ErrorMessage::INVALID_OR_EXPIRED_OTP->value);
        }

        $user = User::where('phone', $phone)->first();
        if (! $user) {
            throw new Exception(ErrorMessage::PHONE_NOT_REGISTERED->value);
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        // cleanup
        $session->delete();
        OtpCode::where('phone', $phone)->delete();
    }
}
