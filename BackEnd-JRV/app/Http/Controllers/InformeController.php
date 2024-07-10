<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInformeRequest;
use App\Http\Requests\UpdateInformeRequest;
use App\Models\Informe;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crear informes',['only'=>['create']]);
        $this->middleware('permission:actualizar informes',['only'=>['update']]);
        $this->middleware('permission:borrar informes',['only'=>['destroy']]);
        $this->middleware('permission:asignar informes',['only'=>['informeAsignar']]);
        $this->middleware('permission:mostrar informes',['only'=>['index']]);
        $this->middleware('permission:descargar informes',['only'=>['descargar']]);
    }
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
        $informe->path = 'informes/'.$fileName;
        $informe->save();

        return response()->json(['informe'=>$informe],201);
    }

    public function update(UpdateInformeRequest $request){
        $informe = Informe::find($request->id);
        if($request->documentoInforme == null){
            $informe->codigo = $request->codigoInforme;
            $informe->save();
        }else{
            Storage::delete($informe->path);
            $fileName = $request->codigoInforme.time().'.'.$request->documentoInforme->extension();
            $request->documentoInforme->storeAs('informes',$fileName);
            $informe->codigo = $request->codigoInforme;
            $informe->path = 'informe/'.$fileName;
            $informe->save();
        }
        return response()->json(['informe'=>$informe],201);
    }

    public function destroy($id){
        
        try {
            $info = Informe::findOrFail($id);
            $ruta = $info->path;
    
            $info->delete();
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            return response()->json(['message' => 'Informe eliminado'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El informe no existe'], 404);
        }
    }

    public function descargar($id) {
        try {
            $info = Informe::findOrFail($id);
            $ruta = $info->path;
            if (Storage::exists($ruta)) {
                return Storage::download($ruta);
            } else {
                return response()->json(['error' => 'El archivo no existe'], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El informe no existe'], 404);
        }
    }
 
}
