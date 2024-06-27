<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    public function categoria (){
        return $this->belongsTo('App\Models\categoria');
    }

    public function subcategoria (){
        return $this->belongsTo('App\Models\subcategoria');
    }

    public function documentos (){
        return $this->hasMany(DocSolicitud::class);
    }

    public function acuerdos (){
        return $this->hasMany(Acuerdo::class);
    }

    public function estado (){
        return $this->belongsTo(Estado::class);
    }

    public function votacion(){
        return $this->hasOne(Votacion::class);
    }

    //Relacion muchos a muchos con agenda

    public function agendas(){
        return $this->belongsToMany(Agenda::class);
    }
}
