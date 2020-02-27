<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    //
    protected $table = 'alumno';

    public function grupo(){
        return $this->belongsTo('App\Grupo','Grupo_id');
    }
}
