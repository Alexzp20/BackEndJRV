<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function index(){
        $categorias = Categoria::with('subcategorias')->get();
        return response()->json($categorias);
    }

    public function store(Request $request){
        $categoria = new Categoria();
        $categoria->name = $request->name;
        $categoria->save();
        return $categoria;
    }
  
}
