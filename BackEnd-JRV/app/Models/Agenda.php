<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    //relacion muchos a muchos con solicitudes
    public function solicitudes(){
        return $this->belongsToMany(Solicitud::class);
    }
}
