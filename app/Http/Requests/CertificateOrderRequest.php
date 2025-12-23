<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
             * Bank Branch
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

    public function messages(): array
    {
        return [
            'certificate_type_id.required' => ErrorMessage::CERTIFICATE_TYPE_REQUIRED->value,
            'certificate_type_id.exists' => ErrorMessage::CERTIFICATE_TYPE_INVALID->value,
            'bank_branch_id.required' => ErrorMessage::BANK_BRANCH_REQUIRED->value,
            'bank_branch_id.exists' => ErrorMessage::BANK_BRANCH_INVALID->value,
            'home_address.required' => ErrorMessage::HOME_ADDRESS_REQUIRED->value,
        ];
    }
}
