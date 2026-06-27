<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InactiveUserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'active@example.com',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'role_id' => 0, // Customer
        ]);

        $response = $this->post('/login', [
            'email' => 'active@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('customer.plan-preview'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => Hash::make('password123'),
            'status' => 'inactive',
            'role_id' => 0, // Customer
        ]);

        $response = $this->post('/login', [
            'email' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'you are inactive contact to adminstrator',
        ]);

        $this->assertGuest();
    }
}
