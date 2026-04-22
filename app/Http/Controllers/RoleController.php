<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::latest()->get();
            return response()->json(['data' => $roles]);
        }
        $modules = Module::with('permissions')->where('status', 'active')->get();
        return view('roles.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'status' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'status' => $request->status,
                'created_by' => Auth::id(),
            ]);

            if ($request->has('permissions')) {
                foreach ($request->permissions as $permissionId => $allowed) {
                    RolePermission::create([
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                        'allowed' => $allowed == '1',
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Role created successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'status' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'status' => $request->status,
            ]);

            if ($request->has('permissions')) {
                RolePermission::where('role_id', $role->id)->delete();
                foreach ($request->permissions as $permissionId => $allowed) {
                    RolePermission::create([
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                        'allowed' => $allowed == '1',
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Role updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPermissions($id)
    {
        $permissions = RolePermission::where('role_id', $id)->get();
        return response()->json($permissions);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['success' => 'Role deleted successfully.']);
    }

    public function rolePermissionsIndex(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::latest()->get();
            return response()->json(['data' => $roles]);
        }
        return view('role-permissions.index');
    }

    public function manageRolePermissions($id)
    {
        $role = Role::findOrFail($id);
        $modules = Module::with('permissions')->where('status', 'active')->get();
        $rolePermissions = RolePermission::where('role_id', $id)->get()->pluck('allowed', 'permission_id')->toArray();

        return view('role-permissions.manage', compact('role', 'modules', 'rolePermissions'));
    }

    public function toggleStatus($id)
    {
        $role = Role::findOrFail($id);
        $role->update(['status' => !$role->status]);

        return response()->json(['success' => 'Status updated successfully.']);
    }
}