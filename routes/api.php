<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReminderApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DashboardApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication API routes
Route::post('/verify-phone', [AuthApiController::class, 'verifyPhone']);
Route::post('/verify-code', [AuthApiController::class, 'verifyCode']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Dashboard data
    Route::get('/dashboard', [DashboardApiController::class, 'index']);
    
    // Reminder API routes
    Route::apiResource('reminders', ReminderApiController::class);
    Route::get('/reminders/expiring-soon', [ReminderApiController::class, 'expiringSoon']);
    
    // Logout
    Route::post('/logout', [AuthApiController::class, 'logout']);
}); 