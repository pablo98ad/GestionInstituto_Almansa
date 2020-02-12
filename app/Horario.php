<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Horario extends Model
{
    //
    protected $table = 'horario';

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
