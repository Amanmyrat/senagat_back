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

    /**
     * @throws Exception
     */
    private function ensureOtpIsEnabled(): void
    {
        if (!(bool) config('app.otp.enabled', false)) {
            throw new Exception(ErrorMessage::OTP_DISABLED->value);
        }
    }

    /**
     * Step 1: Request reset password (send OTP)
     * @throws Exception
     */
    public function request(string $phone): void
    {

        $this->ensureOtpIsEnabled();
        if (!User::where('phone', $phone)->exists()) {
            throw new Exception(ErrorMessage::PHONE_NOT_REGISTERED->value);
        }


        OtpSession::where('phone', $phone)
            ->delete();

        $this->otpService->sendOtp([
            'phone' => $phone,
        ]);
    }

    /**
     * Step 2: Confirm OTP and create reset token
     * @throws Exception
     */
    public function confirm(string $phone, string $code): string
    {

        $this->ensureOtpIsEnabled();
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
     * @throws Exception
     *
     */
    public function reset(string $phone, string $token, string $password): void
    {
        $this->ensureOtpIsEnabled();

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

        $session->delete();
        OtpCode::where('phone', $phone)->delete();
    }
}
