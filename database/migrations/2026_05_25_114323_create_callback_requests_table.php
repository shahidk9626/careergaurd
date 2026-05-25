<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('callback_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('purchased_plan_id')->nullable()->constrained('purchased_plans')->onDelete('set null');
            $table->foreignId('claim_id')->nullable()->constrained('claims')->onDelete('set null');
            $table->string('flag', 50); // direct, purchased, enquiry
            $table->text('concern');
            $table->string('status', 50)->default('pending'); // pending, contacted, resolved, closed
            $table->timestamps();
        });

        // Add Request Callback Module
        $module = Module::firstOrCreate(
            ['slug' => 'request-callback'],
            ['name' => 'Request Callback', 'status' => 'active']
        );

        // Add Permissions
        $actions = ['view', 'create', 'edit', 'status', 'delete'];
        $permissionIds = [];

        foreach ($actions as $action) {
            $perm = Permission::updateOrCreate(
                ['slug' => 'request-callback.' . $action],
                [
                    'module_id' => $module->id,
                    'name' => ucfirst($action) . ' Request Callback',
                ]
            );
            $permissionIds[] = $perm->id;
        }

        // Assign to Admin role (slug = 'admin')
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            foreach ($permissionIds as $permId) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'permission_id' => $permId],
                    ['allowed' => 1]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callback_requests');

        // Delete permissions and module
        $permissions = Permission::where('slug', 'like', 'request-callback.%')->get();
        foreach ($permissions as $perm) {
            DB::table('role_permissions')->where('permission_id', $perm->id)->delete();
            $perm->delete();
        }

        Module::where('slug', 'request-callback')->delete();
    }
};
