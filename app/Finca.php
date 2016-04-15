<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{
    protected $table = 'fincas';
   	protected $fillable = ['nombre','estado'];
   	public function actividades (){
   		return $this->hasMany('App\Actividad');
   	}
   	public function lotes (){
   		return $this->hasMany('App\Lotes');
   	}
   	public function preplanilla(){
   		return $this->hasMany('App\Preplanillla');
   	}
}
