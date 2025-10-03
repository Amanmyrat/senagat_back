<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditStep2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
             * @var string
             *
             *  @example Manager fields
             */
            'salary' => ['required_if:role,manager', 'numeric', 'min:0'],

        ];
    }
}
