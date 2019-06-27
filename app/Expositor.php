<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expositor extends Model
{
    protected $primaryKey = 'idExpositor';
    public $timestamps = false;
    protected $table = 'expositor';
    protected $fillable = [
        'nombreExpositor', 'apellidoExpositor', 'sexo', 'correoExpositor', 'empresa',
        'foto'
    ];
    public function actividad()
    {
        return $this->hasMany('App\Actividad');
    }
}
