<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Quincenal

class QuincenalesController extends Controller
{
    public function quincenal(){
      $peticion = $request->all();
      $arreglo = $peticion["data"];

      $planilla = new Quincenal($arreglo);
      $dias_trab=$arreglo['dias_trab'];
      $salario_quinc=$arreglo['salario_quinc'];
      $salario_dia=$salario_quinc/15;
      $sal_hora=$salario_dia/8;
      $basico=$dias_trab*$salario_quinc;//menos los feriados y los subsidios, porque ya hay una caja de texto


      $feriados1=$arreglo['feriado_trab'];//restarselo a los dias trabajados si no es trabajado
      $feriados2=$arreglo['feriado_ntrab'];//cuenta como dia trabajado
      $feriados=$feriados1+$feriados2;
      $feriado_tot=$feriados*$salario_dia;
      $planilla->feriado=$feriado_tot;
      $otros=$arreglo['otros'];
      $subsidos=$arreglo['subsidos'];
      $horas_ext=$arreglo['horas_ext'];
      $tot_h_ext=$horas_ext*($sal_hora*2);
      $planilla->tot_h_ext=$tot_h_ext;


      $planilla->save();
      return "Planilla Almacenada";
    }
}
