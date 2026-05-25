<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class ProfileUpdateRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Profile Update Requests module
        $module = Module::updateOrCreate(
            ['slug' => 'profile-update-requests'],
            ['name' => 'Profile Update Requests', 'status' => 'active']
        );

        // 2. Create permissions
        $viewPerm = Permission::updateOrCreate(
            ['slug' => 'profile-update-requests.view'],
            [
                'module_id' => $module->id,
                'name' => 'View Profile Update Requests',
            ]
        );

        $approvePerm = Permission::updateOrCreate(
            ['slug' => 'profile-update-requests.approve'],
            [
                'module_id' => $module->id,
                'name' => 'Approve Profile Update Requests',
            ]
        );

        $rejectPerm = Permission::updateOrCreate(
            ['slug' => 'profile-update-requests.reject'],
            [
                'module_id' => $module->id,
                'name' => 'Reject Profile Update Requests',
            ]
        );

        // 3. Assign permissions to Admin role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $permIds = [
                $viewPerm->id,
                $approvePerm->id,
                $rejectPerm->id
            ];

            foreach ($permIds as $permId) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'permission_id' => $permId],
                    ['allowed' => 1]
                );
            }
        }
    }
}
