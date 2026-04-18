<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->src ? Storage::url($this->src) : null,
            'type' => $this->type,
            'fileable_type' => $this->fileable_type,
            'fileable_id' => $this->fileable_id,
            'document_type_id' => $this->document_type_id,
        ];
    }
}
