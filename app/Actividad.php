<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $primaryKey = 'idActividad';
    protected $table = 'actividad';
    public $timestamps = false;
    protected $fillable = [
        'nombreActividad', 'horaInicioActividad', 'horaFinActividad', 'ubicacionActividad', 'descripcionActividad',
        'jornada_idJornada', 'expositor_idExpositor'
    ];
    public function expositor()
    {
        return $this->belongsTo('App\Expositor', 'expositor_idExpositor');
    }

    public function jornada()
    {
        return $this->belongsTo('App\Jornada', 'jornada_idJornada');
    }
}
