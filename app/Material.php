<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $primaryKey = 'idMaterial';
    protected $table = 'material';

     public function evento (){
        return $this->belongsTo('App\Evento', 'Evento_idEvento');
    }
}
