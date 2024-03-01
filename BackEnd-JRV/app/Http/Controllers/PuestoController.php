<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puesto;

class PuestoController extends Controller
{
    //
    public function index(){

        $puestos = Puesto::all();
        return $puestos;
    }
}
