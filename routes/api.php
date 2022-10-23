<?php

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('products', [ProductController::class, 'index']);

// Route::post('products', [ProductController::class, 'store']);


Route::get('products/search/{name}', [ProductController::class, 'search']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::resource('products', ProductController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/forgot-password', [AuthController::class, 'forgot'])->middleware('guest')->name('password.email');

Route::post('/reset-password', [AuthController::class, 'reset'])->middleware('guest')->name('password.update');
