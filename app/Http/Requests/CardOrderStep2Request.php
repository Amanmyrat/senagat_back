<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardOrderStep2Request extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            /**
             * Order Id
             *
             * @var int
             *
             * @example 1
             */
            'order_id'         => ['required', 'integer', 'exists:card_orders,id'],
            /**
             * Order Current address
             *
             * @var string
             *
             * @example 1
             */
            'current_address'  => ['required', 'string'],
            /**
             * Work position
             * @var string
             *
             * @example Manager
             */
            'work_position'    => ['nullable', 'string'],
            /**
             * Work phone
             *
             * @var int
             *
             * @example 12556677
             */
            'work_phone'       => ['nullable', 'integer',],
            /**
             * Internet service
             *
             * @var boolean
             *
             * @example false
             */
            'internet_service' => ['required', 'boolean'],
            /**
             * Order Delivery
             *
             * @var boolean
             *
             * @example true
             */
            'delivery'         => ['required', 'boolean'],
            /**
             * Email
             *
             * @var string
             *
             * @example example@gmail.com
             */
            'email'            => ['required', 'email'],
        ];
    }
}
