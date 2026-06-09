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
        $module = Module::updateOrCreate(
            ['slug' => 'commission'],
            [
                'name' => 'Commission Management',
                'status' => 'active'
            ]
        );

        $permissions = [
            'commission.view' => 'View Commission Listing',
            'commission.export' => 'Export Commission Invoices',
            'commission.summary' => 'View Commission Summaries',
        ];

        $adminRole = Role::where('slug', 'admin')->first();

        foreach ($permissions as $slug => $name) {
            $permission = Permission::updateOrCreate(
                ['slug' => $slug],
                [
                    'module_id' => $module->id,
                    'name' => $name,
                ]
            );

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
        $module = Module::where('slug', 'commission')->first();
        if ($module) {
            $permissionIds = Permission::where('module_id', $module->id)->pluck('id');
            DB::table('role_permissions')->whereIn('permission_id', $permissionIds)->delete();
            Permission::where('module_id', $module->id)->delete();
            $module->delete();
        }
    }
};
