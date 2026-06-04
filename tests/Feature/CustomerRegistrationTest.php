<?php

namespace Tests\Feature;

use App\Models\User;
use App\Mail\CustomerVerificationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_user_can_register(): void
    {
        Mail::fake();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'newuser@example.com',
            'whatsapp_number' => '9876543210',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHas('status', 'Registration successful. A verification email has been sent to your registered email. Please click the link in your email to complete registration.');

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'name' => 'John Doe',
            'whatsapp_number' => '9876543210',
            'email_verified_at' => null,
        ]);

        Mail::assertSent(CustomerVerificationMail::class, function (CustomerVerificationMail $mail) {
            return $mail->hasTo('newuser@example.com');
        });
    }

    public function test_verified_user_cannot_register_again(): void
    {
        $user = User::factory()->create([
            'email' => 'verified@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'verified@example.com',
            'whatsapp_number' => '9876543210',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_unverified_user_can_register_again_and_resends_email(): void
    {
        Mail::fake();

        $user = User::factory()->unverified()->create([
            'name' => 'Old Name',
            'email' => 'unverified@example.com',
            'whatsapp_number' => '1111111111',
            'password' => Hash::make('OldPassword123!'),
        ]);

        $response = $this->post('/register', [
            'name' => 'New Name',
            'email' => 'unverified@example.com',
            'whatsapp_number' => '9876543210',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHas('status', 'This email was already registered but not verified. A new verification link has been sent to your registered email. Please click the link to complete registration.');

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('9876543210', $user->whatsapp_number);
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));

        Mail::assertSent(CustomerVerificationMail::class, function (CustomerVerificationMail $mail) {
            return $mail->hasTo('unverified@example.com');
        });
    }
}
