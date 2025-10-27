<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'amount'          => $this->amount,
            'platform_fee'    => $this->platform_fee,
            'tasker_earning'  => $this->tasker_earning,
            'payment_status'  => $this->payment_status,
            'payment_method'  => $this->payment_method,
            'transaction_id'  => $this->transaction_id,
            'task' => new TaskResource($this->whenLoaded('task')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
