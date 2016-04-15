<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preplanilla extends Model
{
	protected $table = 'preplanillas';
       protected $fillable = ['id_trabajador','id_finca','id_actividad','id_labor','fecha','id_lote','id_listero','id_respFinca','cantidad','hora_ext','actividad_ext'];
    //
       
   	public function trabajador(){
   		return $this->belongsTo('App\Trabajador','id');
   	}
   	public function finca(){
   		return $this->belongsTo('App\Finca','id_finca');
   	}
   	
   	public function actividad(){
   		return $this->belongsTo('App\Actividad','id_actividad');
   	}
   	
   	public function labor(){
   		return $this->belongsTo('App\Labor','id_labor');
   	}   

	public function lote(){
   		return $this->belongsTo('App\Lote','id_lote');
   	} 

   	public function listero(){
   		return $this->belongsTo('App\Trabajador','id_listero');
   	}   

   	public function resp_finca(){
   		return $this->belongsTo('App\Trabajador','id_respFinca');
   	} 	


}
