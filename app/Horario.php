<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Horario extends Model
{
    //
    protected $table = 'horario';
    // para poder importar por fichero
    protected $fillable = ['profesor_id', 'aula_id','grupo_id','materia_id', 'observaciones', 'esProfesor', 'dia', 'hora'];

    public function profesor(){
        return $this->belongsTo('App\Profesor','profesor_id');//muchos - uno | 1 parametro el modelo, 2º parametro la clave
    }
    public function grupo(){
        return $this->belongsTo('App\Grupo','grupo_id');
    }
    public function aula(){
        return $this->belongsTo('App\Aula','aula_id');
    }
    public function materia(){
        return $this->belongsTo('App\Materia','materia_id');
    }
}
