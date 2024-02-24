<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_login_failed(): void
    {
        $response = $this->json('POST', route('api.login'), [
            'email' => 'unknown@gmail.com',
            'password' => 'password',
        ]);
        $response->assertStatus(400);
    }

    public function test_user_login_success(): void
    {
        $user = User::factory()->create();
        $response = $this->json('POST', route('api.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }

    public function test_user_register_failed_email_already_taken(): void
    {
        $user = User::factory()->create();
        $response = $this->json('POST', route('api.register'), [
            'name' => 'user test',
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(400);
    }

    public function test_user_register_success(): void
    {
        $response = $this->json('POST', route('api.register'), [
            'name' => 'user',
            'email' => 'test@examplea.com',
            'password' => 'password',
        ]);
        $response->assertStatus(201);
    }

    public function test_user_logout_success(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        $response = $this->json('POST', route('api.logout'), headers: $headers);
        $response->assertStatus(200);
    }

    public function test_user_logout_fail_without_token(): void
    {
        User::factory()->create();
        $headers = [
            'Accept' => 'application/json',
        ];
        $response = $this->json('POST', route('api.logout'), headers: $headers);
        $response->assertStatus(401);
    }
}
