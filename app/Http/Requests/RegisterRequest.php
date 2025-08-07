<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * OTP session token from verify-otp step.
             *
             * @var string
             *
             * @example abc123def456
             */
            'otp_session_token' => ['required', 'string'],

            /**
             * Password.
             *
             * @var string
             *
             * @example 12345678
             */
            'password' => ['required', 'string', 'min:4'],
        ];
    }
}
