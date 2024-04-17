<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevisionSolRequest;
use App\Models\Solicitud;
use App\Models\DocSolicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitud = Solicitud::all();
        return $solicitud;
    }

    //Metodo para la revision de las solicitudes
    public function revision(RevisionSolRequest $request){

        $sol = Solicitud::findOrFail($request->id);
        $sol->estado_revision = $request->estado;
        $sol->comentario_revision = $request->comentario;
        $sol->save();

        $message = $request->estado ? 'Solicitud aprobada' : 'Solicitud denegada';

        return response()->json($message,200);
    }


    //Metodo para enviar todas las solicitudes pendientes de revision
    public function indexRevision(){
        
        $solicitudes = Solicitud::with('documentos')->whereNull('estado_revision_id')->get();
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
    public function store(Request $request)
    {
        $fileName = time().'.'.$request->file->extension();
        //
        $solicitud = new Solicitud();
        $solicitud->descripcion = $request->descripcion;
        $solicitud->categoria_id = $request->categoria_id;
        $solicitud->subcategoria_id = $request->subcategoria_id;
        $solicitud->save();

        $request->file->storeAs('solicitudes',$fileName);
        $doc = new DocSolicitud;
        $doc->name = $request->name;
        $doc->path = $fileName;
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
