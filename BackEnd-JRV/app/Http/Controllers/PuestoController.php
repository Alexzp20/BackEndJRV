<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puesto;

class PuestoController extends Controller
{   
    function __construct()
    {
        $this->middleware('permission:mostrar Puesto',['only'=>['index']]);
    }
    //
    public function index(){

        $puestos = Puesto::all();
        return $puestos;
    }

    public function store(Request $request)
    {
        //
        $puesto = new Puesto();
        $puesto->name =$request->PUESTO;
        $puesto->save();        
    }

    public function update(Request $request)
    {
        //
        $puesto = Puesto::findOrFail($request->id);
        $puesto->name = $request->PUESTO;
        $puesto->save();
        return $puesto;
    }

    public function destroy(Request $request)
    {
        //
        $puesto = Puesto::destroy($request->id);
        return $puesto;
    }
}
