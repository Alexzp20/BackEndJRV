<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocSolicitud;
use Illuminate\Http\Request;

class DocSolicitudController extends Controller
{
    //
    public function descargar($id){

        $doc = DocSolicitud::findOrFail($id);

        $ruta = storage_path($doc->path);

        if(file_exists($ruta)){
            return response()->download($ruta,$doc->name);
        }else{
            return response()->json(['error' => 'El archivo no existe'], 404);
        }

    }
}
