<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get reminders expiring soon
        $expiringSoon = $user->reminders()
            ->whereRaw('DATEDIFF(expiry_date, CURDATE()) <= alert_days_before')
            ->orderBy('expiry_date', 'asc')
            ->take(5)
            ->get()
            ->map(function ($reminder) {
                $reminder->days_left = Carbon::now()->diffInDays(Carbon::parse($reminder->expiry_date), false);
                $reminder->lead_time = $reminder->alert_days_before;
                return $reminder;
            });
        
        // Get upcoming reminders
        $upcomingReminders = $user->reminders()
            ->whereRaw('DATEDIFF(expiry_date, CURDATE()) > alert_days_before')
            ->orderBy('expiry_date', 'asc')
            ->take(10)
            ->get()
            ->map(function ($reminder) {
                $reminder->days_until_expiry = Carbon::now()->diffInDays(Carbon::parse($reminder->expiry_date), false);
                $reminder->lead_time = $reminder->alert_days_before;
                return $reminder;
            });
        
        // Get stats
        $totalReminders = $user->reminders()->count();
        $expiringThisMonth = $user->reminders()
            ->whereMonth('expiry_date', Carbon::now()->month)
            ->whereYear('expiry_date', Carbon::now()->year)
            ->count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'name' => $user->name ?? 'User',
                    'phone' => $user->phone
                ],
                'expiring_soon' => $expiringSoon,
                'upcoming_reminders' => $upcomingReminders,
                'stats' => [
                    'total_reminders' => $totalReminders,
                    'expiring_this_month' => $expiringThisMonth
                ]
            ]
        ]);
    }
} 