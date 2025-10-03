<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Certificate Type id
             *
             * @var int
             *
             * @example 1
             */
            'certificate_type_id' => ['required', 'integer', 'exists:certificate_types,id'],

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
             * Home address
             *
             * @var string
             *
             * @example 941265
             */
            'home_address' => ['required', 'string'],
        ];
    }
}
