<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $primaryKey = 'idRol';
    public $timestamps = false;
    protected $table ='rol';
    protected $fillable = [
        'nombreRol'
    ];

    public function persona(){
        return $this->hasMany('App\Evento_users');
    }
}
