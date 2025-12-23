<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\OtpCode;
use App\Models\OtpSession;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    public function sendOtp(array $validated): string
    {
        $code = '12345';

        OtpCode::create([
            'phone' => $validated['phone'],
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(2),
        ]);

        return $code;
    }

    /**
     * @throws Exception
     */
    public static function confirmOtp(array $validated): void
    {
        $otpCode = OtpCode::where('phone', $validated['phone'])->latest()->first();

        if (! $otpCode || $otpCode->code != $validated['code']) {
            throw new Exception(ErrorMessage::OTP_DID_NOT_MATCH_ERROR->value);
        }

        if (Carbon::now() > $otpCode->expires_at) {
            throw new Exception(ErrorMessage::OTP_TIMEOUT_ERROR->value);
        }
    }

    public function resetPassword(array $data): void
    {
        $phone = $data['phone'];
        $token = $data['token'];
        $newPassword = $data['password'];

        $session = OtpSession::where('phone', $phone)
            ->where('token', $token)
            ->where('purpose', 'reset_password')
            ->where('is_verified', true)
            ->where('expires_at', '>', now())
            ->first();

        if (! $session) {
            throw new \Exception(ErrorMessage::INVALID_OR_EXPIRED_OTP->value);
        }

        User::where('phone', $phone)->update([
            'password' => Hash::make($newPassword),
        ]);

        // Remove OTP and session
        $session->delete();
        OtpCode::where('phone', $phone)->delete();
    }
}
