<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puesto;

class PuestoController extends Controller
{
    //
    public function index(){

        $puestos = Puesto::all();
        return $puestos;
    }

    public function store(Request $request)
    {
        //
        $puesto = new Puesto();
        $puesto->PUESTO =$request->PUESTO;
        $puesto->save();        
    }

    public function update(Request $request)
    {
        //
        $puesto = Puesto::findOrFail($request->id);
        $puesto->PUESTO = $request->PUESTO;
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
