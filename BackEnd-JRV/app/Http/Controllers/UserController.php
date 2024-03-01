<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index(){

        $users = User::all();
        return $users;
            
    }

    public function show(Request $request){
        $user = User::findOrFail($request->id);
        return $user;

    }

    public function store(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->cv = $request->cv;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->carnet = $request->carnet;
        $user->puesto_id = $request->puesto_id;
        $user->rol_id = $request->rol_id;

        $user->save();
    }

    public function update(Request $request){

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->pasword;
        $user->cv = $request->cv;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->carnet = $request->carnet;
        $user->puesto_id = $request->puesto_id;
        $user->rol_id = $request->rol_id;

        $user->save();
        return $user;
    }

    public function destroy(Request $request){
        $user = User::destroy($request->id);
        return $user;
    }
}
