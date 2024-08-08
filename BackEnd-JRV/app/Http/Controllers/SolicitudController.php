<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevisionSolRequest;
use App\Http\Requests\SolicitudEditRevisionRequest;
use App\Http\Requests\StoreSolicitudRequest;
use App\Models\Solicitud;
use App\Models\DocSolicitud;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

use App\Mail\Notificacion; 
use Illuminate\Support\Facades\Mail;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:revisar solicitud',['only'=>['revision']]);
        $this->middleware('permission:crear solicitud',['only'=>['store']]);
        $this->middleware('permission:endpoints solicitud',['only'=>['index']]);
        $this->middleware('permission:estado solicitud',['only'=>['indexEstado']]);
        $this->middleware('permission:editar Asistentes',['only'=>['editAsistentes']]);
    }


    public function index()
    {
        $solicitudes = Solicitud::with('categoria','subcategoria','estado','documentos')->where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();

        return response()->json($solicitudes->map(function($solicitud){
            return[
                'id'=> $solicitud->id,
                'codigo'=>$solicitud->codigo,
                'descripcion'=>$solicitud->descripcion,
                'categoria'=>$solicitud->categoria->name,
                'subcategoria'=>$solicitud->subcategoria ? $solicitud->subcategoria->name :null,
                'estado'=>$solicitud->estado->name,
                'creado'=>$solicitud->created_at,
                'comentario'=>$solicitud->comentario_revision,
                'documentos'=>$solicitud->documentos
            ];
        }));
    }

    //Metodo para la revision de las solicitudes
    public function revision(RevisionSolRequest $request){

        $sol = Solicitud::findOrFail($request->id);
        $sol->estado_id = $request->estado;
        $sol->comentario_revision = $request->comentario;
        $sol->save();

        $message = $request->estado == 2? 'Solicitud aprobada' : 'Solicitud denegada';

        return response()->json($message,200);
    }


    //Metodo para enviar todas las solicitudes por su estado
    public function indexEstado(string $id){
        
        $solicitudes = Solicitud::with(['documentos','categoria','subcategoria','user' => function($query) {
            $query->select('id', 'username','name','apellido','email');
        }])->where('estado_id', $id)->get();
        return $solicitudes;
    }

    public function solicitudesAsignacion(){
        $solicitudes = Solicitud::with(['documentos','categoria','subcategoria','user' => function($query) {
            $query->select('id', 'username','name','apellido','email');
        }])->whereIn('estado_id', [2,6])->get();
        return $solicitudes;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSolicitudRequest $request)
    {
        $fileName = time().'.'.$request->file->extension();
        //
        $solicitud = new Solicitud();
        $solicitud->codigo = $request->name;
        $solicitud->descripcion = $request->descripcion;
        $solicitud->categoria_id = $request->categoria_id;
        $solicitud->subcategoria_id = $request->subcategoria_id;
        $solicitud->estado_id = 1;
        $solicitud->user_id = auth()->user()->id;
        $solicitud->save();

        $request->file->storeAs('solicitudes',$fileName);
        $doc = new DocSolicitud;
        $doc->name = $request->name;
        $doc->path = 'solicitudes/' .$fileName;
        $doc->solicitud_id = $solicitud->id;
        $doc->save();
        //Mail::to('zf17004@ues.edu.sv')->send(new Notificacion("Rodrigo"));
        return [$solicitud,$doc];
        
    }

    /**
     * Display the specified resource.
     */
    public function editAsistentes(SolicitudEditRevisionRequest $request)
    {
        //
        try {
            $data = $request->validated();
            $solicitud = Solicitud::findOrFail($request->id);
            $solicitud->update($data);
            return response()->json($solicitud, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $solicitud = Solicitud::with('documentos')->findOrFail($id);
            $documentos = $solicitud->documentos;
            foreach($documentos as $documento){
                $ruta = $documento['path'];
                if(Storage::exists($ruta)){
                    Storage::delete($ruta);
                }
            }
            $solicitud->delete();
            return response()->json(['message' => 'Solicitud eliminada'], 200);
        } catch(ModelNotFoundException){
            return response()->json(['error' => 'La solicitud no existe'], 404);
        }
    }
}
