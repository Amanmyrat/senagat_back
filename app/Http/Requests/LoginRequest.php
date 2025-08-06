<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'string', 'regex:/^[0-9]{8}$/'],
            'password' => ['required', 'string', 'min:4'],
        ];
    }

    public function authenticate()
    {
        $credentials = $this->only('phone', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'phone' => __('Not Registered number'),
            ]);
        }
    }
}
