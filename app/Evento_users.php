<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento_users extends Model
{
    protected $primaryKey = 'idevento_users';
    public $timestamps = false;
    protected $table ='evento_users';
    protected $fillable = [
        'contadorEvento', 'evento_idEvento','rol_idRol', 'users_id'
    ];

    //Relacion de muchos a uno
    public function evento(){
        return $this->belongsTo('App\Evento', 'evento_idEvento');
    }

    //Relacion de muchos a uno
    public function rol(){
        return $this->belongsTo('App\rol', 'rol_idRol');
    }

    //Relacion de muchos a uno
    public function users(){
        return $this->belongsTo('App\User', 'users_id');
    }

}
