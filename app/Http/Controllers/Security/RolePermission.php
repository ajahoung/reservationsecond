<?php

namespace App\Http\Controllers\Security;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermission extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::get();
        $permissions = Permission::get();
        return view('role-permission.permissions', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $permission = new Permission();
        $permission->name=$request->title;
        $permission->title=$request->title;
        $permission->guard_name="web";
        $permission->parent_id=1;
        $b_ool = $permission->save();
        if ($b_ool) {
            return redirect()->route('role.permission.list')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('role.permission.list')->withErrors(__('Delete', ['name' => __('users.store')]));
        }
    }
    public function storepermission(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user_id = $request->user()->id;
        $ob = $data['ob'];
        for ($i = 0; $i < sizeof($ob); ++$i) {
            $role = Role::query()->find($ob[$i]['role']);
            $role->givePermissionTo($ob[$i]['permission']);
        }
        return response()->json(["test"]);
    }
}
