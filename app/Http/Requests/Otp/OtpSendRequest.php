<?php

namespace App\Http\Requests\Otp;

use Illuminate\Foundation\Http\FormRequest;

class OtpSendRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules():array
    {
        return [
            'phone' => ['required', 'string', 'regex:/^[0-9]{8}$/'],
        ];
    }
}
