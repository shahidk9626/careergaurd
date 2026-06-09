<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plan;
use App\Models\PurchasedPlan;
use App\Models\StaffDetail;
use App\Models\Permission;
use App\Models\UserPermission;
use App\Models\StaffCommissionPayment;
use App\Models\StaffCommissionPaymentDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommissionPaymentManagementTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $staff;
    private $staffDetail;
    private $plan;
    private $customer;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create Admin User (id=1)
        $this->admin = User::factory()->create([
            'id' => 1,
            'role_id' => 1,
            'status' => 'active'
        ]);

        // 2. Create Staff User (id=2) and StaffDetail
        $this->staff = User::factory()->create([
            'id' => 2,
            'role_id' => 2,
            'status' => 'active'
        ]);

        $this->staffDetail = StaffDetail::create([
            'user_id' => $this->staff->id,
            'emp_code' => 'EMP100',
            'slug' => 'john-representative',
            'first_name' => 'John',
            'last_name' => 'Representative',
            'full_name' => 'John Representative',
            'father_name' => 'Father Name',
            'address' => '123 Street Address',
            'city' => 'Cityville',
            'state' => 'StateProvince',
            'country' => 'CountryLand',
            'pincode' => '123456',
            'department' => 'Sales',
            'designation' => 'Representative',
            'joining_date' => '2026-01-01',
        ]);

        // 3. Create Plan with commission_amount
        $this->plan = Plan::create([
            'name' => 'Premium Career Shield Plan',
            'slug' => 'premium-career-shield',
            'commission_amount' => 500.00,
            'premium_amount' => 1800.00,
            'tenure_type' => 'yearly',
            'tenure_value' => 1,
            'claim_duration_days' => 30,
            'compensation_amount' => 10000.00,
        ]);

        // 4. Create Customer
        $this->customer = User::factory()->create([
            'role_id' => 0,
            'status' => 'active',
            'verification_status' => 'verified'
        ]);
    }

    private function createReferredPolicy($planUniqueId = 'POL999')
    {
        $policy = PurchasedPlan::create([
            'user_id' => $this->customer->id,
            'plan_id' => $this->plan->id,
            'plan_unique_id' => $planUniqueId,
            'amount' => 1800.00,
            'plan_name' => $this->plan->name,
            'tenure_type' => 'yearly',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
            'status' => 'active',
            'referred_by' => $this->staff->id
        ]);

        // Create success transaction
        DB::table('transactions')->insert([
            'user_id' => $this->customer->id,
            'plan_id' => $this->plan->id,
            'plan_unique_id' => $planUniqueId,
            'payment_status' => 'success',
            'amount' => 1800.00,
            'transaction_reference' => 'TXN_' . uniqid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $policy;
    }

    private function grantPermission($user, $permissionSlug)
    {
        $permission = Permission::where('slug', $permissionSlug)->first();
        if (!$permission) {
            // fallback if not run via migration
            $permission = Permission::create([
                'slug' => $permissionSlug,
                'name' => 'Permission ' . $permissionSlug,
                'module_id' => 1
            ]);
        }

        UserPermission::create([
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'allowed' => true
        ]);
    }

    /**
     * Test admin can access view listing and standard staff is restricted
     */
    public function test_permissions_access_to_commission_module()
    {
        // Staff without permission gets 403
        $response = $this->actingAs($this->staff)->get(route('admin.commission.index'));
        $response->assertStatus(403);

        // Staff with commission.view permission can access
        $this->grantPermission($this->staff, 'commission.view');
        $response = $this->actingAs($this->staff)->get(route('admin.commission.index'));
        $response->assertStatus(200);

        // Admin can access by default
        $response = $this->actingAs($this->admin)->get(route('admin.commission.index'));
        $response->assertStatus(200);
    }

    /**
     * Test admin can view staff summaries, staff can view their own summary, and staff cannot view others
     */
    public function test_summary_access_restrictions()
    {
        $this->grantPermission($this->staff, 'commission.view');
        $this->createReferredPolicy();

        // 1. Staff can view their own summary
        $response = $this->actingAs($this->staff)->get(route('admin.commission.summary', [
            'staff_code' => $this->staffDetail->emp_code
        ]));
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('staff.code', $this->staffDetail->emp_code);

        // 2. Staff cannot view summary of another staff member
        $otherStaff = User::factory()->create(['role_id' => 2]);
        $otherDetail = StaffDetail::create([
            'user_id' => $otherStaff->id,
            'emp_code' => 'EMP200',
            'slug' => 'other-representative',
            'first_name' => 'Other',
            'last_name' => 'Representative',
            'full_name' => 'Other Representative',
            'father_name' => 'Father Name',
            'address' => '123 Street Address',
            'city' => 'Cityville',
            'state' => 'StateProvince',
            'country' => 'CountryLand',
            'pincode' => '123456',
            'joining_date' => '2026-01-01',
        ]);

        $response = $this->actingAs($this->staff)->get(route('admin.commission.summary', [
            'staff_code' => $otherDetail->emp_code
        ]));
        $response->assertStatus(403);

        // 3. Admin can view anyone's summary
        $response = $this->actingAs($this->admin)->get(route('admin.commission.summary', [
            'staff_code' => $this->staffDetail->emp_code
        ]));
        $response->assertStatus(200);
    }

    /**
     * Test updating commission status requires proper validation
     */
    public function test_manage_commission_status_validation()
    {
        $policy = $this->createReferredPolicy();

        // 1. Hold and Rejected statuses require description/reason
        $response = $this->actingAs($this->admin)->post(route('admin.commission.manage'), [
            'purchased_plan_id' => $policy->id,
            'status' => 'Hold',
        ]);
        $response->assertSessionHasErrors(['description']);

        $response = $this->actingAs($this->admin)->post(route('admin.commission.manage'), [
            'purchased_plan_id' => $policy->id,
            'status' => 'Rejected',
        ]);
        $response->assertSessionHasErrors(['description']);

        // 2. Paid status requires a screenshot proof file
        $response = $this->actingAs($this->admin)->post(route('admin.commission.manage'), [
            'purchased_plan_id' => $policy->id,
            'status' => 'Paid',
        ]);
        $response->assertSessionHasErrors(['screenshot']);
    }

    /**
     * Test single payout settlement generates batch reference
     */
    public function test_single_commission_settlement_creates_payment_batch()
    {
        Storage::fake('public');
        $policy = $this->createReferredPolicy();

        $file = UploadedFile::fake()->image('proof.png');

        $response = $this->actingAs($this->admin)->post(route('admin.commission.manage'), [
            'purchased_plan_id' => $policy->id,
            'status' => 'Paid',
            'screenshot' => $file,
            'description' => 'Single payout transfer'
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', 'Commission status updated successfully.');

        // Verify batch payment was created
        $this->assertDatabaseHas('staff_commission_payments', [
            'staff_id' => $this->staff->id,
            'total_policies' => 1,
            'total_commission_amount' => 500.00,
        ]);

        $payment = StaffCommissionPayment::where('staff_id', $this->staff->id)->first();
        $this->assertNotNull($payment->batch_reference);
        $this->assertStringStartsWith('COM-', $payment->batch_reference);

        // Verify details table updated
        $this->assertDatabaseHas('staff_commission_payment_details', [
            'purchased_plan_id' => $policy->id,
            'payment_id' => $payment->id,
            'status' => 'Paid',
        ]);
    }

    /**
     * Test bulk settlement generates batch payment and handles already paid validation
     */
    public function test_bulk_commission_settlement()
    {
        Storage::fake('public');
        $policy1 = $this->createReferredPolicy('POL001');
        $policy2 = $this->createReferredPolicy('POL002');

        $file = UploadedFile::fake()->image('proof.png');

        $response = $this->actingAs($this->admin)->post(route('admin.commission.bulk-settle'), [
            'staff_code' => $this->staffDetail->emp_code,
            'policy_ids' => [$policy1->id, $policy2->id],
            'payment_date' => '2026-06-10',
            'screenshot' => $file,
            'description' => 'Bulk payout batch test'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success']);

        // Verify payment record
        $this->assertDatabaseHas('staff_commission_payments', [
            'staff_id' => $this->staff->id,
            'total_policies' => 2,
            'total_commission_amount' => 1000.00, // 500 + 500
        ]);

        $payment = StaffCommissionPayment::where('staff_id', $this->staff->id)->first();

        // Verify detail records
        $this->assertDatabaseHas('staff_commission_payment_details', [
            'purchased_plan_id' => $policy1->id,
            'payment_id' => $payment->id,
            'status' => 'Paid',
        ]);
        $this->assertDatabaseHas('staff_commission_payment_details', [
            'purchased_plan_id' => $policy2->id,
            'payment_id' => $payment->id,
            'status' => 'Paid',
        ]);

        // Attempting to pay again should fail
        $response = $this->actingAs($this->admin)->post(route('admin.commission.bulk-settle'), [
            'staff_code' => $this->staffDetail->emp_code,
            'policy_ids' => [$policy1->id],
            'payment_date' => '2026-06-10',
            'screenshot' => $file,
        ]);
        $response->assertStatus(400);
    }

    /**
     * Test dashboard statistics matches dynamic and state values
     */
    public function test_dashboard_statistics()
    {
        $policy1 = $this->createReferredPolicy('POL101');
        $policy2 = $this->createReferredPolicy('POL102');
        $policy3 = $this->createReferredPolicy('POL103');

        // policy1 paid
        StaffCommissionPaymentDetail::create([
            'purchased_plan_id' => $policy1->id,
            'customer_id' => $this->customer->id,
            'plan_id' => $this->plan->id,
            'commission_amount' => 500.00,
            'status' => 'Paid',
        ]);

        // policy2 hold
        StaffCommissionPaymentDetail::create([
            'purchased_plan_id' => $policy2->id,
            'customer_id' => $this->customer->id,
            'plan_id' => $this->plan->id,
            'commission_amount' => 500.00,
            'status' => 'Hold',
        ]);

        // policy3 pending (no record in details defaults to Pending)

        $response = $this->actingAs($this->staff)->get('/dashboard');
        $response->assertStatus(200);

        // Retrieve variables passed to the dashboard view
        $staffStats = $response->original->getData()['staffStats'];
        
        $this->assertEquals(1500.00, $staffStats['overall_commission_earned']); // all 3 earned (500 * 3)
        $this->assertEquals(500.00, $staffStats['total_paid']); // only policy1 paid
        $this->assertEquals(1000.00, $staffStats['total_due']); // policy2 hold + policy3 pending
    }
}
