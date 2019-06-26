<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $primaryKey = 'idCiudad';
    public $timestamps = false;
    protected $table ='ciudad';

    public function ciudad(){
        return $this->hasMany('App\Evento');
    }
}
