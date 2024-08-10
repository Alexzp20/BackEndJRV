<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:mostrar Usuarios',['only'=>['index']]);
        $this->middleware('permission:mostrar UsuAsistencia',['only'=>['usersAsistencia']]);
        $this->middleware('permission:mostrar Puesto',['only'=>['puesto']]);
        $this->middleware('permission:mostrar idUsuario',['only'=>['show']]);
        $this->middleware('permission:crear usuario',['only'=>['store']]);
        $this->middleware('permission:actualizar usuario',['only'=>['update']]);
        $this->middleware('permission:borrar usuario',['only'=>['destroy']]);
    }

    public function index(){

        $users = User::all();
        return $users;
            
    }

    public function show(Request $request){
        $user = User::findOrFail($request->id);
        return $user;

    }

    public function usersAsistencia(){
        $users = User::whereIn('puesto_id',[1,2,3,4])->get();
        return $users;
    }
    
    public function puesto(Request $request){

        $puesto = $request->query('puesto_id');

        $users = User::where('puesto_id',$puesto)->get();
        return response()->json($users);
    }

    public function store(StoreUserRequest $request){
        
        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->apellido = $request->apellido;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->puesto_id = $request->puesto_id;
        $user->save();


        $this->asignarRole($request->puesto_id,$user);

        return response()->json(['user'=>$user],201);
    }

    public function update(UpdateUserRequest $request){

        $user = User::findOrFail($request->id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->apellido = $request->apellido;
        $user->email = $request->email;
        $user->password = $request->password ? $request->password: $user->password;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->puesto_id = $request->puesto_id;
        $user->save();

        $this->asignarRole($request->puesto_id,$user);

        return $user;
    }

    public function destroy(Request $request){
        $user = User::destroy($request->id);
        return $user;
    }

    private function asignarRole($puesto, $user){

        switch($puesto){
            case 1:
                $user->assignRole('Administrador');
                break;
            case 2:
                $user->assignRole('Administrador');
                break;
            case 3:
                $user->assignRole('Usuario');
                break;
            case 4:
                $user->assignRole('Administrador');
                break;
            case 5:
                $user->assignRole('Usuario');
                break;
            case 6:
                $user->assignRole('Usuario');
                break;
            case 7:
                $user->assignRole('Usuario');
                break;
            case 8:
                $user->assignRole('Usuario');
                break;
        }
    }
}
