<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reminder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'expiry_date',
        'alert_days_before',
        'notification_method',
        'category',
        'notes',
        'last_notified_at',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'date',
        'last_notified_at' => 'datetime',
        'is_active' => 'boolean',
        'alert_days_before' => 'integer'
    ];

    /**
     * Get the user that owns the reminder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if reminder is expiring soon
     */
    public function isExpiringSoon()
    {
        $daysUntilExpiry = Carbon::now()->diffInDays($this->expiry_date, false);
        return $daysUntilExpiry <= $this->alert_days_before && $daysUntilExpiry >= 0;
    }

    /**
     * Check if reminder has expired
     */
    public function isExpired()
    {
        return $this->expiry_date->isPast();
    }

    /**
     * Get days until expiry
     */
    public function getDaysUntilExpiryAttribute()
    {
        return Carbon::now()->diffInDays($this->expiry_date, false);
    }

    /**
     * Scope for active reminders
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for expiring soon reminders
     */
    public function scopeExpiringSoon($query)
    {
        return $query->whereRaw('DATEDIFF(expiry_date, CURDATE()) <= alert_days_before')
                     ->whereRaw('DATEDIFF(expiry_date, CURDATE()) >= 0');
    }
} 