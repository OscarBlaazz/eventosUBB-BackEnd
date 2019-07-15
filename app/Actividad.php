<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Actividad extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idActividad';
    protected $table = 'actividad';
    protected $dates = ['deleted_at'];
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
