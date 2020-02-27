<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    //
    protected $table = 'materia';
    
    public function horarios(){
        return $this->hasMany('App\Horario','materia_id');
    }
}
