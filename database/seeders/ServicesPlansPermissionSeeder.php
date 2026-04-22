<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use DB;

class ServicesPlansPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Add Plans Module if not exists
        $plansModule = Module::firstOrCreate(['slug' => 'plans'], ['name' => 'Plans', 'status' => 'active']);
        $servicesModule = Module::where('slug', 'services')->first();

        $permissions = [
            // Plans Permissions
            ['module_id' => $plansModule->id, 'name' => 'View Plans', 'slug' => 'plans.view'],
            ['module_id' => $plansModule->id, 'name' => 'Create Plans', 'slug' => 'plans.create'],
            ['module_id' => $plansModule->id, 'name' => 'Edit Plans', 'slug' => 'plans.edit'],
            ['module_id' => $plansModule->id, 'name' => 'Delete Plans', 'slug' => 'plans.delete'],

            // Services Permissions
            ['module_id' => $servicesModule->id, 'name' => 'View Resumes', 'slug' => 'resumes.view'],
            ['module_id' => $servicesModule->id, 'name' => 'Create Resumes', 'slug' => 'resumes.create'],
            ['module_id' => $servicesModule->id, 'name' => 'Edit Resumes', 'slug' => 'resumes.edit'],
            ['module_id' => $servicesModule->id, 'name' => 'Delete Resumes', 'slug' => 'resumes.delete'],

            ['module_id' => $servicesModule->id, 'name' => 'View Job Links', 'slug' => 'job-links.view'],
            ['module_id' => $servicesModule->id, 'name' => 'Create Job Links', 'slug' => 'job-links.create'],
            ['module_id' => $servicesModule->id, 'name' => 'Edit Job Links', 'slug' => 'job-links.edit'],
            ['module_id' => $servicesModule->id, 'name' => 'Delete Job Links', 'slug' => 'job-links.delete'],

            ['module_id' => $servicesModule->id, 'name' => 'View Questions', 'slug' => 'questions.view'],
            ['module_id' => $servicesModule->id, 'name' => 'Create Questions', 'slug' => 'questions.create'],
            ['module_id' => $servicesModule->id, 'name' => 'Edit Questions', 'slug' => 'questions.edit'],
            ['module_id' => $servicesModule->id, 'name' => 'Delete Questions', 'slug' => 'questions.delete'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['slug' => $perm['slug']], $perm);
        }

        // Assign all to Admin role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $allPermIds = Permission::whereIn('slug', array_column($permissions, 'slug'))->pluck('id')->toArray();
            foreach ($allPermIds as $permId) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'permission_id' => $permId],
                    ['allowed' => 1]
                );
            }
        }
    }
}
