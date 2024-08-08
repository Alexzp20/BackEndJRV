<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Notificacion; 
use Illuminate\Support\Facades\Mail;



class CorreoController extends Controller
{
    

    public function enviarCorreo()
    {
        Mail::to('zf17004@ues.edu.sv')->send(new Notificacion("Rodrigo"));  
        /*return response()->json([
            'message' => 'Agenda publicada'
        ], 200);*/
    }

}
