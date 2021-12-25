<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Resources\RolesResources;

class RolesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $result = [];

        $permissions = Permission::all();
        $roles = Role::with('permissions')->get();

        $result['roles'] = RolesResources::collection($roles);
        $result['permissions'] = $permissions;
        
        return response()->json(['result' => $result], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'name_ar' => 'required|unique:roles',
        ]);

        $user = auth()->user();

        $role = Role::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'guard_name' => 'web'
        ]);



        if($role) {
            $role->givePermissionTo($request->permission);
            return $this->index();
        }

        return response()->json(['error' => 'Unknown Error'], 500);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();     
        $role = Role::find($id);
        
        if($role->name != $request->name) {
            $request->validate([
                'name' => 'required|unique:roles'
            ]);
            $role->name = $request->name;
        }

        if($role->name_ar != $request->name_ar) {
            $request->validate([
                'name_ar' => 'required|unique:roles'
            ]);
            $role->name_ar = $request->name_ar;
        }

        $role->guard_name = 'web';

        if($role->save()) {
            $role->syncPermissions($request->permission);
            return $this->index();
        }

        return response()->json(['error' => 'Unknown Error'], 500);

    }
}
