<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'description'       => $this->description,
            'base_price'        => $this->base_price,
            'duration_unit'     => $this->duration_unit,
            'estimated_duration'=> $this->estimated_duration,
            'requirements'      => $this->requirements,
            'is_active'         => $this->is_active,
            'category' => new CategoryResource($this->whenLoaded('categories')),
            'task'     => new TaskResource($this->whenLoaded('task')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
