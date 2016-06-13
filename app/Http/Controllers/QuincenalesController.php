<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Quincenal;
use App\Variable;

class QuincenalesController extends Controller
{
    public function quincenal_fecha(Request $request){
      $peticion=$request->all();
      //return $peticion;
       $data =$this->calculo_planilla($peticion);
       return $data;
    }
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
      $finca=$arreglo['id_finc'];
      $planilla->id_finc=$finca;
      $salario_dia=$salario_quinc/15;
      $planilla->basico=$salario_quinc;
      $sal_hora=$salario_dia/8;
      $basico=$dias_trab*$salario_dia;//menos los feriados y los subsidios, porque ya hay una caja de texto


      $feriados1=$arreglo['feriado_trab'];//cuenta en los dias trab + valor del feriado
      $feriados2=$arreglo['feriado_ntrab'];//no cuenta como dia trabajado
      $feriados=$feriados1+$feriados2;
      $feriado_tot=$feriados*$salario_dia;
      $planilla->feriados=$feriado_tot;
      $otros=$arreglo['otros'];
      $subsi=$arreglo['subsidios'];
      $tot_sub=$subsi*$salario_dia;
      $horas_ext=$arreglo['horas_ext'];
      $planilla->horas_extra=$horas_ext;
      $tot_h_ext=$horas_ext*($sal_hora*2);
      $planilla->tot_h_ext=$tot_h_ext;

      $devengado=$basico+$feriados+$otros+$subsi+$tot_h_ext;
      //return 'basico'.$basico.'feria'.$feriados.'otros'.$otros.'subs'.$subsi.'hext'.$tot_h_ext;
      $planilla->devengado=$devengado;
      $inss_lab=(($devengado-$subsi)*$inss_admin)/100;
      $planilla->inss_laboral=$inss_lab;
      $IR=0;/*****************************FALTA CALCULAR IR**********************************************/
      $prestamo=$arreglo['prestamos'];
      $total_pagar=$devengado-$inss_lab-$IR-$prestamo;
      $inss_patronal=($devengado*18)/100;
      $inatec=(($devengado-$subsi)*2)/100;
      $planilla->total_pagar=$total_pagar;
      $planilla->inss_patronal=$inss_patronal;
      $planilla->inatec=$inatec;

      $planilla->save();

      //return $planilla;
      return "Planilla Almacenada";
    }
    public function reporte_quincenal(Request $request){
      $peticion=$request->all();

      $data =$this->planilla_quincenal($peticion);

      $view = \View::make('reporte_quincenal',array('data'=>$data));
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      $pdf->setPaper('legal', 'landscape');
      return $pdf->stream('invoice');
      return $pdf->stream();
    }

    public function planilla_quincenal($peticion){
      //RETORNAR la planilla de quincenales
      // $peticion = $request->all();
      // $fecha_ini=$peticion['fecha_ini'];
      // $fecha_fin=$peticion['fecha_fin'];
      $fecha_ini='2016-06-10';
      $fecha_fin='2016-06-25';
      $planilla=Quincenal::whereBetween('fecha_ini', [$fecha_ini, $fecha_fin])
                ->whereBetween('fecha_fin', [$fecha_ini, $fecha_fin])
                ->get();
      return response()->json($planilla);

    }
}
