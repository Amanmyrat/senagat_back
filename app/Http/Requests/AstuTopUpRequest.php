<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use App\Enum\TopupTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AstuTopUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * Bank name .
             *
             * @var string
             *
             * @example rysgal
             */
            'bank_name' => ['required', 'string'],
            /**
             * Account .
             *
             * @var string
             *
             * @example 12932702
             */
            'phone' => ['required', 'string'],
            /**
             * Type .
             *
             * @var string
             *
             * @example iptv
             */
            'type' => ['required',  Rule::in(TopupTypeEnum::values())],

            /**
             * Amount in manats.
             *
             * @var int
             *
             * @example 1
             */
            'amount' => ['required', 'numeric', 'min:1'],

        ];
    }

    public function messages(): array
    {
        return [
            'bank_name.in' => ErrorMessage::BANK_NAME_INVALID->value,
            'phone.required' => ErrorMessage::PHONE_REQUIRED->value,
            'phone.string' => ErrorMessage::PHONE_NUMBER_INVALID->value,
            'type.required' => ErrorMessage::TYPE_REQUIRED->value,
            'type.in' => ErrorMessage::TYPE_INVALID->value,
            'amount.required' => ErrorMessage::AMOUNT_REQUIRED->value,
            'amount.numeric' => ErrorMessage::AMOUNT_INVALID->value,
            'amount.min' => ErrorMessage::AMOUNT_MIN->value,
        ];
    }
}
