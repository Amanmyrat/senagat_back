<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function setPassword(string $phone, string $password)
    {
        $user = User::where('phone', $phone)->first();

        if (!$user || !$user->otp_verified_at) {
            return ['error' => 'OTP not verified or user not found', 'code' => 401];
        }

        if ($user->password) {
            return ['error' => 'Password is already set', 'code' => 400];
        }

        $user->password = Hash::make($password);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
