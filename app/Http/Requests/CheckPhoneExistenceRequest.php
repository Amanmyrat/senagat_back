<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckPhoneExistenceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'regex:/^[0-9]{8}$/'],

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
