<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocSolicitud extends Model
{
    protected $table = 'doc_solicitudes';
    use HasFactory;

    protected $fillable =[
        'id','name','path'

    ];

    public function solicitud (){
        return $this->belongsTo(Solicitud::class);
    }
}


