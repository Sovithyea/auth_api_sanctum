<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {
        $result['status'] = 200;

        try {

            $users = User::latest()->paginate();
            $result['data'] = $users;

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function store(StoreUserRequest $request)
    {
        $result['status'] = 200;
        try {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            $result['data'] = $user;
            $result['message'] = "Created";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function show(Request $request)
    {
        $result['status'] = 200;

        try {
            $user = User::findOrFail($request->id);
            $result['data'] = $user;
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }

    public function update(UpdateUserRequest $request) {
        $result['status'] = 200;

        try {
            $user = User::findOrFail($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $result['data'] = $user;
            $result['message'] = "Updated";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }

    public function delete(Request $request)
    {
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
            $user = Auth::user();
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
            $user = Auth::user();
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
            $user = Auth::user();
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
