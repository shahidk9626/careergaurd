<?php

use Illuminate\Database\Migrations\Migration;
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
        // Find the Request Callback Module
        $module = Module::where('slug', 'request-callback')->first();

        if ($module) {
            // Create request-callback.export permission
            $perm = Permission::updateOrCreate(
                ['slug' => 'request-callback.export'],
                [
                    'module_id' => $module->id,
                    'name' => 'Export Request Callback',
                ]
            );

            // Assign to Admin role (slug = 'admin')
            $adminRole = Role::where('slug', 'admin')->first();
            if ($adminRole) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'permission_id' => $perm->id],
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
        $perm = Permission::where('slug', 'request-callback.export')->first();
        if ($perm) {
            DB::table('role_permissions')->where('permission_id', $perm->id)->delete();
            $perm->delete();
        }
    }
};
