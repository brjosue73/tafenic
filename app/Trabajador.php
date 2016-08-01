<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
	protected $table = 'trabajadores';
	protected $fillable = ['nombre','apellidos','nss','cedula','celular','tipo','estado','cargo'];

    public function preplanilla(){
   		return $this->hasMany('App\Preplanillla');
   	}

}
