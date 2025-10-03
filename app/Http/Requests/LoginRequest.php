<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Phone.
             *
             * @var string
             *
             * @example 65021734
             */
            'phone' => ['required', 'string', 'regex:/^[0-9]{8}$/'],

            /**
             * OTP code.
             *
             * @var string
             *
             * @example 12345
             */
            'otp' => ['required', 'string', 'size:5'],
        ];
    }
}
