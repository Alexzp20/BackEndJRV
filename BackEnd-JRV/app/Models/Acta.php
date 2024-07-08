<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    use HasFactory;

    public function agenda(){
        return $this->belongsTo(Agenda::class);
    }

    public function estado(){
        return $this->belongsTo(EstadoActa::class);
    }
}
