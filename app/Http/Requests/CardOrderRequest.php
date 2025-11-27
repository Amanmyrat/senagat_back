<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
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

    public function messages(): array
    {
        return [
            'card_type_id.required' => ErrorMessage::CARD_TYPE_REQUIRED->value,
            'card_type_id.exists' => ErrorMessage::CARD_TYPE_INVALID->value,
            'phone_number.required' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'phone_number.regex' => ErrorMessage::PHONE_NUMBER_INVALID->value,
            'bank_branch_id.required' => ErrorMessage::BANK_BRANCH_REQUIRED->value,
            'bank_branch_id.exists' => ErrorMessage::BANK_BRANCH_INVALID->value,

            'internet_service.required' => ErrorMessage::INTERNET_SERVICE_REQUIRED->value,

            'delivery.required' => ErrorMessage::DELIVERY_REQUIRED->value,

            'email.required' => ErrorMessage::EMAIL_REQUIRED->value,
            'email.email' => ErrorMessage::EMAIL_INVALID->value,

            'work_position.string' => ErrorMessage::WORK_POSITION_STRING->value,
            'work_phone.integer' => ErrorMessage::WORK_PHONE_INTEGER->value,
        ];
    }
}
