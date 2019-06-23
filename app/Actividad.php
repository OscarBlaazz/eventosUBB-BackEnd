<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $primaryKey = 'idActividad';
    protected $table = 'actividad';
    public $timestamps = false;

    public function expositor (){
        return $this->belongsTo('App\Expositor', 'Expositor_idExpositor');
    }

    public function jornada(){
        return $this->belongsTo('App\Jornada', 'Jornada_idJornada');
    }
}
