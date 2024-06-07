<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInformeRequest;
use App\Models\Informe;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    //
    public function index(){
        $informes = Informe::all();
        return $informes;
    }

    public function informeAsignar(){
        $informes = Informe::where('agenda_id',null)->get();
        return response()->json($informes);
    }

    public function create(CreateInformeRequest $request){

        $fileName = $request->codigoInforme.time().'.'.$request->documentoInforme->extension();
        $request->documentoInforme->storeAs('informes',$fileName);

        $informe = new Informe();
        $informe->codigo = $request->codigoInforme;
        $informe->path = 'app/informes/'.$fileName;
        $informe->save();

        return response()->json(['informe'=>$informe],201);
    }

    public function update(Request $request){
        $informe = Informe::find($request->id);

        $fileName = $request->codigoInforme.time().'.'.$request->documentoInforme->extension();
        $request->documentoInforme->storeAs('informe',$fileName);

        $informe->codigo = $request->codigoInforme;
        $informe->path = 'app/informe/'.$fileName;
        $informe->save();

        return response()->json(['informe'=>$informe],201);
    }

    public function destroy(Request $request){
        $informe = Informe::find($request->id);

        if(!$informe){
            return response()->json("El informe no existe");
        }
        $informe->delete();
        return response()->json("Informe Eliminado");
    }
 
}
