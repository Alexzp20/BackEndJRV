<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAcuerdoRequest;
use App\Http\Requests\UpdateAcuerdoRequest;
use App\Models\Acuerdo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Solicitud;
use App\Mail\Notificacion; 
use Illuminate\Support\Facades\Mail;


class AcuerdoController extends Controller
{   
    function __construct()
    {
        $this->middleware('permission:crear Acuerdo',['only'=>['create']]);
        $this->middleware('permission:actualizar Acuerdo',['only'=>['update']]);
        $this->middleware('permission:borrar Acuerdo',['only'=>['destroy']]);
        $this->middleware('permission:descargar Acuerdo',['only'=>['descargar']]);
    }
    //
    public function index() {
        $acuerdos = Acuerdo::with('solicitud')->orderBy('created_at','desc')->get();
        return response()->json($acuerdos->map(function($acuerdo){
            return[
                'id_solicitud'=>$acuerdo->solicitud->id,
                'codigo_solicitud'=>$acuerdo->solicitud->codigo,
                'descripcion'=>$acuerdo->solicitud->descripcion,
                'codigo_acuerdo'=>$acuerdo->codigo,
                'id_acuerdo'=>$acuerdo->id
            ];
        }));
        //return $acuerdos
    }

    public function create (CreateAcuerdoRequest $request){

        

        $fileName = $request->codigoAcuerdo.time().'.'.$request->documentoAcuerdo->extension();
        $request->documentoAcuerdo->storeAs('acuerdos',$fileName);

        $acuerdo = new Acuerdo;
        $acuerdo->codigo = $request->codigoAcuerdo;
        $acuerdo->path = 'acuerdos/'.$fileName;
        $acuerdo->solicitud_id = $request->solicitud;
        $acuerdo->save();
    
        /*$sol = Solicitud::with('user')->findOrFail($acuerdo->solicitud_id);
        Mail::to($sol->user->email)->send(new Notificacion($sol->user->name,'emails.emailAprobado'));*/
        return response()->json(['acuerdo'=>$acuerdo]);

    }

    public function update(UpdateAcuerdoRequest $request){

        $acuerdo = Acuerdo::findOrFail($request->id);
        if($request->documentoAcuerdo == null){
            $acuerdo->codigo = $request->codigoAcuerdo;
            $acuerdo->solicitud_id = $request->solicitud;
            $acuerdo->save();
        } else{
          Storage::delete($acuerdo->path);
          $fileName = $request->codigoAcuerdo.time().'.'.$request->documentoAcuerdo->extension();
          $request->documentoAcuerdo->storeAs('acuerdos',$fileName);
          $acuerdo->codigo = $request->codigoAcuerdo;
          $acuerdo->path = 'acuerdos/'.$fileName;
          $acuerdo->solicitud_id = $request->solicitud;
          $acuerdo->save();
        }

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
