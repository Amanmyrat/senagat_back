<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (! config('app.otp.enabled')) {
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
                 * Password.
                 *
                 * @var string
                 *
                 * @example 12345678
                 */
                'password' => ['nullable', 'string', 'min:4'],
            ];
        }

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

    public function messages(): array
    {
        return [
            'otp_session_token.required' => ErrorMessage::OTP_SESSION_TOKEN_REQUIRED->value,
            'password.required' => ErrorMessage::PASSWORD_REQUIRED->value,
            'password.min' => ErrorMessage::PASSWORD_MIN->value,
        ];
    }
}
