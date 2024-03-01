<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;
    protected $fillable = ['PUESTO'];

    public function users(){
        return $this->hasMany('App\Models\user');
    }
}
