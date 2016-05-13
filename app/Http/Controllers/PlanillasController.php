<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Finca;
use App\Preplanilla;
use App\Trabajador;

class PlanillasController extends Controller
{
    public function planilla_general(Request $request){
      $peticion = $request->all();
      //$arreglo = $peticion["data"];

      // $fecha_ini="2016-01-01";
      // $fecha_fin="2017-01-01";
      $fecha_ini= $arreglo['fecha_ini'];
      $fecha_fin= $arreglo['fecha_fin'];
      $trab=0;
      $planillas= Preplanilla::whereBetween('fecha', [$fecha_ini, $fecha_fin]) /***********Buscar en preplanilla segun el rango de fecha*************/
                              ->get();
      foreach ($planillas as $planilla) {
        $id_trab = $planilla->id_trabajador;
        if ($trab!=$id_trab) {
          $trabs= Preplanilla::where('id_trabajador',$id_trab) /*Todas las preplanillas de ese trabajador en ese rango de fecha*/
                                    ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                                    //->where('id_finca',$id_finca)
                                   ->get();
           $dias= $trabs->count();
           $salario_tot=0;
           $alim_tot=0;
           $vac_tot=0;
           $agui_tot=0;
           $extra_tot=0;
           $tot_dias=0;
           $septimo=0;
           $tot_inss=0;
           $nombre="Jon";
           $apellido="Doe";
             //  si es trabajador por labor -------Falta
             foreach ($trabs as $trab) {
                //si trabajo mas de 6 dias y menos de 11 asignar 1 septimo si trabajo 11 asignar 2 septimos
                 $salario=$trab->salario_acum;
                 $salario_tot += $salario;
                 $alim=$trab->alimentacion;
                 $alim_tot += $alim;
                 $vac= $trab->vacaciones;
                 $vac_tot += $vac;
                 $agui_tot= $vac_tot;
                 $extras=$trab->total_extras;
                 $extra_tot += $extras;
                 //diferencia si es por labor o por horas
                 $tot_inss=$salario_tot + $septimo + $extra_tot + $vac;
                 $inss= ($tot_inss*4.25)/100;
                 $salario_acum=$salario_tot + $alim + $vac + $agui_tot + $extra_tot -$inss;
             }
             //Si es trabajador de Administrativo -------Falta

             $array = [
               "id_trab"=>$id_trab,
               "dias"=>$dias,
               "salario_tot"=>$salario_tot,
               "alim_tot"=>$alim_tot,
               "vac_tot"=>$vac_tot,
               "agui_tot"=>$agui_tot,
               "extra_tot"=>$extra_tot,
               "inss"=>$inss,
               "salario_acum"=>$salario_acum,
               "nombres"=>$nombre,
               "apellidos"=>$apellido
             ];
          $trabajadores[]=$array;
          $trab=$id_trab;
        }
      }
      return $trabajadores;
    }
}
