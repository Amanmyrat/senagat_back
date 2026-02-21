<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
             * Reset Token.
             *
             * @var string
             *
             * @example ABC123
             */
            'token' => ['required', 'string'],
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

    public function messages(): array
    {
        return [
            'phone.required' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'phone.regex' => ErrorMessage::PHONE_NUMBER_INVALID->value,
            'password.required' => ErrorMessage::PASSWORD_REQUIRED->value,
            'password.min' => ErrorMessage::PASSWORD_MIN->value,
        ];
    }
}
