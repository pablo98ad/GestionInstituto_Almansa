<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    //
    protected $table = 'alumno';

    //para poder importar con ficheros:
    protected $fillable = ['id','nombre', 'apellidos','nombrePadre','nombreMadre','Telefono1','Telefono2','fechaNacimiento', 'Grupo_id','rutaImagen'];

    public function grupo(){
        return $this->belongsTo('App\Grupo','Grupo_id');
    }
}
