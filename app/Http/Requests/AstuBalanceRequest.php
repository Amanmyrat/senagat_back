<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use App\Enum\TopupTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AstuBalanceRequest extends FormRequest
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
             * Phone number.
             *
             * @var string
             *
             * @example 12932701
             */
            'phone' => ['required', 'string'],

            /**
             * Service type.
             *
             * Available values:
             * - phone
             * - iptv
             * - inet
             *
             * @var string
             *
             * @example phone
             */
            'type' => ['required',  Rule::in(TopupTypeEnum::values())],
        ];
    }


    public function messages(): array
    {
        return [
            'phone.required' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'phone.regex' => ErrorMessage::PHONE_NUMBER_INVALID->value,
            'type.required' => ErrorMessage::TYPE_REQUIRED->value,
            'type.string'   => ErrorMessage::TYPE_INVALID->value,
            'type.in'       => ErrorMessage::TYPE_NOT_SUPPORTED->value,
        ];
    }
}
