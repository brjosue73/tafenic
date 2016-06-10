<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Quincenal;
use App\Variable;

class QuincenalesController extends Controller
{
    public function g_quincenal(Request $request){
      $variables=Variable::all();
      foreach ($variables as $variable) {
        $inss_admin=$variable->inss_admin;

      }

      $peticion = $request->all();
      $arreglo = $peticion;

      $planilla = new Quincenal($arreglo);
      $dias_trab=$arreglo['dias_trab'];
      $salario_quinc=$arreglo['salario_quinc'];
      $salario_dia=$salario_quinc/15;
      $sal_hora=$salario_dia/8;
      $basico=$dias_trab*$salario_quinc;//menos los feriados y los subsidios, porque ya hay una caja de texto


      $feriados1=$arreglo['feriado_trab'];//cuenta en los dias trab + valor del feriado
      $feriados2=$arreglo['feriado_ntrab'];//no cuenta como dia trabajado
      $feriados=$feriados1+$feriados2;
      $feriado_tot=$feriados*$salario_dia;
      $planilla->feriados=$feriado_tot;
      $otros=$arreglo['otros'];
      $subsi=$arreglo['subsidios'];
      $tot_sub=$subsi*$salario_dia;
      $horas_ext=$arreglo['horas_ext'];
      $tot_h_ext=$horas_ext*($sal_hora*2);
      $planilla->tot_h_ext=$tot_h_ext;
      $devengado=$basico+$feriados+$otros+$subsi+$tot_h_ext;
      $inss_lab=($devengado-$subsi)*$inss_admin;
      $planilla->inss_laboral=$inss_lab;
      $IR=0;/*****************************FALTA CALCULAR IR**********************************************/
      $prestamo=$arreglo['prestamos'];
      $total_pagar=$devengado-$inss_lab-$IR-$prestamo;
      $inss_patronal=$devengado*18;
      $inatec=(($devengado-$subsi)*2);
      $planilla->total_pagar=$total_pagar;
      $planilla->inss_patronal=$inss_patronal;
      $planilla->inatec=$inatec;


      $planilla->save();
      return "Planilla Almacenada";
    }
}
