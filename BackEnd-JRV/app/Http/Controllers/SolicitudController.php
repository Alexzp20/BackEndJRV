<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevisionSolRequest;
use App\Http\Requests\StoreSolicitudRequest;
use App\Models\Solicitud;
use App\Models\DocSolicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:revisar solicitud',['only'=>['revision']]);
    }


    public function index()
    {

        $solicitudes = Solicitud::with('categoria','subcategoria','estado')->get();

        return response()->json($solicitudes->map(function($solicitud){
            return[
                'id'=> $solicitud->id,
                'codigo'=>$solicitud->codigo,
                'descripcion'=>$solicitud->descripcion,
                'categoria'=>$solicitud->categoria->name,
                'subcategoria'=>$solicitud->subcategoria ? $solicitud->subcategoria->name :null,
                'estado'=>$solicitud->estado->name,
                'creado'=>$solicitud->created_at
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
    public function indexEstado(Request $request){
        
        $solicitudes = Solicitud::with('documentos','categoria','subcategoria')->where('estado_id', $request->id)->get();
        return response()->json($solicitudes);
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
        $doc->path = 'app/solicitudes/' .$fileName;
        $doc->solicitud_id = $solicitud->id;
        $doc->save();

        return [$solicitud,$doc];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    }
}
