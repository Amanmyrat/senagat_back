<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
             * Work position
             *
             * @var string
             *
             * @example Manager
             */
            'work_position' => ['nullable', 'string'],
            /**
             * Work phone
             *
             * @var int
             *
             * @example 12556677
             */
            'work_phone' => ['nullable', 'integer'],
            /**
             * Internet service
             *
             * @var bool
             *
             * @example false
             */
            'internet_service' => ['required', 'boolean'],
            /**
             * Order Delivery
             *
             * @var bool
             *
             * @example true
             */
            'delivery' => ['required', 'boolean'],
            /**
             * Email
             *
             * @var string
             *
             * @example example@gmail.com
             */
            'email' => ['required', 'email'],

        ];
    }
}
