<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;

class AgendaController extends Controller
{
    //
    public function index(){

        $agenda = Agenda::all();
        return response()->json($agenda);
    }

    public function store(Request $request){

        $agenda = new Agenda();
        $agenda->numero = $request->numero;
        $agenda->convoca = $request->convoca;
        $agenda->fecha = $request->fecha;
        $agenda->lugar = $request->lugar;
        $agenda->primera_convocatoria = $request->primera_convocatoria;
        $agenda->segunda_convocatoria = $request->segunda_convocatoria;
        $agenda->hora_inicio = $request->hora_inicio;
        $agenda->hora_finalizacion = $request->hora_finalizacion;

        $agenda->save();

        $solicitudes = $request->solicitudes;
        $agenda->solicitudes()->attach($solicitudes);

        return response()->json($agenda,201);

    }

    public function show(Request $request){

        //$agenda = Agenda::with('solicitudes')->where('id', $request->id)->get();
        

        $agenda = Agenda::findOrFail($request->id);

        $solicitudes = $agenda->solicitudes;

        $solicitudesAgrupadas = $solicitudes->groupBy(function ($solicitud) {
            return $solicitud->categoria . '_' . $solicitud->subcategoria;
        });

        //$solicitudesArray = $solicitudesAgrupadas->map(function($solicitudes){
            //return $solicitudes->toArray();
        //})->toArray();

        $solicitudesArray = [];
        foreach ($solicitudesAgrupadas as $key => $solicitudes){
            list($categoria,$subcategoria) = explode('_',$key);
            $solicitudesArray[$categoria][$subcategoria][] = $solicitudes->toArray();
        }

        return response()->json(['solicitudes' => $solicitudesArray]);
    }


}
