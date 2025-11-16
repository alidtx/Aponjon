<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email'=>$this->email,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'role'=>$this->role,
            'avatar'=>$this->avatar,
            'is_verified'=>true,
            'location'=>$this->location,
            'districts'=>new DistrictResource($this->whenLoaded('districts')),
            'zilas'=> new ZilaResource($this->whenLoaded('zillas')),
            'upozilas'=>new UpozilaResource($this->whenLoaded('upozilas')),
            'crated_at'=>$this->crated_at?->toDateTimeString(),
            'updated_at'=>$this->updated_at?->toDateTimeString(),
        ];
    }
}
