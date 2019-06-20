<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expositor extends Model
{
    protected $table = 'expositor';

    public function actividad(){
        return $this->hasMany('App\Actividad');
    }
}
