<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plan;
use App\Models\PurchasedPlan;
use App\Models\Transaction;
use App\Models\Permission;
use App\Models\Module;
use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepaymentHistoryPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_download_pdf()
    {
        $response = $this->get('/customer/purchased-plan/MEM123/pdf');
        $response->assertRedirect('/login');
    }

    public function test_customer_can_download_their_own_pdf()
    {
        $customer = User::factory()->create(['role_id' => 0]);
        $plan = Plan::create([
            'name' => 'Gold Plan',
            'slug' => 'gold-plan',
            'premium_amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'claim_duration_days' => 30,
            'compensation_amount' => 5000,
            'status' => 'active'
        ]);

        $purchasedPlan = PurchasedPlan::create([
            'user_id' => $customer->id,
            'plan_id' => $plan->id,
            'plan_unique_id' => 'MEM123',
            'plan_name' => 'Gold Plan',
            'amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active'
        ]);

        $transaction = Transaction::create([
            'user_id' => $customer->id,
            'plan_id' => $plan->id,
            'plan_unique_id' => 'MEM123',
            'amount' => 1000,
            'payment_status' => 'success',
            'payment_method' => 'upi',
            'transaction_reference' => 'TXN123456',
        ]);

        $response = $this->actingAs($customer)->get('/customer/purchased-plan/MEM123/pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename=CareerGuard_Repayment_History_MEM123.pdf');
    }

    public function test_customer_cannot_download_other_customer_pdf()
    {
        $customer1 = User::factory()->create(['role_id' => 0]);
        $customer2 = User::factory()->create(['role_id' => 0]);
        
        $plan = Plan::create([
            'name' => 'Gold Plan',
            'slug' => 'gold-plan',
            'premium_amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'claim_duration_days' => 30,
            'compensation_amount' => 5000,
            'status' => 'active'
        ]);

        $purchasedPlan = PurchasedPlan::create([
            'user_id' => $customer1->id,
            'plan_id' => $plan->id,
            'plan_unique_id' => 'MEM123',
            'plan_name' => 'Gold Plan',
            'amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active'
        ]);

        $response = $this->actingAs($customer2)->get('/customer/purchased-plan/MEM123/pdf');
        $response->assertStatus(403);
    }

    public function test_super_admin_can_download_any_pdf()
    {
        $superAdmin = User::factory()->create(['id' => 1, 'role_id' => 1]); // ID = 1 triggers super admin bypass in PermissionHelper
        $customer = User::factory()->create(['role_id' => 0]);
        
        $plan = Plan::create([
            'name' => 'Gold Plan',
            'slug' => 'gold-plan',
            'premium_amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'claim_duration_days' => 30,
            'compensation_amount' => 5000,
            'status' => 'active'
        ]);

        $purchasedPlan = PurchasedPlan::create([
            'user_id' => $customer->id,
            'plan_id' => $plan->id,
            'plan_unique_id' => 'MEM123',
            'plan_name' => 'Gold Plan',
            'amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active'
        ]);

        $response = $this->actingAs($superAdmin)->get('/admin/purchased-plan/MEM123/pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_staff_with_permission_can_download_pdf()
    {
        $customer = User::factory()->create(['role_id' => 0]);
        $staff = User::factory()->create(['role_id' => 2]); // non-superadmin staff
        
        $module = Module::create([
            'name' => 'Purchased Plans',
            'slug' => 'purchased-plans',
            'status' => 'active'
        ]);

        $permission = Permission::create([
            'name' => 'View Purchased Plans',
            'slug' => 'purchased-plans.view',
            'module_id' => $module->id
        ]);
        
        UserPermission::create([
            'user_id' => $staff->id,
            'permission_id' => $permission->id,
            'allowed' => true
        ]);

        $plan = Plan::create([
            'name' => 'Gold Plan',
            'slug' => 'gold-plan',
            'premium_amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'claim_duration_days' => 30,
            'compensation_amount' => 5000,
            'status' => 'active'
        ]);

        $purchasedPlan = PurchasedPlan::create([
            'user_id' => $customer->id,
            'plan_id' => $plan->id,
            'plan_unique_id' => 'MEM123',
            'plan_name' => 'Gold Plan',
            'amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active'
        ]);

        $response = $this->actingAs($staff)->get('/admin/purchased-plan/MEM123/pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_staff_without_permission_cannot_download_pdf()
    {
        $customer = User::factory()->create(['role_id' => 0]);
        $staff = User::factory()->create(['role_id' => 2]); // non-superadmin staff
        
        $plan = Plan::create([
            'name' => 'Gold Plan',
            'slug' => 'gold-plan',
            'premium_amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'claim_duration_days' => 30,
            'compensation_amount' => 5000,
            'status' => 'active'
        ]);

        $purchasedPlan = PurchasedPlan::create([
            'user_id' => $customer->id,
            'plan_id' => $plan->id,
            'plan_unique_id' => 'MEM123',
            'plan_name' => 'Gold Plan',
            'amount' => 1000,
            'tenure_type' => 'month',
            'tenure_value' => 12,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active'
        ]);

        $response = $this->actingAs($staff)->get('/admin/purchased-plan/MEM123/pdf');
        $response->assertStatus(403);
    }
}
