<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskerProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'experience' => $this->experience,
            'nid_number' => $this->nid_number,
            'district_id' => $this->district_id,
            'zila_id' => $this->zila_id,
            'upozila_id' => $this->upozila_id,
            'bio' => $this->bio,
            'designation' => $this->designation,
            'skills' => $this->skill ?? [],
            'hourly_rate' => $this->hourly_rate,
            'verification_status' => $this->verification_status,
            'rating' => (float) $this->rating,
            'completed_task' => $this->completed_task,
            'is_online' => (bool) $this->is_online,
            'profile_photo' => $this->user_profile_picture,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}