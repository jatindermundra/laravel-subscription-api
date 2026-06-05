<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'user_id'        => $this->user_id,
            'subscription_id'=> $this->subscription_id,
            'amount'         => (float) $this->amount,
            'payment_date'   => $this->payment_date?->toDateString(),
            'payment_status' => $this->payment_status,
            'created_at'     => $this->created_at->toDateTimeString(),
        ];
    }
}
