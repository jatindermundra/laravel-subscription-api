<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Return paginated list of all users.
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find a user by ID (throws ModelNotFoundException if not found).
     */
    public function findById(int $id): \App\Models\User;

    /**
     * Find a user with latest payment and latest subscription loaded.
     */
    public function findWithDetails(int $id): \App\Models\User;

    /**
     * Return subscription + payment history rows for a given user.
     */
    public function getSubscriptionHistory(int $userId): \Illuminate\Support\Collection;

    /**
     * Return dashboard aggregate data for a user.
     */
    public function getDashboardData(int $userId): array;
}
