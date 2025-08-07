<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules():array
    {
        return [
            'phone' => ['required', 'string', 'regex:/^[0-9]{8}$/'],
            'password' => ['required', 'string', 'min:4'],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function authenticate()
    {
        $credentials = $this->only('phone', 'password');
        $phone = $this->input('phone');
        $password = $this->input('password');
        $user = User::where('phone', $phone)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'phone' => __('Not Registered number'),
            ]);
        }

        if (! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('Incorrect password'),
            ]);
        }
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'phone' => __('Not Registered number'),
            ]);
        }
    }
}
