<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use App\Services\AlemTvService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlemTvTopupRequest extends FormRequest
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
            'type'      => ['required', Rule::in(['tv', 'iptv'])],
            'account'   => ['required', function ($attribute, $value, $fail) {
                if (is_int($value) || ctype_digit((string) $value)) {
                    return;
                }
                if (is_string($value) && str_starts_with($value, 'dalem-')) {
                    return;
                }
                $fail("the_account_must_be_an_integer_or_a_string_starting_with_'dalem-'.");
            }],
            'tarif' => ['required', 'string'],
            'period'    => ['required', 'integer', 'min:1'],
            'bank_name' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'type.required'      => ErrorMessage::TYPE_REQUIRED->value,
            'type.in'            => ErrorMessage::TYPE_NOT_SUPPORTED->value,
            'account.required'   => ErrorMessage::ACCOUNT_REQUIRED->value,
            'tarif.required'     => ErrorMessage::TARIF_REQUIRED->value,
            'tarif.string'       => ErrorMessage::TARIF_INVALID->value,
            'period.required'    => ErrorMessage::PERIOD_REQUIRED->value,
            'period.integer'     => ErrorMessage::PERIOD_INVALID->value,
            'period.min'         => ErrorMessage::PERIOD_MIN_VALUE->value,
            'bank_name.required' => ErrorMessage::BANK_NAME_REQUIRED->value,
            'bank_name.string'   => ErrorMessage::BANK_NAME_INVALID->value,

        ];
    }

}

