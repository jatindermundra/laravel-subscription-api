<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserSubscriptionHistoryResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * GET /api/users
     * Return a paginated list of all users.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $users   = $this->userRepository->getAllPaginated($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'data'    => UserResource::collection($users->items()),
            'meta'    => [
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
                'last_page'    => $users->lastPage(),
            ],
        ]);
    }
	
	
	/**
     * GET /api/users
     * Save user details 
     */
	public function store(StoreUserRequest $request): JsonResponse
{
    $user = User::create($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'User created successfully.',
        'data'    => new UserResource($user),
    ], 201);
}

    /**
     * GET /api/users/{id}
     * Return user details with latest subscription and payment.
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->findWithDetails($id);

        $latestPayment      = $user->latestPayment;
        $latestSubscription = $latestPayment?->subscription;

        return response()->json([
            'success' => true,
            'message' => 'User details retrieved successfully.',
            'data'    => [
                'user'                  => new UserResource($user),
                'latest_subscription'   => $latestSubscription
                    ? new SubscriptionResource($latestSubscription)
                    : null,
                'latest_payment'        => $latestPayment
                    ? new PaymentResource($latestPayment)
                    : null,
            ],
        ]);
    }

    /**
     * GET /api/users/{id}/subscriptions
     * Return all subscription history for a user.
     */
    public function subscriptionHistory(int $id): JsonResponse
    {
        $history = $this->userRepository->getSubscriptionHistory($id);

        return response()->json([
            'success' => true,
            'message' => 'Subscription history retrieved successfully.',
            'data'    => UserSubscriptionHistoryResource::collection($history),
        ]);
    }

    /**
     * GET /api/dashboard/{user_id}
     * Return dashboard aggregate data for a user.
     */
    public function dashboard(int $userId): JsonResponse
    {
        $data = $this->userRepository->getDashboardData($userId);

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data retrieved successfully.',
            'data'    => [
                'user_details'        => new UserResource($data['user']),
                'active_plan'         => $data['active_plan']
                    ? new SubscriptionResource($data['active_plan'])
                    : null,
                'total_subscriptions' => $data['total_subscriptions'],
                'total_payments'      => $data['total_payments'],
                'last_payment_date'   => $data['last_payment_date'],
            ],
        ]);
    }
}
