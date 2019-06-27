<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $primaryKey = 'idPerfil';
    public $timestamps = false;
    protected $table ='perfil';
    protected $fillable = [
        'nombrePerfil'
    ];

      //Relacion de uno a muchos
      public function evento(){
        return $this->hasMany('App\Evento');
    }
}
