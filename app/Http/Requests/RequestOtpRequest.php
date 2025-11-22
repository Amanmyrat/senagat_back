<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use Illuminate\Foundation\Http\FormRequest;

class RequestOtpRequest extends FormRequest
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
             * Purpose of OTP request.
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
            'phone.required' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'phone.regex' => ErrorMessage::PHONE_NUMBER_INVALID->value,
            'purpose.required' => ErrorMessage::OTP_PURPOSE_REQUIRED->value,
            'purpose.in' => ErrorMessage::OTP_PURPOSE_INVALID->value,
        ];
    }
}
