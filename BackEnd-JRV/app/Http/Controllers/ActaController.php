<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActaRequest;
use App\Models\Acta;
use Illuminate\Http\Request;

class ActaController extends Controller
{
    //
    public function index(){
        $actas = Acta::all();
        return $actas;
    }

    public function create(CreateActaRequest $request){
        
        $fileName = $request->codigoActa.time().'.'.$request->documentoActa->extension();
        $request->documentoActa->storeAs('actas',$fileName);

        $acta = new Acta;
        $acta->codigo = $request->codigoActa;
        $acta->path = 'app/actas/'.$fileName;
        $acta->save();

        return response()->json(['acta'=>$acta],201);
    }

    public function update(CreateActaRequest $request){
        $acta = Acta::findOrFail($request->id);
        
        $fileName = $request->codigoActa.time().'.'.$request->documentoActa->extension();
        $request->documentoActa->storeAs('actas',$fileName);

        $acta->codigo = $request->codigoActa;
        $acta->path = 'app/actas/'.$fileName;
        $acta->save();
    }

    public function destroy(Request $request){
        
        Acta::destroy($request->id);
        return response()->json("Acta eliminada");
    }

}
