<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'convoca',
        'fecha',
        'lugar',
        'primera_convocatoria',
        'segunda_convocatoria',
        'hora_inicio',
        'tipoConvocatoria',
        'hora_finalizacion'
    ];
    
    
    //relacion muchos a muchos con solicitudes
    public function solicitudes(){
        return $this->belongsToMany(Solicitud::class);
    }

    //Relacion de muchos a muchos con la tabla agendas
    public function users(){
        return $this->belongsToMany(User::class)->withPivot('asistencia','quarum','tipo_asistente','hora','invitado');
    }

    public function actas(){
        return $this->hasMany(Acta::class);
    }

    public function informes(){
        return $this->hasMany(Informe::class);
    }
}
