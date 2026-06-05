<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function __construct(protected Subscription $model) {}

    /**
     * Return all subscription plans.
     */
    public function getAll(): Collection
    {
        return $this->model->orderBy('plan_price')->get();
    }

    /**
     * Find a subscription plan by ID.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id): Subscription
    {
        return $this->model->findOrFail($id);
    }
}
