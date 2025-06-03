<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReminderApiController extends Controller
{
    /**
     * Display a listing of reminders
     */
    public function index(Request $request)
    {
        $query = Auth::user()->reminders();
        
        // Apply filters if provided
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('status')) {
            if ($request->status === 'expiring_soon') {
                $query->whereDate('expiry_date', '<=', Carbon::now()->addDays(7));
            }
        }
        
        $reminders = $query->orderBy('expiry_date', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $reminders->map(function ($reminder) {
                return [
                    'id' => $reminder->id,
                    'name' => $reminder->name,
                    'expiry_date' => $reminder->expiry_date,
                    'days_until_expiry' => Carbon::parse($reminder->expiry_date)->diffInDays(Carbon::now()),
                    'alert_days_before' => $reminder->alert_days_before,
                    'notification_method' => $reminder->notification_method,
                    'category' => $reminder->category,
                    'notes' => $reminder->notes,
                    'is_expiring_soon' => Carbon::parse($reminder->expiry_date)->diffInDays(Carbon::now()) <= $reminder->alert_days_before
                ];
            })
        ]);
    }

    /**
     * Store a newly created reminder
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'expiry_date' => 'required|date|after:today',
            'alert_days_before' => 'required|integer|min:1|max:365',
            'notification_method' => 'required|in:sms,email,both',
            'category' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000'
        ]);

        $reminder = Auth::user()->reminders()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Reminder created successfully!',
            'data' => $reminder
        ], 201);
    }

    /**
     * Display the specified reminder
     */
    public function show(Reminder $reminder)
    {
        $this->authorize('view', $reminder);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $reminder->id,
                'name' => $reminder->name,
                'expiry_date' => $reminder->expiry_date,
                'days_until_expiry' => Carbon::parse($reminder->expiry_date)->diffInDays(Carbon::now()),
                'alert_days_before' => $reminder->alert_days_before,
                'notification_method' => $reminder->notification_method,
                'category' => $reminder->category,
                'notes' => $reminder->notes
            ]
        ]);
    }

    /**
     * Update the specified reminder
     */
    public function update(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'expiry_date' => 'required|date|after:today',
            'alert_days_before' => 'required|integer|min:1|max:365',
            'notification_method' => 'required|in:sms,email,both',
            'category' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000'
        ]);

        $reminder->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Reminder updated successfully!',
            'data' => $reminder
        ]);
    }

    /**
     * Remove the specified reminder
     */
    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        
        $reminder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reminder deleted successfully!'
        ]);
    }
    
    /**
     * Get reminders expiring soon
     */
    public function expiringSoon()
    {
        // Use the model scope to remain compatible with both MySQL and SQLite
        $reminders = Auth::user()->reminders()
            ->expiringSoon()
            ->orderBy('expiry_date', 'asc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $reminders->map(function ($reminder) {
                return [
                    'id' => $reminder->id,
                    'name' => $reminder->name,
                    'expiry_date' => $reminder->expiry_date,
                    'days_left' => Carbon::parse($reminder->expiry_date)->diffInDays(Carbon::now()),
                    'notification_method' => $reminder->notification_method,
                    'category' => $reminder->category
                ];
            })
        ]);
    }
} 