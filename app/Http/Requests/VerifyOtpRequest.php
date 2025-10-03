<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Phone number.
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
            'code' => ['required', 'string', 'size:5'],

            /**
             * Purpose of OTP verification.
             *
             * @var string
             *
             * @example register
             */
            'purpose' => ['required', 'string', 'in:register,login'],
        ];
    }
}
