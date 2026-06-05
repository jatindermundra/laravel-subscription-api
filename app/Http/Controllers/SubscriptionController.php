<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseSubscriptionRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\SubscriptionResource;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionRepositoryInterface $subscriptionRepository,
        protected PaymentRepositoryInterface      $paymentRepository,
    ) {}

    /**
     * GET /api/subscriptions
     * Return all available subscription plans.
     */
    public function index(): JsonResponse
    {
        $plans = $this->subscriptionRepository->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Subscription plans retrieved successfully.',
            'data'    => SubscriptionResource::collection($plans),
        ]);
    }

    /**
     * POST /api/subscriptions/purchase
     * Create a payment entry assigning a subscription to a user.
     */
    public function purchase(PurchaseSubscriptionRequest $request): JsonResponse
    {
        // Verify subscription exists (repository throws 404 if not)
        $this->subscriptionRepository->findById($request->integer('subscription_id'));

        $payment = $this->paymentRepository->create([
            'user_id'         => $request->integer('user_id'),
            'subscription_id' => $request->integer('subscription_id'),
            'amount'          => $request->input('amount'),
            'payment_date'    => Carbon::today()->toDateString(),
            'payment_status'  => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription purchased successfully.',
            'data'    => new PaymentResource($payment),
        ], 201);
    }
}
