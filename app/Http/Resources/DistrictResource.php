<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

     return [
            'id'=>$this->id,
            'email'=>$this->name,
            'phone'=>$this->slug,
            'zilas'=>new ZilaResource($this->whenLoaded('zilas')),
            'tasks'=>new TaskResource($this->whenLoaded('tasks')),
            'users'=>new UserResource($this->whenLoaded('users')),
            'created_at'=>$this->created_at?->toDateTimeString(),  
            'updated_at'=>$this->updated_at?->toDateTimeString(),  
        ];
}

}
