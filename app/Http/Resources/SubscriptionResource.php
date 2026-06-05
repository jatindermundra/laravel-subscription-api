<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'plan_name'     => $this->plan_name,
            'plan_price'    => (float) $this->plan_price,
            'duration_days' => $this->duration_days,
            'description'   => $this->description,
            'created_at'    => $this->created_at->toDateTimeString(),
        ];
    }
}
