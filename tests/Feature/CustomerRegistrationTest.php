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

    public function test_email_verification_redirects_to_plan_preview(): void
    {
        $user = User::factory()->unverified()->create([
            'role_id' => 0,
        ]);

        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify.custom',
            now()->addMinutes(1440),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect(route('customer.plan-preview'));
        $this->assertTrue($user->refresh()->hasVerifiedEmail());
    }

    public function test_customer_can_purchase_plan_with_incomplete_profile(): void
    {
        \Illuminate\Support\Facades\Http::fake([
            '*/orders' => \Illuminate\Support\Facades\Http::response([
                'payment_session_id' => 'mock_session_id_123'
            ], 200)
        ]);

        $user = User::factory()->create([
            'role_id' => 0,
            'profile_completed' => 0,
            'verification_status' => 'pending',
            'status' => 'pending',
        ]);

        $plan = \App\Models\Plan::create([
            'name' => 'Premium Pack',
            'slug' => 'premium-pack',
            'premium_amount' => 500.00,
            'tenure_type' => 'months',
            'tenure_value' => 6,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->postJson(route('customer.plan.purchase'), [
            'plan_id' => $plan->id,
            'payment_type' => 'regular',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['payment_session_id', 'order_id']);
        $this->assertEquals('mock_session_id_123', $response->json('payment_session_id'));
    }

    public function test_membership_purchase_sends_success_email(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role_id' => 0,
            'profile_completed' => 0,
            'verification_status' => 'pending',
            'status' => 'pending',
        ]);

        $plan = \App\Models\Plan::create([
            'name' => 'Premium Pack',
            'slug' => 'premium-pack',
            'premium_amount' => 500.00,
            'tenure_type' => 'months',
            'tenure_value' => 6,
            'status' => 'active',
        ]);

        // Generate payment order
        $paymentOrder = \App\Models\PaymentOrder::create([
            'order_id' => 'MEM_MOCK_123',
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'plan_unique_id' => 'premium-pack_' . $user->id . '_123456',
            'amount' => 500.00,
            'status' => 'pending',
        ]);

        // Call activatePaymentOrder
        $planController = resolve(\App\Http\Controllers\PlanController::class);
        $planController->activatePaymentOrder($paymentOrder, [
            'payment_group' => 'upi',
            'cf_payment_id' => 'cf_12345678',
        ], [
            'order_id' => 'MEM_MOCK_123',
            'order_status' => 'PAID',
        ]);

        Mail::assertSent(\App\Mail\MembershipSuccessMail::class, function (\App\Mail\MembershipSuccessMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
