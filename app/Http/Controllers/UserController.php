<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;

class UserController extends Controller
{
    public function list()
    {

        Gate::authorize('view', 'users');

        $result['status'] = 200;

        try {

            $users = User::with('role')->latest()->paginate();
            $result['data'] = $users;

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function store(StoreUserRequest $request)
    {

        Gate::authorize('edit', 'users');

        $result['status'] = 200;
        try {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->save();

            $data = User::with('role')->findOrFail($user->id);
            $result['data'] = $data;
            $result['message'] = "Created";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function show(Request $request)
    {

        Gate::authorize('view', 'users');

        $result['status'] = 200;

        try {
            $user = User::with('role')->findOrFail($request->id);
            $result['data'] = $user;
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }

    public function update(UpdateUserRequest $request)
    {

        Gate::authorize('edit', 'users');

        $result['status'] = 200;

        try {
            $user = User::findOrFail($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->save();

            $data = User::with('role')->findOrFail($user->id);
            $result['data'] = $data;
            $result['message'] = "Updated";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }

    public function delete(Request $request)
    {

        Gate::authorize('edit', 'users');

        $result['status'] = 200;

        try {
            $user = User::findOrFail($request->id);
            $user->delete();
            $result['message'] = "Deleted";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function user()
    {

        $result['status'] = 200;

        try {
            $user = User::with('role')->findOrFail(Auth()->id());
            $result['data'] = $user;
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }

    public function updateInfo(UpdateUserRequest $request)
    {

        $result['status'] = 200;

        try {
            $user = User::with('role')->findOrFail(Auth()->id());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $result['data'] = $user;
            $result['message'] = "Updated Info";
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);

    }

    public function updatePassword(UpdatePasswordRequest $request)
    {

        $result['status'] = 200;

        try {
            $user = User::with('role')->findOrFail(Auth()->id());
            if(!Hash::check($request->old_password, $user->password)) {
                $result['status'] = 201;
                $result['message'] = "The old were incorrect.";
            } else {
                $user->password = $request->password;
                $user->save();
                $result['data'] = $user;
                $result['message'] = "Changed Password";
            }
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);

    }

}
