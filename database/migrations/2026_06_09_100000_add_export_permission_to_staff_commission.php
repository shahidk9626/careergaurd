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
        $module = Module::where('slug', 'staff-commission')->first();
        if ($module) {
            $permission = Permission::updateOrCreate(
                ['slug' => 'staff-commission.export'],
                [
                    'module_id' => $module->id,
                    'name' => 'Export Staff Commission Invoices',
                ]
            );

            // Assign to admin role
            $adminRole = Role::where('slug', 'admin')->first();
            if ($adminRole) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'permission_id' => $permission->id],
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
        $permission = Permission::where('slug', 'staff-commission.export')->first();
        if ($permission) {
            DB::table('role_permissions')->where('permission_id', $permission->id)->delete();
            $permission->delete();
        }
    }
};
