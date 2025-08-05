<?php

namespace App\Http\Controllers;

use App\Helpers\OtpHelper;
use App\Models\Otp;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function registerRequestOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{8}$/'
        ]);

        Otp::generateForPhone($request->phone);

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',

        ]);
    }
    public function registerVerifyOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string', 'otp' => 'required|string|size:5']);

        $user = User::where('phone', $request->phone)->first();

        $otp = OtpHelper::getValidOtpByPhone($request->phone, $request->otp);


        if (!$otp) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired OTP'], 401);
        }
        $otp->markUsed();
        if ($user) {
            $user->otp_verified_at = now();
            $user->save();
        }

        return response()->json(['status' => true, 'message' => 'OTP verified']);
    }
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function registerSetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string|min:4'
        ]);

        $user = User::where('phone', $request->phone)->first();
        $result = $this->authService->setPassword($request->phone, $request->password);
        if ($user && !$user->otp_verified_at) {
            return response()->json([
                'status' => false,
                'message' => 'OTP not verified yet'
            ], 401);
        }
        if (!$user) {
            $user = User::create([
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'name' => 'User ' . $request->phone,
                'otp_verified_at' => now(),
            ]);
        } else {

            $user->password = bcrypt($request->password);
            $user->save();
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Registration complete',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
