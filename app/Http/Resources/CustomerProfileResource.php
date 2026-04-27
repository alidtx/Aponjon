<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProfileResource extends JsonResource
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
            'nid_number' => $this->nid_number,
            'district_id' => $this->district_id,
            'zila_id' => $this->zila_id,
            'upozila_id' => $this->upozila_id,
            'rating' => (float) $this->rating,
            'is_online' => (bool) $this->is_online,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}