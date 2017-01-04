<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preplanilla extends Model
{
	protected $table = 'preplanillas';
	protected $fillable = ['id_trabajador','id_finca','otros','feriados','centro_costo','subsidios','id_actividad','id_labor','fecha','id_lote','id_listero','id_respFinca','hora_trab','hora_ext','cuje_ext','cant_cujes','salario_dev','alimentacion','vacaciones','aguinaldo','salario_acum','total_extras','tamano_cuje','prestamo', 'septimo'];


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
