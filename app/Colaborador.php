<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $primaryKey = 'idColaborador';
    protected $table ='colaborador';
      
    public function evento(){
        return $this->belongsTo('App\Evento', 'Evento_idEvento');
    }
}
