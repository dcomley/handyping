<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Reminder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a demo user
        $user = User::create([
            'name' => 'Dan',
            'phone' => '0412345678',
            'email' => 'dan@example.com',
            'password' => bcrypt('password')
        ]);

        // Create demo reminders
        $reminders = [
            [
                'name' => 'White Card Licence',
                'expiry_date' => Carbon::now()->addDays(3),
                'alert_days_before' => 7,
                'notification_method' => 'sms',
                'category' => 'License'
            ],
            [
                'name' => 'Plumbing Public Liability Insurance',
                'expiry_date' => Carbon::now()->addDays(14),
                'alert_days_before' => 30,
                'notification_method' => 'email',
                'category' => 'Insurance'
            ],
            [
                'name' => 'ABN Renewal',
                'expiry_date' => Carbon::now()->addDays(26),
                'alert_days_before' => 30,
                'notification_method' => 'both',
                'category' => 'Business'
            ],
            [
                'name' => 'Electrical License',
                'expiry_date' => Carbon::now()->addDays(45),
                'alert_days_before' => 30,
                'notification_method' => 'sms',
                'category' => 'License'
            ],
            [
                'name' => 'Vehicle Registration',
                'expiry_date' => Carbon::now()->addDays(90),
                'alert_days_before' => 14,
                'notification_method' => 'email',
                'category' => 'Vehicle'
            ],
            [
                'name' => 'Workers Compensation Insurance',
                'expiry_date' => Carbon::now()->addDays(120),
                'alert_days_before' => 60,
                'notification_method' => 'both',
                'category' => 'Insurance'
            ]
        ];

        foreach ($reminders as $reminder) {
            $user->reminders()->create($reminder);
        }

        $this->command->info('Demo user created with phone: 0412345678');
        $this->command->info('6 demo reminders created');
    }
} 