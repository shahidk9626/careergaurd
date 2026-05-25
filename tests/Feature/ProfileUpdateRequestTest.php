<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CustomerDetail;
use App\Models\CustomerUpdateRequest;
use App\Models\CustomerUpdateRequestDetail;
use App\Mail\CustomerProfileUpdateRequestSubmittedMail;
use App\Mail\CustomerProfileUpdateRequestApprovedMail;
use App\Mail\CustomerProfileUpdateRequestRejectedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ProfileUpdateRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Roles
        $adminRole = \App\Models\Role::create(['slug' => 'admin', 'name' => 'Admin']);
        $customerRole = \App\Models\Role::create(['slug' => 'customer', 'name' => 'Customer']);

        // Create Customer
        $this->customer = User::factory()->create([
            'role_id' => 0,
            'email' => 'customer@example.com',
            'name' => 'John Doe',
            'phone' => '1111111111',
            'whatsapp_number' => '1111111111',
        ]);

        CustomerDetail::create([
            'user_id' => $this->customer->id,
            'address' => 'Old Address',
            'city' => 'Old City',
            'state' => 'Old State',
            'pincode' => '123456',
            'slug' => 'john-doe',
        ]);

        // Create Admin
        $this->admin = User::factory()->create([
            'role_id' => $adminRole->id,
            'email' => 'admin@example.com',
        ]);
    }

    public function test_profile_update_creates_pending_request_instead_of_direct_update(): void
    {
        Mail::fake();

        $this->actingAs($this->customer);

        $response = $this->post(route('customer.profile.update'), [
            'name' => 'New Name',
            'phone' => '1111111111', // unchanged
            'whatsapp_number' => '2222222222', // changed
            'address' => 'Old Address', // unchanged
            'city' => 'New City', // changed
            'state' => 'Old State', // unchanged
            'pincode' => '123456', // unchanged
        ]);

        $response->assertRedirect(route('customer.profile'));
        $response->assertSessionHas('success');

        // Original database data should NOT be changed
        $this->customer->refresh();
        $this->assertEquals('John Doe', $this->customer->name);
        $this->assertEquals('Old City', $this->customer->customerDetail->city);

        // A pending request should be created
        $request = CustomerUpdateRequest::where('customer_id', $this->customer->id)->first();
        $this->assertNotNull($request);
        $this->assertEquals('pending', $request->status);

        // Verification of detail values stored in the history table
        $this->assertCount(3, $request->details);
        $this->assertDatabaseHas('customer_update_request_details', [
            'request_id' => $request->id,
            'field_name' => 'name',
            'old_value' => 'John Doe',
            'new_value' => 'New Name',
        ]);
        $this->assertDatabaseHas('customer_update_request_details', [
            'request_id' => $request->id,
            'field_name' => 'whatsapp_number',
            'old_value' => '1111111111',
            'new_value' => '2222222222',
        ]);
        $this->assertDatabaseHas('customer_update_request_details', [
            'request_id' => $request->id,
            'field_name' => 'city',
            'old_value' => 'Old City',
            'new_value' => 'New City',
        ]);

        Mail::assertSent(CustomerProfileUpdateRequestSubmittedMail::class);
    }

    public function test_multiple_pending_requests_are_prevented(): void
    {
        // Setup an existing pending request
        CustomerUpdateRequest::create([
            'customer_id' => $this->customer->id,
            'requested_by' => $this->customer->id,
            'status' => 'pending',
        ]);

        $this->actingAs($this->customer);

        $response = $this->post(route('customer.profile.update'), [
            'name' => 'Another Name',
            'phone' => '3333333333',
            'whatsapp_number' => '3333333333',
            'address' => 'Another Address',
            'city' => 'Another City',
            'state' => 'Another State',
            'pincode' => '999999',
        ]);

        $response->assertSessionHas('error', 'Your previous profile update request is still pending.');
        $this->assertEquals(1, CustomerUpdateRequest::count());
    }

    public function test_admin_can_approve_request(): void
    {
        Mail::fake();

        // Seed permissions for approval
        $module = \App\Models\Module::create(['slug' => 'profile-update-requests', 'name' => 'Profile Update Requests', 'status' => 'active']);
        $viewPerm = \App\Models\Permission::create(['slug' => 'profile-update-requests.view', 'name' => 'View Requests', 'module_id' => $module->id]);
        $approvePerm = \App\Models\Permission::create(['slug' => 'profile-update-requests.approve', 'name' => 'Approve Requests', 'module_id' => $module->id]);
        
        $this->admin->permissions()->attach([$viewPerm->id, $approvePerm->id], ['allowed' => 1]);

        $updateRequest = CustomerUpdateRequest::create([
            'customer_id' => $this->customer->id,
            'requested_by' => $this->customer->id,
            'status' => 'pending',
        ]);

        CustomerUpdateRequestDetail::create([
            'request_id' => $updateRequest->id,
            'field_name' => 'name',
            'old_value' => 'John Doe',
            'new_value' => 'Jane Approved',
        ]);

        CustomerUpdateRequestDetail::create([
            'request_id' => $updateRequest->id,
            'field_name' => 'city',
            'old_value' => 'Old City',
            'new_value' => 'Approved City',
        ]);

        $this->actingAs($this->admin);

        $response = $this->post(route('admin.profile-update-requests.approve', $updateRequest->id));

        $response->assertRedirect(route('admin.profile-update-requests.show', $updateRequest->id));
        $response->assertSessionHas('success');

        // Customer details should be updated
        $this->customer->refresh();
        $this->assertEquals('Jane Approved', $this->customer->name);
        $this->assertEquals('Approved City', $this->customer->customerDetail->city);

        // Request status should be updated
        $updateRequest->refresh();
        $this->assertEquals('approved', $updateRequest->status);
        $this->assertEquals($this->admin->id, $updateRequest->approved_by);

        Mail::assertSent(CustomerProfileUpdateRequestApprovedMail::class);
    }

    public function test_admin_can_reject_request(): void
    {
        Mail::fake();

        // Seed permissions for rejection
        $module = \App\Models\Module::create(['slug' => 'profile-update-requests', 'name' => 'Profile Update Requests', 'status' => 'active']);
        $viewPerm = \App\Models\Permission::create(['slug' => 'profile-update-requests.view', 'name' => 'View Requests', 'module_id' => $module->id]);
        $rejectPerm = \App\Models\Permission::create(['slug' => 'profile-update-requests.reject', 'name' => 'Reject Requests', 'module_id' => $module->id]);
        
        $this->admin->permissions()->attach([$viewPerm->id, $rejectPerm->id], ['allowed' => 1]);

        $updateRequest = CustomerUpdateRequest::create([
            'customer_id' => $this->customer->id,
            'requested_by' => $this->customer->id,
            'status' => 'pending',
        ]);

        CustomerUpdateRequestDetail::create([
            'request_id' => $updateRequest->id,
            'field_name' => 'name',
            'old_value' => 'John Doe',
            'new_value' => 'Jane Rejected',
        ]);

        $this->actingAs($this->admin);

        $response = $this->post(route('admin.profile-update-requests.reject', $updateRequest->id), [
            'remark' => 'Documents are invalid.',
        ]);

        $response->assertRedirect(route('admin.profile-update-requests.show', $updateRequest->id));
        $response->assertSessionHas('success');

        // Customer details should NOT be updated
        $this->customer->refresh();
        $this->assertEquals('John Doe', $this->customer->name);

        // Request status should be updated
        $updateRequest->refresh();
        $this->assertEquals('rejected', $updateRequest->status);
        $this->assertEquals('Documents are invalid.', $updateRequest->admin_remark);

        Mail::assertSent(CustomerProfileUpdateRequestRejectedMail::class);
    }
}
