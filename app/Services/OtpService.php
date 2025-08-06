<?php

namespace App\Services;

use App\Helpers\OtpHelper;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use App\Enum\ErrorMessage;

class OtpService
{

    public function sendOTP(array $validated): int
    {
        $code = '00000';


        OtpCode::create([
            'phone' => $validated['phone'],
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(config('otp.timeout'))->addMinute(),
        ]);
        return $code;

        // $command = 'gammu sendsms TEXT ' . escapeshellarg($phoneNumber) . ' -text ' . escapeshellarg($message);


        // Execute the command
        // exec($command, $output, $returnVar);

        // if ($returnVar === 0) {


        //    
        // }

        // throw new Exception(ErrorMessage::OTP_DID_NOT_SENT_ERROR->value);
    }


    public static function confirmOTP(array $validated): void
    {
        $otpCode = OtpCode::where('phone', $validated['phone'])->latest()->first();

        if (! $otpCode || $otpCode->code != $validated['code']) {
            throw new Exception(ErrorMessage::OTP_DID_NOT_MATCH_ERROR->value);
        }

        if (Carbon::now() > $otpCode->expires_at) {
            throw new Exception(ErrorMessage::OTP_TIMEOUT_ERROR->value);
        }
    }
}
