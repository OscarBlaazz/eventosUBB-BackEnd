<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $primaryKey = 'idMaterial';
    protected $table = 'material';
    public $timestamps = false;
    protected $fillable = [
        'nombreMaterial', 'fechaCreacion', 'archivo', 'evento_idEvento'
        
    ];

     public function evento (){
        return $this->belongsTo('App\Evento', 'evento_idEvento');
    }
}
