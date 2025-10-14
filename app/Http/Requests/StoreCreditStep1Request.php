<?php

namespace App\Http\Requests;

use App\Models\CreditType;
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
            'term' => ['required', 'numeric', 'min:1'],

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
            'monthly_payment' => ['required', 'numeric'],

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
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('credit_id') && $this->filled('amount')) {
                $credit = CreditType::find($this->credit_id);
                if ($credit) {
                    if ($this->amount < $credit->min_amount || $this->amount > $credit->max_amount) {
                        $validator->errors()->add(
                            'amount',
                            'Requested amount cannot exceed the credit limit'
                        );
                    }
                    if ($this->term > $credit->term) {
                        $validator->errors()->add(
                            'term',
                            'Requested term cannot exceed the credit limit'
                        );
                    }
                }
            }
        });
    }
}
