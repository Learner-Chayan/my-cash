<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth','Setting']);
    }


    public function index()
    {
        $page_title = "Manage Role";
        $permission = Permission::get();
        $roles = Role::with('permissions')->orderBy('id','desc')->get();
        return view('admin.roles.index',compact('roles','page_title','permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $permissionIds = $request->input('permission'); // this is an array of IDs
        $permissionNames = Permission::find($permissionIds)->pluck('name');
        $role->syncPermissions($permissionNames);
        return redirect()->back()
            ->with('success','Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('admin.roles.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {
        $page_title = "Edit Role";
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('admin.roles.edit',compact('role','permission','rolePermissions','page_title'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
//        $role->save();
//
//        $permissionIds = $request->input('permission'); // this is an array of IDs
//        $permissionNames = Permission::find($permissionIds)->pluck('name');
//        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')
            ->with('error','Role not updated successfully');
    }

    public function destroy($id)
    {
//        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
            ->with('error','Role not deleted successfully');
    }
}
