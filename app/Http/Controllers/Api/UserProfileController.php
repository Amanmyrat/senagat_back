<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Services\UserProfileService;

class UserProfileController extends Controller
{
    /**
     * Create user profile
     *
     * @localizationHeader
     */
    protected UserProfileService $service;

    public function __construct(UserProfileService $service)
    {
        $this->service = $service;
    }

    public function storeOrUpdate(UserProfileRequest $request)
    {
        $user = auth()->user();

        if ($user->profile) {

            $profile = $this->service->update($user->profile, $request->validated(), $request);
        } else {

            $profile = $this->service->create($user, $request->validated(), $request);
        }

        return new UserProfileResource($profile);
    }
}
