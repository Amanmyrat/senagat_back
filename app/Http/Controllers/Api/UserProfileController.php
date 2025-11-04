<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Services\UserProfileService;
use Illuminate\Http\JsonResponse;

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

    /**
     * User Create or update
     *
     * @localizationHeader
     */
    public function storeOrUpdate(UserProfileRequest $request)
    {
        $user = auth()->user();

        if ($user->profile) {
            $profile = $this->service->update($user->profile, $request->validated(), $request);
            $code = SuccessMessage::PROFILE_UPDATED->value;
            $status = 200;
        } else {
            $profile = $this->service->create($user, $request->validated(), $request);
            $code = SuccessMessage::PROFILE_CREATED->value;
            $status = 201;
        }

        return new JsonResponse([
            'success' => true,
            'code' => $code,
            'data' => new UserProfileResource($profile),
        ], $status);
    }
}
