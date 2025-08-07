<?php

namespace App\Enum;

enum ErrorMessage: string
{
    case OTP_DID_NOT_MATCH_ERROR = 'OTP code does not match.';
    case OTP_TIMEOUT_ERROR = 'OTP code has expired.';
    case OTP_DID_NOT_SENT_ERROR = 'OTP could not be sent.';
}
