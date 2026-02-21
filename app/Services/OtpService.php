<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\OtpCode;
use Carbon\Carbon;
use Exception;

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
        //        $otpCode->delete();
    }
}
