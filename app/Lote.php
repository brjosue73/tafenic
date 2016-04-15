<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';
   	protected $fillable = ['lote','id_finca'];

   	public function finca(){
   		return $this->belongsTo('App\Finca'.'id_finca');
   	}
   	
   	public function preplanilla(){
   		return $this->hasMany('App\Preplanillla');
   	}

}
