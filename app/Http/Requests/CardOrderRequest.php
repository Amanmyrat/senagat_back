<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Card Type
             *
             * @var int
             *
             * @example 1
             */
            'card_type_id' => ['required', 'integer', 'exists:card_types,id'],

            /**
             * Phone number
             *
             * @var string
             *
             * @example 65021734
             */
            'phone_number' => ['required',  'string', 'regex:/^[0-9]{8}$/'],

            /**
             * Bank Branch
             *
             * @var string
             *
             * @example Merkezi Bank
             */
            'bank_branch' => ['required', 'string', 'min:1'],

            /**
             * Home phone number
             *
             * @var string
             *
             * @example 941265
             */
            'home_phone_number' => ['required', 'string'],
        ];
    }
}
