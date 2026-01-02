<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'task_number'          => $this->task_number,
            'title'                => $this->title,
            'description'          => $this->description,
            'location_address'     => $this->location_address,
            'location_coordinates' => $this->location_coordinates,
            'scheduled_for'        => $this->scheduled_for,
            'budget'               => $this->budget,
            'status'               => $this->status,
            'customer_notes'       => $this->customer_notes,
            'customer' => new UserResource($this->whenLoaded('customers')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tasker'   => new UserResource($this->whenLoaded('taskers')),
            'bid'   => BidResource::collection($this->whenLoaded('bids')), 
            'service'  => new ServiceResource($this->whenLoaded('services')),
            'district' => new DistrictResource($this->whenLoaded('districts')),
            'zila'     => new ZilaResource($this->whenLoaded('zilas')),
            'upozila'  => new UpozilaResource($this->whenLoaded('upozilas')),
            'orders'  => OrderResource::collection($this->whenLoaded('order')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
