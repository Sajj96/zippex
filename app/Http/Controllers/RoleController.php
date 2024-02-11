<?php

namespace App\Http\Controllers;

use App\Models\PermissionSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index () {
        $roles = Role::get();
        return view('pages.users.roles.index',[
            'roles' => $roles
        ]);
    }

    public function add(Request $request) {

        if ($request->method() == 'GET') {
            $permissions = PermissionSet::permissionsGroups();
            // dd($permissions);
            return view('pages.users.roles.add',[
                'permissions' => $permissions
            ]);
        }

        try {
            $request->validate([
                'name' => 'required|unique:roles,name',
                'permissions' => 'required|array',
            ]);

            $role = Role::create([
                'name' => ucwords($request->name),
            ]);

            if ($role) {
                if (count($request->permissions) > 0) {
                    $permissions =[];
                    foreach($request->permissions as $permission_name){
                        $permissions[] = Permission::firstOrCreate([
                            'name' => $permission_name
                        ]);
                    }
                    $role->syncPermissions($permissions);
                }else {
                    return back()->with('error', 'You must select permission(s) for the role');
                }
            }

            return redirect('/roles')->with('success','Role added successfully');
        } catch (\Exception $exception) {
            return back()->with('error', 'An error has occurred failed to add a new role');
        }
    }

    public function edit(Request $request, $id=null) {
        if (empty($id) && $request->has('id')){
            $id = $request->id;
        }

        $role = Role::find($id);
        if (!$role) {
            return back()->withError('Role not found');
        }

        if ($request->method() == 'GET') {
            $permissions = PermissionSet::permissionsGroups();
            $rolePermissions = $role->permissions()->pluck('name')->toArray();

            return view('pages.users.roles.edit',[
                'permissions' => $permissions,
                'role' => $role,
                'rolePermissions' => $rolePermissions
            ]);
        }

        try {
            $request->validate([
                'name' => 'required|unique:roles,name,'.$role->id,
                'permissions' => 'nullable|array'
            ]);

            $role->name = ucwords($request->name);
            if ($role->save()) {
                $permissions =[];
                if ($request->has('permissions')) {
                    foreach($request->permissions as $permission_name){
                        $permissions[] = Permission::firstOrCreate([
                            'name' => $permission_name
                        ]);
                    }
                }
                $role->syncPermissions($permissions);
                return redirect('/roles')->with('success','Role edited successfully');
            } else {
                return back()->with('error','Failed to save changes');
            }
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function delete(Request $request) {
        try {
            if ($request->has('role_id')) {
                $role = Role::find($request->input('role_id'));
                if ($role) {
                    $role->revokePermissionTo(Permission::all());
                    $role->delete();
                    return redirect('/roles')->withSuccess('Role Deleted');
                }
            }
        } catch(\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return redirect('/roles')->withError('Role could not be deleted');
    }
}
