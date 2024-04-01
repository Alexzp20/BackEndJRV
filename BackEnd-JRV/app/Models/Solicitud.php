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
}
