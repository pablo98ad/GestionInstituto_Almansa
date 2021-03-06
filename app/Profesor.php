<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profesor extends Model
{
    protected $table = 'profesor';
    //para poder importar con ficheros:
    protected $fillable = ['id','nombre', 'apellidos','departamento','especialidad','cargo','observaciones','codigo','rutaImagen'];


    public function horarios(){
        return $this->hasMany('App\Horario','profesor_id');
    }
    public function reservas(){
        return $this->hasMany('App\Reservas','profesor_id');
    }
    public function ausencias(){
        return $this->hasMany('App\Ausencias','profesor_id');
    }

   /* public function boot()
    {
        if(!file_exists(Storage::disk('local')->path('/').$this->rutaImagen)){
            $this->rutaImagen='default.png';
        }
    }*/
}
