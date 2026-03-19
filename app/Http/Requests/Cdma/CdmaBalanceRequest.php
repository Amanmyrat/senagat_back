<?php

namespace App\Http\Requests\Cdma;

use App\Enum\ErrorMessage;
use Illuminate\Foundation\Http\FormRequest;

class CdmaBalanceRequest extends FormRequest
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
             * @example 60101009
             */
            'phone' => ['required', 'string', 'regex:/^[0-9]{8}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'phone.regex'    => ErrorMessage::PHONE_NUMBER_INVALID->value,
        ];
    }
}
