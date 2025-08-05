<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\OtpHelper;
use App\Models\Otp;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function loginRequestOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string|regex:/^[0-9]{8}$/']);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        Otp::generateForUser($user->id, $user->phone);

        return response()->json([
            'status' => true,
            'message' => 'OTP sent',

        ]);
    }
    public function loginVerifyOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string', 'otp' => 'required|string|size:5']);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        $otp = $otp = OtpHelper::getValidOtp($user, $request->otp);

        if (!$otp) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired OTP'], 401);
        }

        $otp->markUsed();

        $user->otp_verified_at = now();
        $user->save();

        return response()->json(['status' => true, 'message' => 'OTP verified']);
    }
    public function loginWithPassword(Request $request)
    {
        $request->validate(['phone' => 'required|string', 'password' => 'required|string|min:4']);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        if (!$user->otp_verified_at) {
            return response()->json(['status' => false, 'message' => 'OTP not verified'], 401);
        }

        if (!$user->password || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Invalid password'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login succesfull',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout()
    {

        request()->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => true,
            "message" => "User loged out"


        ]);
    }
}
