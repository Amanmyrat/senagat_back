<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\UserProfileResource;

class UserProfileController extends Controller
{
    /**
     * Create user profile
     *
     * @localizationHeader
     */
    public function store(UserProfileRequest $request)
    {
        $user = auth()->user();

        if ($user->profile) {
            return response()->json([
                'message' => 'Profile already exists for this user.',
            ], 400);
        }

        $profile = $user->profile()->create($request->validated());

        return new UserProfileResource($profile);
    }
}
