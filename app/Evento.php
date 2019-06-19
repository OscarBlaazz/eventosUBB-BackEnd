<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table ="evento";
    protected $fillable =['nombre','ubicacion','direccion','detalles','imagen','capacidad'];
}
