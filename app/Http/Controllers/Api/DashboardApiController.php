<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardApiController extends Controller
{
    /**
     * Get dashboard data
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get reminders expiring soon
        // Use SQLite-compatible query
        $today = Carbon::now()->toDateString();
        $expiringSoon = $user->reminders()
            ->whereRaw("julianday(expiry_date) - julianday(?) <= alert_days_before", [$today])
            ->whereRaw("julianday(expiry_date) - julianday(?) >= 0", [$today])
            ->orderBy('expiry_date', 'asc')
            ->take(5)
            ->get()
            ->map(function ($reminder) {
                return [
                    'id' => $reminder->id,
                    'name' => $reminder->name,
                    'expiry_date' => $reminder->expiry_date,
                    'days_left' => Carbon::parse($reminder->expiry_date)->diffInDays(Carbon::now()),
                    'category' => $reminder->category,
                    'notification_method' => $reminder->notification_method
                ];
            });
        
        // Get upcoming reminders
        $upcomingReminders = $user->reminders()
            ->whereRaw("julianday(expiry_date) - julianday(?) > alert_days_before", [$today])
            ->orderBy('expiry_date', 'asc')
            ->take(10)
            ->get()
            ->map(function ($reminder) {
                return [
                    'id' => $reminder->id,
                    'name' => $reminder->name,
                    'expiry_date' => $reminder->expiry_date,
                    'days_until_expiry' => Carbon::parse($reminder->expiry_date)->diffInDays(Carbon::now()),
                    'category' => $reminder->category
                ];
            });
        
        // Get stats
        $stats = [
            'total_reminders' => $user->reminders()->count(),
            'expiring_this_month' => $user->reminders()
                ->whereMonth('expiry_date', Carbon::now()->month)
                ->whereYear('expiry_date', Carbon::now()->year)
                ->count(),
            'expiring_this_week' => $user->reminders()
                ->whereBetween('expiry_date', [Carbon::now(), Carbon::now()->addDays(7)])
                ->count(),
            'expired' => $user->reminders()
                ->whereDate('expiry_date', '<', Carbon::now())
                ->count()
        ];
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone
                ],
                'expiring_soon' => $expiringSoon,
                'upcoming_reminders' => $upcomingReminders,
                'stats' => $stats
            ]
        ]);
    }
} 