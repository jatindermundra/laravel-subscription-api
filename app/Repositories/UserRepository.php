<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $model) {}

    /**
     * Return a paginated list of all users.
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->orderBy('id')->paginate($perPage);
    }

    /**
     * Find a user by ID.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id): User
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Find a user and eager-load their latest payment (with subscription).
     */
    public function findWithDetails(int $id): User
    {
        return $this->model
            ->with([
                'latestPayment.subscription',
            ])
            ->findOrFail($id);
    }

    /**
     * Return full subscription history for a user.
     * Each row includes plan details + payment details.
     */
    public function getSubscriptionHistory(int $userId): Collection
    {
        // Ensure user exists first
        $this->findById($userId);

        return Payment::with('subscription')
            ->where('user_id', $userId)
            ->orderByDesc('payment_date')
            ->get();
    }

    /**
     * Return aggregate dashboard data for a user.
     */
    public function getDashboardData(int $userId): array
    {
        $user = $this->findById($userId);

        $totalPayments   = Payment::where('user_id', $userId)->count();
        $totalAmount     = Payment::where('user_id', $userId)->sum('amount');

        // Active plan: latest completed payment whose subscription has not expired
        $activePlan = Payment::with('subscription')
            ->where('user_id', $userId)
            ->where('payment_status', 'completed')
            ->orderByDesc('payment_date')
            ->get()
            ->first(function (Payment $p) {
                $expiry = $p->payment_date->addDays($p->subscription->duration_days);
                return $expiry->isFuture() || $expiry->isToday();
            });

        $lastPayment = Payment::where('user_id', $userId)
            ->orderByDesc('payment_date')
            ->first();

        // Total distinct subscriptions purchased
        $totalSubscriptions = Payment::where('user_id', $userId)
            ->distinct('subscription_id')
            ->count('subscription_id');

        return [
            'user'                => $user,
            'active_plan'         => $activePlan?->subscription,
            'total_subscriptions' => $totalSubscriptions,
            'total_payments'      => $totalPayments,
            'last_payment_date'   => $lastPayment?->payment_date?->toDateString(),
        ];
    }
}
