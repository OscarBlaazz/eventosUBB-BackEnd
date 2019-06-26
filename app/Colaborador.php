<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $primaryKey = 'idColaborador';
    protected $table ='colaborador';
    public $timestamps = false;
    protected $fillable = [
        'nombreColaborador', 'nombreRepresentate','telefono', 'correo', 'sitioWeb','logo', 'Evento_idEvento' 
    ];
    public function evento(){
        return $this->belongsTo('App\Evento', 'Evento_idEvento');
    }
}
