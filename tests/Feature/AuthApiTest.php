<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    public function test_verify_phone_returns_success()
    {
        $response = $this->postJson('/api/verify-phone', [
            'phone' => '0412345678',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ]);
    }

    public function test_verify_code_creates_token()
    {
        Cache::put('phone_verification_0412345678', '123456', now()->addMinutes(10));

        $response = $this->postJson('/api/verify-code', [
            'phone' => '0412345678',
            'code' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ])
                 ->assertJsonStructure([
                     'token',
                     'user',
                 ]);
    }
}
