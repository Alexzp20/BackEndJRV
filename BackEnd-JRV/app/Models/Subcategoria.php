<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    use HasFactory;

    public function categoria(){
        return $this->belongsTo('App\Models\categoria');
    }

    public function solicitudes(){
        return $this->hasMany('App\Models\solicitud');
    }
}
