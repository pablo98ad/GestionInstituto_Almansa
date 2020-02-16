<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    //
    protected $table = 'reservas';
    
    public function profesor(){
        return $this->belongsTo('App\Profesor','profesor_id');
    }
    public function aula(){
        return $this->belongsTo('App\Aula','aula_id');
    }
}
