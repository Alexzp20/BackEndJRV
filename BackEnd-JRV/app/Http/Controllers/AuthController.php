<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(LoginRequest $request){
        

        if (Auth::attempt($request->only('email','password'))){
            $user = User::where('email',$request['email'])->firstOrFail();
            $token = $user->createToken('token')->plainTextToken;

            return response(["token"=>$token], 200);
        } else {
            return response('No se pudo logear', 401);
        }
    }
}
