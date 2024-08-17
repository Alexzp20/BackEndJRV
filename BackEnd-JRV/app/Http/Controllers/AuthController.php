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
            $user = User::active()->with('roles:id,name','puesto.rutas:id,ruta,titulo,ruta_imagen')->where('email',$request['email'])->firstOrFail();
            $userDatos = [
                'id'=>$user->id,
                'username'=>$user->username,
                'name'=>$user->name,
                'apellido'=>$user->apellido,
                'email'=>$user->email,
                'puesto_id'=>$user->puesto_id,
                'roles'=>$user->roles->map(function($role){
                    return [
                        'id'=>$role->id,
                        'name'=>$role->name
                    ];
                })
            ];
            $rutasPuesto = $user->puesto->rutas;

            $token = $user->createToken('auth_token')->plainTextToken;

            return response(["token"=>$token, 'rutas'=>$rutasPuesto, 'user'=>$userDatos], 200);
        } else {
            return response('No se pudo logear', 401);
        }
    }

    public function logout(){
        
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada'], 200);   

        }
    }
