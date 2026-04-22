<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Support\Str;

class RBACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Dashboard',
            'Roles',
            'Staff',
            'Customers',
            'Services',
            'Reports',
            'Settings',
        ];

        $actions = ['view', 'create', 'edit', 'delete', 'status'];

        foreach ($modules as $moduleName) {
            $module = Module::updateOrCreate(
                ['slug' => Str::slug($moduleName)],
                ['name' => $moduleName, 'status' => 'active']
            );

            foreach ($actions as $action) {
                Permission::updateOrCreate(
                    ['slug' => $module->slug . '.' . $action],
                    [
                        'module_id' => $module->id,
                        'name' => ucfirst($action) . ' ' . $moduleName,
                    ]
                );
            }
        }
    }
}
