<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';

    public function persona(){
        return $this->hasMany('App\Persona');
    }
}
