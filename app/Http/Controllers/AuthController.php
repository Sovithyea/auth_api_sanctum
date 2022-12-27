<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Throwable;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $result = ['status' => 200];

        try {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $result['data'] = $user;
            $result['message'] = "Registered";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function login(LoginRequest $request)
    {

        $result = ['status' => 200];

        try {
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password))
            {
                $result['status'] = 201;
                $result['message'] = "The user credentials were incorrect.";
            } else {
                $token = $user->createToken('access_token')->plainTextToken;
                $result['token'] = $token;
                $result['data'] = $user;
                $result['message'] = "Login";
            }

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function logout()
    {

        $result = ['status' => 200];

        try {
            auth()->user()->tokens()->delete();
            $result['message'] = "Logout";
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }

    public function forgot(ForgotRequest $request)
    {

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT)
        {
            return response()->json([
                'message' => 'Your password reset link has been sent to your email.'
            ]);
        }

        return response()->json([
            'message' => __($status)
        ]);
    }

    public function reset(ResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET)
        {
            return response()->json([
                'message' => 'Password has been reset'
            ]);
        }

        return response()->json([
            'message' => __($status)
        ]);

    }

    public function user()
    {
        $result = ['status' => 200];
        try {
            $user = auth()->user();
            $result['data'] = $user;
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }
}
