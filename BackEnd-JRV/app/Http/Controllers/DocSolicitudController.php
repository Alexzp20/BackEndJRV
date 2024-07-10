<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocSolicitud;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocSolicitudController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:descargar solicitud',['only'=>['descargar']]);
    }
    //
    public function descargar($id){

        try{
            $doc = DocSolicitud::findOrFail($id);
            $ruta = $doc->path;
            if(Storage::exists($ruta)){
                return Storage::download($ruta);
            } else {
                return response()->json(['error' => 'El archivo no existe'], 404);
            }
        } catch(ModelNotFoundException $e){
            return response()->json(['error' => 'El documento no existe'], 404);
        }
    }
}
