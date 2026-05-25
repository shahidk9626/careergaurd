<?php

namespace Tests\Feature;

use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Forgot Password');
    }

    public function test_password_reset_link_can_be_requested(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'customer@example.com',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'customer@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        Mail::assertSent(ResetPasswordMail::class, function (ResetPasswordMail $mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->user->id === $user->id;
        });
    }

    public function test_password_reset_fails_if_email_does_not_exist(): void
    {
        $response = $this->post('/forgot-password', [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_reset_password_screen_can_be_rendered_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
        ]);

        $token = Password::broker()->createToken($user);

        $response = $this->get('/reset-password/' . $token . '?email=customer@example.com');

        $response->assertStatus(200);
        $response->assertSee('Reset Password');
    }

    public function test_reset_password_screen_redirects_if_token_is_invalid(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
        ]);

        $response = $this->get('/reset-password/invalid-token?email=customer@example.com');

        $response->assertRedirect('/forgot-password');
        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('OldPassword123!'),
        ]);

        $token = Password::broker()->createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'customer@example.com',
            'password' => 'NewSecurePassword123!',
            'password_confirmation' => 'NewSecurePassword123!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success');

        $user->refresh();

        $this->assertTrue(Hash::check('NewSecurePassword123!', $user->password));
        $this->assertFalse(Password::broker()->tokenExists($user, $token));
    }
}
