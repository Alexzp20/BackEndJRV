<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AgendaSolicitud extends Pivot
{
    use HasFactory;

    protected $table = 'agenda_solicitud';

    protected $fillable = [
        'solicitud_id',
        'agenda_id',
        'estado_id'
    ];

    public function estado(){
        return $this->belongsTo(Estado::class);
    }
}
