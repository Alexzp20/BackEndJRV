<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $solicitud->estado_revision_id = $request->estado_revision_id;
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
