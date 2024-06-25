<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'afavor',
        'contra',
        'abstencion',
        'total',
        'solicitud_id'
    ];

    public function solicitud(){
        return $this->belongsTo(Solicitud::class);
    }
}
