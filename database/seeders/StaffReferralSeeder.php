<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class StaffReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch or create Customers module
        $customerModule = Module::firstOrCreate(
            ['slug' => 'customers'],
            ['name' => 'Customers', 'status' => 'active']
        );

        // 2. Add customers.purchase_membership permission
        $purchaseMembershipPerm = Permission::updateOrCreate(
            ['slug' => 'customers.purchase_membership'],
            [
                'module_id' => $customerModule->id,
                'name' => 'Purchase Customer Membership',
            ]
        );

        // 3. Create Staff Commission module
        $commissionModule = Module::updateOrCreate(
            ['slug' => 'staff-commission'],
            ['name' => 'Staff Commission', 'status' => 'active']
        );

        // 4. Create staff commission permissions
        $viewCommissionPerm = Permission::updateOrCreate(
            ['slug' => 'staff-commission.view'],
            [
                'module_id' => $commissionModule->id,
                'name' => 'View Staff Commissions',
            ]
        );

        $statusCommissionPerm = Permission::updateOrCreate(
            ['slug' => 'staff-commission.status'],
            [
                'module_id' => $commissionModule->id,
                'name' => 'Update Staff Commission Status',
            ]
        );

        // 5. Assign all these permissions to the Admin role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $permIds = [
                $purchaseMembershipPerm->id,
                $viewCommissionPerm->id,
                $statusCommissionPerm->id
            ];

            foreach ($permIds as $permId) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'permission_id' => $permId],
                    ['allowed' => 1]
                );
            }
        }

        // 6. Assign customers.purchase_membership and staff-commission.view to Staff role if exists
        $staffRole = Role::where('slug', 'staff')->first();
        if ($staffRole) {
            $staffPermIds = [
                $purchaseMembershipPerm->id,
                $viewCommissionPerm->id
            ];

            foreach ($staffPermIds as $permId) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $staffRole->id, 'permission_id' => $permId],
                    ['allowed' => 1]
                );
            }
        }
    }
}
