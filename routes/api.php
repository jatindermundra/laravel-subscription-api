<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Users
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']); 
	Route::post('/', [UserController::class, 'store']);  // POST /api/users	
	// GET  /api/users
    Route::get('/{id}', [UserController::class, 'show']);                            // GET  /api/users/{id}
    Route::get('/{id}/subscriptions', [UserController::class, 'subscriptionHistory']); // GET  /api/users/{id}/subscriptions
});

// Subscriptions
Route::prefix('subscriptions')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index']);           // GET  /api/subscriptions
    Route::post('/purchase', [SubscriptionController::class, 'purchase']); // POST /api/subscriptions/purchase
});

// Dashboard
Route::get('/dashboard/{user_id}', [UserController::class, 'dashboard']); // GET  /api/dashboard/{user_id}
