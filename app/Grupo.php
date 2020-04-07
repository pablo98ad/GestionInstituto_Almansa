<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupo';
    protected $fillable = ['nombre', 'descripcion','nombreTutor','curso'];

    //
    public function horarios(){
        return $this->hasMany('App\Horario','grupo_id');
    }
    public function alumnos(){
        return $this->hasMany('App\Alumno','grupo_id');
    }
}
