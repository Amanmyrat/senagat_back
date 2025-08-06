<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        // Eğer kayıt işlemine herkes erişebilecekse true
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'string', 'regex:/^[0-9]{8}$/', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:4',],
        ];
    }
}
