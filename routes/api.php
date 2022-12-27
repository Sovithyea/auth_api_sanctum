<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

// auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgot'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [AuthController::class, 'reset'])->middleware('guest')->name('password.update');


Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::post('/logout', [AuthController::class, 'logout']);

    //crud users
    Route::post('users-list', [UserController::class, 'list']);
    Route::post('users-create', [UserController::class, 'store']);
    Route::post('users-show', [UserController::class, 'show']);
    Route::post('users-update', [UserController::class, 'update']);
    Route::post('users-delete', [UserController::class, 'delete']);

    Route::post('roles-list', [RoleController::class, 'list']);
    Route::post('roles-create', [RoleController::class, 'store']);
    Route::post('roles-show', [RoleController::class, 'show']);
    Route::post('roles-update', [RoleController::class, 'update']);
    Route::post('roles-delete', [RoleController::class, 'delete']);

    Route::post('permissions-list', [PermissionController::class, 'list']);

    Route::post('products-list', [ProductController::class, 'list']);
    Route::post('products-create', [ProductController::class, 'store']);
    Route::post('products-show', [ProductController::class, 'show']);
    Route::post('products-update', [ProductController::class, 'update']);
    Route::post('products-delete', [ProductController::class, 'delete']);

    //auth profile
    Route::post('users', [UserController::class, 'user']);
    Route::post('update-info', [UserController::class, 'updateInfo']);
    Route::post('update-password', [UserController::class, 'updatePassword']);


});

