<?php

namespace App\Http\Resources\Lead;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadCustomerTimelineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'customer_id' => $this->customer_id,
            'action'      => $this->action,
            'remarks'     => $this->remarks,
            'created_by'  => $this->created_by,
            'created_at'  => $this->created_at instanceof \Carbon\Carbon
                ? $this->created_at->toIso8601String()
                : $this->created_at,
            'creator'     => new LeadUserResource($this->whenLoaded('creator')),
        ];
    }
}
