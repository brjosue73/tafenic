<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quincenal extends Model
{
    protected $table = 'quincenales';
    protected $fillable = ['tipo','dias_trab','id_finca','id_trabajador','horas_extra','otros','feriados','subsidios','prestamos','fecha_ini','fecha_fin']
    
}
