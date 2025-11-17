<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'task_id'         => $this->task_id,
            'tasker_id'       => $this->tasker_id,
            'amount'          => $this->amount,
            'proposal'        => $this->proposal,
            'estimated_hours' => $this->estimated_hours,
            'status'          => $this->status,
            'task'   => new TaskResource($this->whenLoaded('tasks')),
            'tasker' => new UserResource($this->whenLoaded('tasker')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
