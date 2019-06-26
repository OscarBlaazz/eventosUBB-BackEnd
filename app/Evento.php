<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $primaryKey = 'idEvento';
    public $timestamps = false;
    protected $table ='evento';
    protected $fillable = [
        'nombreEvento', 'ubicacion','direccion', 'detalles', 'imagen','capacidad'
    ];

     //Relacion de uno a muchos
     public function material(){
        return $this->hasMany('App\Material');
    }

    public function colaborador(){
        return $this->hasMany('App\Colaborador');
    }

    public function persona(){
        return $this->hasMany('App\Persona');
    }

    public function inscripcion(){
        return $this->hasMany('App\Inscripcion');
    }

    public function jornada(){
        return $this->hasMany('App\Jornada');
    }
}
