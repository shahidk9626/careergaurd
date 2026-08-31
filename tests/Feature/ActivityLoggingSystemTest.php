<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plan;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\Permission;
use App\Models\UserPermission;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ActivityLoggingSystemTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $staff;
    private $customer;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard roles for testing
        $adminRole = Role::create(['name' => 'admin', 'slug' => 'admin', 'status' => 'active']);
        $staffRole = Role::create(['name' => 'staff', 'slug' => 'staff', 'status' => 'active']);

        // Create admin user (id = 1)
        $this->admin = User::factory()->create([
            'id' => 1,
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        // Create staff user (id = 2)
        $this->staff = User::factory()->create([
            'id' => 2,
            'role_id' => $staffRole->id,
            'status' => 'active',
        ]);

        // Create customer user (id = 3, role_id = 0)
        $this->customer = User::factory()->create([
            'id' => 3,
            'role_id' => 0,
            'status' => 'active',
        ]);

        // Create the Activity Logs module and permissions
        $module = Module::updateOrCreate(
            ['slug' => 'activity-logs'],
            ['name' => 'Activity Logs', 'status' => 'active']
        );
        $viewPermission = Permission::updateOrCreate(
            ['slug' => 'activity-logs.view'],
            ['module_id' => $module->id, 'name' => 'View Activity Logs']
        );
        $detailPermission = Permission::updateOrCreate(
            ['slug' => 'activity-logs.detail'],
            ['module_id' => $module->id, 'name' => 'View Activity Log Details']
        );

        // Grant permissions to the admin user
        UserPermission::create(['user_id' => $this->admin->id, 'permission_id' => $viewPermission->id, 'allowed' => true]);
        UserPermission::create(['user_id' => $this->admin->id, 'permission_id' => $detailPermission->id, 'allowed' => true]);
    }

    /**
     * Test plan creation registers a CREATE log.
     */
    public function test_plan_creation_generates_activity_log()
    {
        $plan = Plan::create([
            'name' => 'Test Bronze Plan',
            'slug' => 'test-bronze-plan',
            'short_description' => 'Test description',
            'premium_amount' => 499,
            'commission_amount' => 50,
            'tenure_type' => 'months',
            'tenure_value' => 6,
            'claim_duration_days' => 30,
            'compensation_amount' => 5000,
            'status' => 'active',
        ]);

        // Assert database has the plan
        $this->assertDatabaseHas('plans', ['id' => $plan->id]);

        // Assert database has the log
        $this->assertDatabaseHas('activity_logs', [
            'module_slug' => 'membership-plans',
            'action' => 'SERVICE_CREATED',
            'record_id' => $plan->id,
        ]);
    }

    /**
     * Test plan update registers an UPDATE status change.
     */
    public function test_plan_update_status_registers_status_change_log()
    {
        $plan = Plan::create([
            'name' => 'Test Gold Plan',
            'slug' => 'test-gold-plan',
            'premium_amount' => 999,
            'commission_amount' => 100,
            'tenure_type' => 'years',
            'tenure_value' => 1,
            'claim_duration_days' => 60,
            'compensation_amount' => 10000,
            'status' => 'active',
        ]);

        // Change status to inactive
        $plan->update(['status' => 'inactive']);

        $this->assertDatabaseHas('activity_logs', [
            'module_slug' => 'membership-plans',
            'action' => 'STATUS_CHANGE',
            'record_id' => $plan->id,
            'description' => "Status changed from 'active' to 'inactive'.",
        ]);
    }

    /**
     * Test sensitive fields are masked as [MASKED].
     */
    public function test_sensitive_fields_are_masked()
    {
        // Setup an auditable model (User is auditable)
        // Set password to check masking in logs
        $user = User::create([
            'name' => 'Sensitive Test User',
            'email' => 'sensitive@example.com',
            'password' => Hash::make('secret_password'),
            'role_id' => 0,
            'status' => 'active',
            'profile_completed' => 0,
        ]);

        $log = ActivityLog::where('module_slug', 'users')
            ->where('record_id', $user->id)
            ->firstOrFail();

        $this->assertNotNull($log->new_values);
        $this->assertEquals('[MASKED]', $log->new_values['password']);
    }

    /**
     * Test login logs authentication activity.
     */
    public function test_user_login_logs_activity()
    {
        $user = User::factory()->create([
            'email' => 'testlogin@example.com',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'role_id' => 0,
        ]);

        $this->post('/login', [
            'email' => 'testlogin@example.com',
            'password' => 'password123',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'module_slug' => 'authentication',
            'action' => 'LOGIN',
            'performed_by' => $user->id,
        ]);
    }

    /**
     * Test failed login logs failed activity.
     */
    public function test_failed_login_logs_activity()
    {
        $this->post('/login', [
            'email' => 'wrongemail@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'module_slug' => 'authentication',
            'action' => 'FAILED_LOGIN',
            'reference_no' => 'wrongemail@example.com',
        ]);
    }

    /**
     * Test customer cannot access the admin logs view.
     */
    public function test_customer_cannot_access_activity_logs()
    {
        $response = $this->actingAs($this->customer)->get('/admin/activity-logs');
        $response->assertStatus(403);
    }

    /**
     * Test authorized admin can access the activity logs page.
     */
    public function test_admin_can_access_activity_logs()
    {
        $response = $this->actingAs($this->admin)->get('/admin/activity-logs');
        $response->assertStatus(200);
    }
}
