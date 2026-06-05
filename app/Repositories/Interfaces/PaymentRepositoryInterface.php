<?php

namespace App\Repositories\Interfaces;

use App\Models\Payment;

interface PaymentRepositoryInterface
{
    /**
     * Create a new payment record.
     */
    public function create(array $data): Payment;

    /**
     * Find a payment by ID.
     */
    public function findById(int $id): Payment;
}
