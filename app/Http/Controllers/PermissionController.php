<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Throwable;

class PermissionController extends Controller
{
    public function list()
    {
        $result['status'] = 200;
        try {
            $permissions = Permission::get();
            $result['data'] = $permissions;
        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }
        return response()->json($result);
    }
}
