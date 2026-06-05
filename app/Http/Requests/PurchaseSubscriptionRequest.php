<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'         => ['required', 'integer', 'exists:users,id'],
            'subscription_id' => ['required', 'integer', 'exists:subscriptions,id'],
            'amount'          => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists'         => 'The specified user does not exist.',
            'subscription_id.exists' => 'The specified subscription plan does not exist.',
            'amount.min'             => 'Payment amount must be a positive value.',
        ];
    }
}
