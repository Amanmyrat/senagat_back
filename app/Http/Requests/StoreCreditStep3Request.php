<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditStep3Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Country
             *
             * @var string
             *
             * @example Aşgabat
             */
            'country' => ['required', 'string', 'max:255'],
            /**
             * Bank_name
             *
             * @var string
             *
             * @example Merkezi bank
             */
            'bank_name' => ['required', 'string', 'max:255'],
        ];
    }
}
