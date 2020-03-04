<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ausencias extends Model
{
    //
    protected $table = 'ausencias';

    public function profesor(){
        return $this->belongsTo('App\Profesor','profesor_id');
    }

    public function profesor_sustituye(){
        return $this->belongsTo('App\Profesor','profesor_sustituye_id');
    }
}
