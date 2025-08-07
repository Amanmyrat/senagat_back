<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @throws \Exception
     */
    public function register($registerData): ?User
    {
        $existingUser = User::where('phone', $registerData['phone'])->first();

        if ($existingUser) {
            throw new \Exception('This phone number is already registered');
        }

        return  User::create([
            'phone' => $registerData['phone'],
            'password' => Hash::make($registerData['password']),

        ]);

        //  $user?->profile()->create([]);

       // return $user;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request): void
    {
        $request->authenticate();
        $request->user()->update(
            [
                'token' => $request->token,
            ]
        );
    }

}
