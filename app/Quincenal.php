<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quincenal extends Model
{
    protected $table = 'quincenales';
    protected $fillable = ['tipo','inatec','inss_patronal','feriado_trab','salario_quinc','feriado_ntrab','devengado','dias_trab','basico','total_pagar','tot_h_ext','ir','dias_falt','inss_laboral','id_finca','id_trabajador','horas_extra','otros','feriados','subsidios','prestamos','fecha_ini','fecha_fin'];
}
