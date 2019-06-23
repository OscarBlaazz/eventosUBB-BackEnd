<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    protected $primaryKey = 'idJornada';
    protected $table = 'jornada';
    public $timestamps = false;

    public function actividad (){
        return $this->hasMany('App\Actividad');
    }

    public function evento (){
        return $this->belongsTo('App\Evento', 'Evento_idEvento');
    }
    
}
