<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subcategoria = Subcategoria::all();
        return $subcategoria;
    }

    public function categoria(Request $request)
    {
        $categoria = $request->query('categoria_id');
        $subcategorias = Subcategoria::where('categoria_id',$categoria)->get();
        return response()->json($subcategorias);
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
        //
        $subcategoria = new Subcategoria();
        $subcategoria->name = $request->name;
        $subcategoria->categoria_id = $request->categoria_id;
        $subcategoria->save();
        return $subcategoria;
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
