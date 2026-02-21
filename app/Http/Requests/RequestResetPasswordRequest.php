<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use Illuminate\Foundation\Http\FormRequest;

class RequestResetPasswordRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'phone.regex' => ErrorMessage::PHONE_NUMBER_INVALID->value,

        ];
    }
}
