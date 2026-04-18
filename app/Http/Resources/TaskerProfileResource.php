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
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'phone' => $this->user->phone,
                ];
            }),
            'bio' => $this->bio,
            'designation' => $this->designation,
            'skills' => $this->skill ?? [],
            'hourly_rate' => $this->hourly_rate,
            'verification_status' => $this->verification_status,
            'media' => MediaResource::collection($this->media),
            'rating' => (float) $this->rating,
            'completed_task' => $this->completed_task,
            'is_online' => (bool) $this->is_online,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}