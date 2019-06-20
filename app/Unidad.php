<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidad';

    public function persona(){
        return $this->hasMany('App\Persona');
    }
}
