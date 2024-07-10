<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crear Rol',['only'=>['index']]);
    }
    //
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
