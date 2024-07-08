<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoActa extends Model
{
    protected $table = 'estado_acta';
    use HasFactory;

    public function actas(){
        return $this->hasMany(Acta::class);
    }
}
