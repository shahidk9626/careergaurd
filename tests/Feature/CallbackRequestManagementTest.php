<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CallbackRequest;
use App\Models\Module;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CallbackRequestManagementTest extends TestCase
{
    use RefreshDatabase;

    private $staff;
    private $module;
    private $deletePermission;
    private $exportPermission;
    private $viewPermission;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Super Admin first so it gets ID = 1
        User::factory()->create(['id' => 1, 'role_id' => 1]);

        // Create standard staff (gets ID = 2)
        $this->staff = User::factory()->create(['role_id' => 2]);

        // Find existing Module and Permissions inserted via migrations
        $this->module = Module::where('slug', 'request-callback')->firstOrFail();
        $this->viewPermission = Permission::where('slug', 'request-callback.view')->firstOrFail();
        $this->deletePermission = Permission::where('slug', 'request-callback.delete')->firstOrFail();
        $this->exportPermission = Permission::where('slug', 'request-callback.export')->firstOrFail();

        // Grant View permission by default
        UserPermission::create([
            'user_id' => $this->staff->id,
            'permission_id' => $this->viewPermission->id,
            'allowed' => true
        ]);
    }

    public function test_staff_without_delete_permission_cannot_delete_callback()
    {
        $callback = CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Help with resume',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->staff)->delete("/admin/request-callback/delete/{$callback->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('callback_requests', ['id' => $callback->id]);
    }

    public function test_staff_with_delete_permission_can_delete_callback()
    {
        // Grant Delete permission
        UserPermission::create([
            'user_id' => $this->staff->id,
            'permission_id' => $this->deletePermission->id,
            'allowed' => true
        ]);

        $callback = CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Help with resume',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->staff)->delete("/admin/request-callback/delete/{$callback->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Callback request deleted successfully.']);
        $this->assertDatabaseMissing('callback_requests', ['id' => $callback->id]);
    }

    public function test_staff_without_delete_permission_cannot_bulk_delete_callbacks()
    {
        $callback1 = CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Help 1',
            'status' => 'pending'
        ]);
        $callback2 = CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Help 2',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->staff)->post("/admin/request-callback/bulk-delete", [
            'ids' => [$callback1->id, $callback2->id]
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('callback_requests', ['id' => $callback1->id]);
        $this->assertDatabaseHas('callback_requests', ['id' => $callback2->id]);
    }

    public function test_staff_with_delete_permission_can_bulk_delete_callbacks_safely()
    {
        // Grant Delete permission
        UserPermission::create([
            'user_id' => $this->staff->id,
            'permission_id' => $this->deletePermission->id,
            'allowed' => true
        ]);

        $callback1 = CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Help 1',
            'status' => 'pending'
        ]);
        $callback2 = CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Help 2',
            'status' => 'pending'
        ]);
        $callbackUnrelated = CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Do not delete this',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->staff)->post("/admin/request-callback/bulk-delete", [
            'ids' => [$callback1->id, $callback2->id]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Selected callback requests deleted successfully.']);
        $this->assertDatabaseMissing('callback_requests', ['id' => $callback1->id]);
        $this->assertDatabaseMissing('callback_requests', ['id' => $callback2->id]);
        
        // Audit Safety Check: Unrelated record must not be deleted
        $this->assertDatabaseHas('callback_requests', ['id' => $callbackUnrelated->id]);
    }

    public function test_staff_without_export_permission_cannot_export_callbacks()
    {
        $response = $this->actingAs($this->staff)->get("/admin/request-callback/export");

        $response->assertStatus(403);
    }

    public function test_staff_with_export_permission_can_export_callbacks()
    {
        // Grant Export permission
        UserPermission::create([
            'user_id' => $this->staff->id,
            'permission_id' => $this->exportPermission->id,
            'allowed' => true
        ]);

        CallbackRequest::create([
            'user_id' => User::factory()->create()->id,
            'flag' => 'direct',
            'concern' => 'Test Export',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->staff)->get("/admin/request-callback/export");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->assertStringContainsString('attachment; filename="Callback_Requests_', $response->headers->get('Content-Disposition'));
    }
}
