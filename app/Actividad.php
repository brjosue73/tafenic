<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
   	protected $fillable = ['nombre','id_finca'];
   	public function finca(){
   		return $this->belongsTo('App\Finca'.'id_finca');
   	}
   	public function Labors(){
   		return $this->hasMany('App\Labor');
   	}
}
