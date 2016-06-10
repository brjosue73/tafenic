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
    $peticion=$request->all();
    //return $peticion;
     $data =$this->calculo_planilla($peticion);
     return $data;
  }
  public function calculo_planilla($peticion){
    //$peticion = $request->all();
    //$arreglo = $peticion["data"];

    $finca_mayor='nada';
    //$fecha_ini="2016-01-01";
    //$fecha_fin="2017-01-01";
    $cargo='tcampo';

    $fecha_ini=$peticion['fecha_ini'];
    $fecha_fin=$peticion['fecha_fin'];
    //$cargo=$peticion['cargo'];

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
          $trabs= Preplanilla::where('id_trabajador',$id_trab)->whereBetween('fecha', [$fecha_ini, $fecha_fin])->get(); /*Todas las preplanillas de ese trabajador en ese rango de fecha*/
                                    //->where('id_finca',$id_finca)


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
                                   /********************CALCULO DEL SEPTIMO*****************/
                                   /********************Contar los dias trabajados*****************/
                                  $cant_septimos=0;
                                   if($dias>=6){ //merece por lo menos 1 septimo
                                     $cant_septimos=1;
                                     if($dias>12){//merece 2 septimos
                                       $cant_septimos=2;
                                     }
                                   }
                                   $tot_sept=$cant_septimos*$valor_dia;
                                   /*-------------CALCULO DEL SEPTIMO*/
                                   /*-------------CALCULO DEL SEPTIMO*/
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

                                         $fin_query= Finca::find($trab->id_finca);
                                         $finca=$fin_query->nombre;
                                         $fincas[]=$finca;

                                         $tot_dev=$dias * $pago_dia;
                                         $tot_basic=$tot_dev+$alim_tot;
                                         $total_dev2=$tot_basic + $tot_sept + $otros + $feriados;
                                         $total_acum=$total_dev2+ $extra_tot+$vac +$agui_tot;

                                         $tot_inss=$total_acum-$agui_tot;
                                         $inss= ($tot_inss*$inss_camp)/100;

                                         $tot_recib=$total_acum - $inss;
                                         $f=0;
                                         $c=0;
                                     }

                                       /**************SEPTIMO**************/
                                       //dias trabs en una Finca
                                       //saber las fincas unicas en las que trabajo
                                       if($tot_sept>0){
                                       $cant_fincas_todas = sizeof($fincas);
                                       $fincas_sinRep=array();

                                        foreach ($fincas as $fin) {
                                           $valor=in_array($fin, (array)$fincas_sinRep);//si ya existe la finca en el arreglo
                                          $converted_res = ($valor) ? 'true' : 'false';
                                           //si la nueva finca es = a cualquiera del arreglo marcado con bandera entonces no agregar
                                           if ($converted_res=='false'){
                                             $fincas_sinRep[]=$fin;
                                           }
                                         }

                                         foreach ($fincas_sinRep as $finca_nombre) {//recorro las fincas sin repeticion

                                           $finca_id_search=Finca::where('nombre',$finca_nombre)->first();//obtengo el id de esa finca
                                           $id_finca=$finca_id_search->id;//id
                                           $dias_finca=Preplanilla::where('id_trabajador',$id_trab) //buscar los dias q trabajo ese trabajador en esa finca en ese rango de fecha
                                           ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                                           ->where('id_finca', $id_finca)
                                           ->get();
                                           $cont_finc=$dias_finca->count();

                                           $dias_tot_fincas[$f]=$cont_finc;//agregarlo al arreglo
                                           $nomb_tot_fincas[$f]=$id_finca;
                                           $f+=1;
                                         }
                                         $mayor=0;
                                         foreach ($dias_tot_fincas as $dias_tot_finc) {
                                           if($dias_tot_finc>$mayor){
                                             $mayor=$dias_tot_finc;
                                             $id_mayor=$nomb_tot_fincas[$c];
                                           }
                                           $c+=1;
                                         }
                                         $fin_mayor_query= Finca::find($id_mayor);
                                         $finca_mayor=$fin_mayor_query->nombre;
                                      }

                                       /*--------------SEPTIMO**************/



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
                                       "salario_"=>$tot_recib,
                                       "fincas"=>$fincas,
                                       "total_septimo"=>$tot_sept,
                                       "finca_septimo"=>$finca_mayor
                                     ];
                                  $trabajadores[]=$array;
                                  unset($labores);
                                  unset($fincas);
                                  unset($fincas_sinRep);
                                  $trab=$id_trab;
                                }
                              }
                              return $trabajadores;

  }
  public function reporte_planilla(Request $request){
    $peticion=$request->all();
    $data =$this->calculo_planilla($peticion);
    $pdf = PDF::loadView('reporte_catorcenal',['peticion'=>$data]);
    $pdf->setPaper('legal', 'landscape');
    return $pdf->stream();
  }

}
