<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //public function rol(){
        //return $this->belongsTo('App\Models\Rol');
    //}
    public function solicitudes(){
        return $this->hasMany(Solicitud::class);
    }

    public function puesto(){
        return $this->belongsTo(Puesto::class);
    }

    //Relacion de muchos a muchos con la tabla agendas
    public function agendas(){
        return $this->belongsToMany(Agenda::class)->withPivot('asistencia','quarum','tipo_asistente','hora','invitado');
    }

    public function rutas(){
        return $this->belongsToMany(Ruta::class);
    }

    public function scopeActive($query){
        return $query->where('activo', true);
    }

}
