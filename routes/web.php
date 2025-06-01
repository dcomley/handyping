<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\StripeWebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication routes (phone-based)
Route::post('/verify-phone', [AuthController::class, 'verifyPhone'])->name('auth.verify-phone');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('auth.verify-code');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Login route - serves the Vue app
Route::get('/login', function () {
    return view('app');
})->name('login');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Reminder routes
    Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders.index');
    Route::get('/reminders/create', [ReminderController::class, 'create'])->name('reminders.create');
    Route::post('/reminders', [ReminderController::class, 'store'])->name('reminders.store');
    Route::get('/reminders/{reminder}/edit', [ReminderController::class, 'edit'])->name('reminders.edit');
    Route::put('/reminders/{reminder}', [ReminderController::class, 'update'])->name('reminders.update');
    Route::delete('/reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
    
    // Subscription routes
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription');
    Route::post('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
    Route::get('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});

// Stripe webhook (outside auth middleware)
Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])->name('cashier.webhook');

// Vue app catch-all route
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*'); 