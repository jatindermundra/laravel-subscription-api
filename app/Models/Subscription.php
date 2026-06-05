<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name',
        'plan_price',
        'duration_days',
        'description',
    ];

    protected $casts = [
        'plan_price' => 'decimal:2',
        'duration_days' => 'integer',
    ];

    /**
     * A subscription plan can have many payments.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
