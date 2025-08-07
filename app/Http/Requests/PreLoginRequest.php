<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreLoginRequest extends FormRequest
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
