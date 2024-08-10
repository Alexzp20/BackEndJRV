<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'codigo',
        'descripcion',
        'categoria_id',
        'subcategoria_id',
        'estado_id',
        'comentario_revision',
        'comentario_estado',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categoria (){
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria (){
        return $this->belongsTo(Subcategoria::class);
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
        return $this->belongsToMany(Agenda::class)->using(AgendaSolicitud::class)->withPivot('estado_id');
    }
}
