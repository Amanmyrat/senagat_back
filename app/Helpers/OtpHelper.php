<?php

namespace App\Helpers;

use App\Models\Otp;
use App\Models\User;

class OtpHelper
{
    public static function getValidOtp(User $user, string $code)
    {
        return $user->otps()
            ->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();
    }
    public static function getValidOtpByPhone(string $phone, string $code)
    {

        return Otp::where('phone', $phone)
            ->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();
    }


    // public static function generateRandomOtp(int $length = 5): string
    // {
    //     return str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    // }
}
