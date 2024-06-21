<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAcuerdoRequest;
use App\Models\Acuerdo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcuerdoController extends Controller
{
    //
    public function index() {
        $acuerdos = Acuerdo::all();
        return $acuerdos;
    }

    public function create (CreateAcuerdoRequest $request){

        $fileName = $request->codigoAcuerdo.time().'.'.$request->documentoAcuerdo->extension();
        $request->documentoAcuerdo->storeAs('acuerdos',$fileName);

        $acuerdo = new Acuerdo;
        $acuerdo->codigo = $request->codigoAcuerdo;
        $acuerdo->path = 'acuerdos/'.$fileName;
        $acuerdo->solicitud_id = $request->solicitud;
        $acuerdo->save();

        return response()->json(['acuerdo'=>$acuerdo]);
    }

    public function destroy($id){

        try {
            $acuerdo = Acuerdo::findOrFail($id);
            $ruta = $acuerdo->path;
    
            $acuerdo->delete();
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            return response()->json(['message' => 'Acuerdo eliminado'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El acuerdo no existe'], 404);
        }
    }

    public function descargar($id){
        try {
            $acuerdo = Acuerdo::findOrFail($id);
            $ruta = $acuerdo->path;
            if (Storage::exists($ruta)) {
                return Storage::download($ruta);
            } else {
                return response()->json(['error' => 'No se encontro el archivo'], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El acuerdo no existe'], 404);
        }
    }
}
