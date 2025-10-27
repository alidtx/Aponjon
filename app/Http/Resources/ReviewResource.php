<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'task_id'     => $this->task_id,
            'reviewer_id' => $this->reviewer_id,
            'reviewee_id' => $this->reviewee_id,
            'rating'      => $this->rating,
            'comment'     => $this->comment,
            'type'        => $this->type,
            'task'      => new TaskResource($this->whenLoaded('task')),
            'reviewer'  => new UserResource($this->whenLoaded('reviewer')),
            'reviewee'  => new UserResource($this->whenLoaded('reviewee')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
