<?php

namespace App\Services;

use App\Models\User;
use App\Models\Otp;
use App\Helpers\OtpHelper;

class OtpService
{

    public function sentOtpToUser(User $user): Otp
    {
        return Otp::generateForPhone($user->id, $user->phone);
    }
}
