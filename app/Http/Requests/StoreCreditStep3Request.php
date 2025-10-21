<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
}
