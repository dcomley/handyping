<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Reminder;
use Carbon\Carbon;

class ReminderScopeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_expiring_soon_reminders()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'phone' => '0411111111',
            'password' => 'secret',
        ]);

        $expiring = $user->reminders()->create([
            'name' => 'Expiring',
            'expiry_date' => Carbon::now()->addDay(),
            'alert_days_before' => 7,
            'notification_method' => 'sms',
        ]);

        $user->reminders()->create([
            'name' => 'Later',
            'expiry_date' => Carbon::now()->addDays(20),
            'alert_days_before' => 7,
            'notification_method' => 'sms',
        ]);

        $results = Reminder::query()->expiringSoon()->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->first()->is($expiring));
    }

    /** @test */
    public function it_returns_upcoming_reminders()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'test2@example.com',
            'phone' => '0422222222',
            'password' => 'secret',
        ]);

        $upcoming = $user->reminders()->create([
            'name' => 'Upcoming',
            'expiry_date' => Carbon::now()->addDays(20),
            'alert_days_before' => 7,
            'notification_method' => 'sms',
        ]);

        $user->reminders()->create([
            'name' => 'Soon',
            'expiry_date' => Carbon::now()->addDay(),
            'alert_days_before' => 7,
            'notification_method' => 'sms',
        ]);

        $results = Reminder::query()->upcoming()->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->first()->is($upcoming));
    }
}
