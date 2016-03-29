<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    protected $table = 'labores';
   	protected $fillable = ['nombre','id_actividad'];

   	public function actividad(){
   		return $this->belongsTo('App\Actividad','id_actividad');
   	}
}
