<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInformationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'phone' => $this->resource->phone,
            'profile' => $this->resource->profile
                ? collect((new UserProfileResource($this->resource->profile))->toArray($request))
                    ->except('id')
                    ->merge(['approved' => $this->resource->profile->approved])
                : null,
        ];
    }
}
