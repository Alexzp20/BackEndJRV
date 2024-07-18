<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;

    public function agenda(){
        return $this->belongsTo(Agenda::class);
    }

    public function remite(){
        return $this->belongsTo(RemitenteInforme::class, 'remitente');
    }
}
