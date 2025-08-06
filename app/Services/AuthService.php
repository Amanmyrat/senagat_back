<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    /**
     * @throws Exception
     */
    public function register($registerData): ?User
    {
        $existingUser = User::where('phone', $registerData['phone'])->first();

        if ($existingUser) {
            throw new \Exception('This phone number is already registered');
        }

        $user = User::create([
            'phone' => $registerData['phone'],
            'password' => Hash::make($registerData['password']),

        ]);

        //  $user?->profile()->create([]);

        return $user;
    }

    /**
     * @throws ValidationException
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




   










// public function setPassword(string $phone, string $password)
//     {
//         $user = User::where('phone', $phone)->first();

//         if (!$user || !$user->otp_verified_at) {
//             return ['error' => 'OTP not verified or user not found', 'code' => 401];
//         }

//         if ($user->password) {
//             return ['error' => 'Password is already set', 'code' => 400];
//         }

//         $user->password = Hash::make($password);
//         $user->save();

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return ['user' => $user, 'token' => $token];
//     }
