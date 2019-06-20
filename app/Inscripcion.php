<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table='inscripcion';

    public function evento (){
        return $this->belongsTo('App\Evento', 'Evento_idEvento');
    }
    public function persona (){
        return $this->belongsTo('App\Persona', 'Persona_idPersona');
    }

}
