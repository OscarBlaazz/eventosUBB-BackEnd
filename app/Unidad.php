<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $primaryKey = 'idUnidad';
    public $timestamps = false;
    protected $table ='unidad';
    protected $fillable = [
        'nombreUnidad', 'logoUnidad', 'sede'
    ];

    public function persona(){
        return $this->hasMany('App\User');
    }
}
