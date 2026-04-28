<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nid_number' => $this->nid_number,
            'district_id' => $this->district_id,
            'zila_id' => $this->zila_id,
            'upozila_id' => $this->upozila_id,
            'rating' => (float) $this->rating,
            'is_online' => (bool) $this->is_online,
            'profile_photo' => $this->user_profile_picture,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}