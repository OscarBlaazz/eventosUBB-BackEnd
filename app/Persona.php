<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

    public function inscripcion(){
        return $this->hasMany('App\Inscripcion');
    }

    public function evento (){
        return $this->belongsTo('App\Evento', 'Evento_idEvento');
    }

    public function rol(){
        return $this->belongsTo('App\Rol' , 'Rol_idRol');
    }

    public function unidad(){
        return $this->belongsTo('App\Unidad', 'Unidad_idUnidad');
    }
}
