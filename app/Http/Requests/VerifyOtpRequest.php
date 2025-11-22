<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
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

    public function messages(): array
    {
        return [
            'phone.required' => ErrorMessage::PHONE_REQUIRED->value,
            'phone.regex' => ErrorMessage::PHONE_INVALID->value,
            'code.required' => ErrorMessage::OTP_CODE_REQUIRED->value,
            'code.size' => ErrorMessage::OTP_CODE_INVALID->value,
            'purpose.required' => ErrorMessage::OTP_PURPOSE_REQUIRED->value,
            'purpose.in' => ErrorMessage::OTP_PURPOSE_INVALID->value,
        ];
    }
}
