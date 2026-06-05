<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function __construct(protected Payment $model) {}

    /**
     * Create a new payment record.
     */
    public function create(array $data): Payment
    {
        return $this->model->create($data);
    }

    /**
     * Find a payment by ID.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id): Payment
    {
        return $this->model->findOrFail($id);
    }
}
