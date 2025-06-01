<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    /**
     * Display a listing of reminders
     */
    public function index()
    {
        $reminders = Auth::user()->reminders()
            ->orderBy('expiry_date', 'asc')
            ->get();
            
        return view('reminders.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new reminder
     */
    public function create()
    {
        return view('reminders.create');
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

        return redirect()->route('dashboard')
            ->with('success', 'Reminder created successfully!');
    }

    /**
     * Show the form for editing the specified reminder
     */
    public function edit(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        return view('reminders.edit', compact('reminder'));
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

        return redirect()->route('dashboard')
            ->with('success', 'Reminder updated successfully!');
    }

    /**
     * Remove the specified reminder
     */
    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        
        $reminder->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Reminder deleted successfully!');
    }
} 