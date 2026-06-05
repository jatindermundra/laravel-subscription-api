<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'dob',
        'gender',
        'emp_type',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * A user has many payments.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the latest payment for the user.
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
