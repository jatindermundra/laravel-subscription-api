<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Represents a single row of a user's subscription history.
 * The underlying resource is a Payment model with subscription loaded.
 */
class UserSubscriptionHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'payment_id'     => $this->id,
            'plan_name'      => $this->subscription?->plan_name,
            'plan_price'     => (float) ($this->subscription?->plan_price ?? 0),
            'payment_amount' => (float) $this->amount,
            'payment_date'   => $this->payment_date?->toDateString(),
            'payment_status' => $this->payment_status,
        ];
    }
}
