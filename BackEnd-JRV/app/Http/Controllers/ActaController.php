<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActaRequest;
use App\Models\Acta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActaController extends Controller
{
    //
    public function index(){
        $actas = Acta::all();
        return $actas;
    }

    public function actasAsignacion(){
        $actas = Acta::where('agenda_id',null)->get();
        return response()->json($actas);
    }

    public function create(CreateActaRequest $request){
        
        $fileName = $request->codigoActa.time().'.'.$request->documentoActa->extension();
        $request->documentoActa->storeAs('actas',$fileName);

        $acta = new Acta;
        $acta->codigo = $request->codigoActa;
        $acta->path = 'actas/'.$fileName;
        $acta->save();

        return response()->json(['acta'=>$acta],201);
    }

    public function update(CreateActaRequest $request){
        $acta = Acta::findOrFail($request->id);
        
        $fileName = $request->codigoActa.time().'.'.$request->documentoActa->extension();
        $request->documentoActa->storeAs('actas',$fileName);

        $acta->codigo = $request->codigoActa;
        $acta->path = 'actas/'.$fileName;
        $acta->save();

    }

    public function destroy(Request $request){
        
        try {
            $acta = Acta::findOrFail($request->id);
            $ruta = $acta->path;
    
            $acta->delete();
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            return response()->json(['message' => 'Acta eliminada'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El acta no existe'], 404);
        }
    }

    public function descargar($id) {
        try {
            $acta = Acta::findOrFail($id);
            $ruta = $acta->path;
            if (Storage::exists($ruta)) {
                return Storage::download($ruta);
            } else {
                return response()->json(['error' => 'El archivo no existe'], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El acta no existe'], 404);
        }
    }

}
