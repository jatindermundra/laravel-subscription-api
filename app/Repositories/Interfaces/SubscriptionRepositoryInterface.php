<?php

namespace App\Repositories\Interfaces;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

interface SubscriptionRepositoryInterface
{
    /**
     * Return all subscription plans.
     */
    public function getAll(): Collection;

    /**
     * Find a subscription by ID.
     */
    public function findById(int $id): Subscription;
}
