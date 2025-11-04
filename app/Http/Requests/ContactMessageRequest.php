<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'message' => 'required|string',
        ];

    }

    public function messages(): array
    {
        return [
            'name.required' => ErrorMessage::NAME_REQUIRED->value,
            'email.required' => ErrorMessage::EMAIL_REQUIRED->value,
            'email.email' => ErrorMessage::EMAIL_INVALID->value,
            'phone_number.required' => ErrorMessage::PHONE_NUMBER_REQUIRED->value,
            'message.required' => ErrorMessage::MESSAGE_REQUIRED->value,
        ];
    }
}
