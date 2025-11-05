<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use App\Models\CreditType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoanOrderRequest extends FormRequest
{
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

            /**
             * Role
             *
             * @var string
             *
             * @example manager or entrepreneur
             */
            'role' => ['required', 'string', 'in:manager,entrepreneur'],

            // Entrepreneur fields
            /**
             * Patent_number
             *
             * @var string
             *
             *  @example Entrepreneur fields
             */
            'patent_number' => ['required_if:role,entrepreneur', 'string', 'max:255'],
            /**
             * Registration Number
             *
             * @var string
             *
             *  @example Entrepreneur fields
             */
            'registration_number' => ['required_if:role,entrepreneur', 'string', 'max:255'],
            /**
             * Work Address
             *
             * @var string
             *
             *  @example Entrepreneur fields
             */
            'work_address' => ['required_if:role,entrepreneur', 'string', 'max:255'],

            // Manager fields
            /**
             * Workplace
             *
             * @var string
             *
             *  @example Manager fields
             */
            'workplace' => ['required_if:role,manager', 'string', 'max:255'],
            /**
             * Position
             *
             * @var string
             *
             *  @example Manager fields
             */
            'position' => ['required_if:role,manager', 'string', 'max:255'],
            /**
             * Manager Work Address
             *
             * @var string
             *
             *  @example Manager fields
             */
            'manager_work_address' => ['required_if:role,manager', 'string', 'max:255'],
            /**
             * Phone Number
             *
             * @var string
             *
             *  @example Manager fields
             */
            'phone_number' => ['required_if:role,manager', 'string', 'max:20'],
            /**
             * Salary
             *
             * @var int
             *
             *  @example 2500
             */
            'salary' => ['required_if:role,manager', 'numeric', 'min:0'],
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
             * @var int
             *
             * @example 1
             */
            'bank_branch_id' => [
                'required',
                'integer',
                Rule::exists('locations', 'id')
                    ->where(fn ($q) => $q->where('type', 'Branch')->where('branch_services', true)),
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'credit_id.required' => ErrorMessage::CREDIT_REQUIRED->value,
            'term.required' => ErrorMessage::YEARS_REQUIRED->value,
            'term.min' => ErrorMessage::TERM_MIN->value,
            'amount.required' => ErrorMessage::AMOUNT_REQUIRED->value,
            'amount.min' => ErrorMessage::AMOUNT_MIN->value,
            'monthly_payment.required' => ErrorMessage::MONTHLY_PAYMENT_REQUIRED->value,
            'role.required' => ErrorMessage::ROLE_REQUIRED->value,
            'role.in' => ErrorMessage::ROLE_INVALID->value,
            'patent_number.required_if' => ErrorMessage::PATENT_NUMBER_REQUIRED->value,
            'registration_number.required_if' => ErrorMessage::REGISTRATION_NUMBER_REQUIRED->value,
            'work_address.required_if' => ErrorMessage::WORK_ADDRESS_REQUIRED->value,
            'workplace.required_if' => ErrorMessage::WORKPLACE_REQUIRED->value,
            'position.required_if' => ErrorMessage::POSITION_REQUIRED->value,
            'manager_work_address.required_if' => ErrorMessage::MANAGER_WORK_ADDRESS_REQUIRED->value,
            'phone_number.required_if' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'salary.required_if' => ErrorMessage::SALARY_REQUIRED->value,
            'salary.min' => ErrorMessage::SALARY_MIN->value,
            'country.required' => ErrorMessage::COUNTRY_REQUIRED->value,
            'bank_branch_id.required' => ErrorMessage::BANK_BRANCH_REQUIRED->value,
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
                            'amount', ErrorMessage::AMOUNT_EXCEEDS_LIMIT->value
                        );
                    }
                    if ($this->term > $credit->term) {
                        $validator->errors()->add(
                            'term', ErrorMessage::TERM_EXCEEDS_LIMIT->value
                        );
                    }
                }
            }
        });
    }
}
