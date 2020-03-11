<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    //
    protected $table = 'materia';
    
     //para poder importar con ficheros:
     protected $fillable = ['id','nombre', 'departamento','observaciones'];


    public function horarios(){
        return $this->hasMany('App\Horario','materia_id');
    }
}
