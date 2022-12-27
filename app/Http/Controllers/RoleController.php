<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function list()
    {

        Gate::authorize('view', 'roles');

        $result['status'] = 200;
        try {
            $roles = Role::get();
            $result['data'] = $roles;
        } catch(Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }

    public function store(StoreRoleRequest $request)
    {

        Gate::authorize('edit', 'roles');

        $result['status'] = 200;
        try {

            $role = new Role();
            $role->name = $request->name;
            $role->save();

            if($request->permissions) {
                foreach($request->permissions as $permission_id) {
                    DB::table('role_permission')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permission_id
                    ]);
                }
            }

            $role = Role::with('permissions')->findOrFail($role->id);

            $result['data'] = $role;
            $result['message'] = "Created";

        } catch(Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }

    public function show(Request $request)
    {

        Gate::authorize('view', 'roles');

        $result['status'] = 200;
        try {

            $role = Role::findOrFail($request->id);

            $result['data'] = $role;

        } catch(Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }

    public function update(UpdateRoleRequest $request)
    {

        Gate::authorize('edit', 'roles');

        $result['status'] = 200;
        try {

            $role = Role::with('permissions')->findOrFail($request->id);
            $role->name = $request->name;
            $role->save();


            DB::table('role_permission')->where('role_id', $role->id)->delete();

            if($request->permissions) {
                foreach($request->permissions as $permission_id) {
                    DB::table('role_permission')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permission_id
                    ]);
                }
            }

            $result['data'] = $role;
            $result['message'] = "Updated";

        } catch(Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }

    public function delete(Request $request)
    {

        Gate::authorize('edit', 'roles');

        $result['status'] = 200;
        try {

            $role = Role::findOrFail($request->id);
            $role->delete();

            $result['message'] = "Deleted";

        } catch(Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }
}
