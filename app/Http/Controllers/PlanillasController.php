<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Finca;
use App\Preplanilla;
use App\Trabajador;
use App\Labor;
use App\Variable;

class PlanillasController extends Controller
{
    public function planilla_general(Request $request){
      $peticion = $request->all();
      //$arreglo = $peticion["data"];


      $fecha_ini="2016-01-01";
      $fecha_fin="2017-01-01";
      $cargo='tcampo';

      // $fecha_ini=$peticion['fecha_ini'];
      // $fecha_fin=$peticion['fecha_fin'];
      // $cargo=$peticion['cargo'];

      $variables=Variable::all();
      foreach ($variables as $variable) {
        $inss_camp=$variable->inss_campo;
        $alim_var=$variable->alimentacion;
        $valor_dia= $variable->sal_diario;
        $cuje_grand= $variable->cuje_grand;
        $cuje_peq= $variable->cuje_peq;
        $vacaciones= $valor_dia*($variable->vacaciones);
        $pago_dia=$variable->sal_diario;
      }

        $planillas= Preplanilla::whereBetween('fecha', [$fecha_ini, $fecha_fin]) /***********Buscar en preplanilla segun el rango de fecha*************/
                                ->get();


      //foreach ($planillas as $planilla) {
        //solo hay 3 tipos administrativo, campo y serv_tecn

      //$id_trab = $planilla->id_trabajador;
      $tamano = sizeof($planillas);
      $trabajadores=array();
      $trab=0;

        for ($i=0; $i < $tamano; $i++) {
          $id_trab=$planillas[$i]->id_trabajador;

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
                                     $horas_ext_tot=0;
                                     $cuje_ext_tot=0;
                                     $total_dev2=0;
                                     $septimo=0;
                                     $otros=0;
                                     $feriados=0;

                                     $trabajador=Trabajador::find($id_trab);
                                     $nombres=$trabajador->nombre;
                                     $apellido=$trabajador->apellidos;
                                     $nombre="$nombres   $apellido";
                                       foreach ($trabs as $trab) {
                                           $salario=$trab->salario_acum;
                                           $salario_tot += $salario;
                                           $alim=$trab->alimentacion;
                                           $alim_tot += $alim;
                                           $vac= $trab->vacaciones;
                                           $vac_tot += $vac;
                                           $agui_tot= $vac_tot;
                                           $horas_ext_tot +=$trab->hora_ext;
                                           $cuje_ext_tot +=$trab->cuje_ext;
                                           $extras=$trab->total_extras;
                                           $extra_tot += $extras;
                                           $lab_query=Labor::find($trab->id_labor);
                                           $labor=$lab_query->nombre;
                                           $labores[]=$labor;
                                           $tot_dev=$dias * $pago_dia;
                                           $tot_basic=$tot_dev+$alim_tot;
                                           $total_dev2=$tot_basic + $septimo + $otros + $feriados;
                                           $total_acum=$total_dev2+ $extra_tot+$vac +$agui_tot;

                                           $tot_inss=$total_acum-$agui_tot;
                                           $inss= ($tot_inss*$inss_camp)/100;

                                           $tot_recib=$total_acum - $inss;
                                       }

                                       $array = [
                                         "id_trab"=>$id_trab,
                                         "dias"=>$dias,
                                         "alim_tot"=>$alim_tot,
                                         "vac_tot"=>$vac_tot,
                                         "agui_tot"=>$agui_tot,
                                         "extra_tot"=>$extra_tot,
                                         "nombre"=>$nombre,
                                         "labores"=>$labores,
                                         "total_deven"=>$tot_dev,
                                         "total_basic"=>$tot_basic,
                                         "horas_ext_tot"=>$horas_ext_tot,
                                         "cuje_ext_tot"=>$cuje_ext_tot,
                                         "total_acum"=>$total_acum,
                                         "inss"=>$inss,
                                         "salario_"=>$tot_recib
                                       ];

                                    $trabajadores[]=$array;
                                    unset($labores);
                                    $trab=$id_trab;
                                  }
                                }
                                return $trabajadores;

      }


}
