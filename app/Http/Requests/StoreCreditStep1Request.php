<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditStep1Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Credit details
             *
             * @var int
             *
             * @example 1
             */
            'credit_id' => ['required', 'integer', 'exists:credit_types,id'],

            /**
             * Years of credit
             *
             * @var int
             *
             * @example 5
             */
            'term' => ['required', 'integer', 'min:1'],

            /**
             * Amount
             *
             * @var float
             *
             * @example 50000.00
             */
            'amount' => ['required', 'numeric', 'min:1'],

            /**
             * Monthly payment
             *
             * @var float
             *
             * @example 12.5
             */
            'monthly_payment' => ['required', 'numeric',],

        ];
    }

    public function messages(): array
    {
        return [
            'credit_id.required' => 'Select loan',
            'years.required' => 'Enter the loan term.',
            'amount.required' => 'Enter the amount',
            'interest.required' => 'Enter the percentage',
        ];
    }
}
