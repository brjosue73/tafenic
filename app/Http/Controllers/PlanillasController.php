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
  public function reporte_planilla(Request $request){
    $peticion=$request->all();
    $funcion=$peticion['funcion'];
    if ($funcion == 'Generar Imprimible')
    {
    $data =$this->calculo_planilla($peticion);
    $view = \View::make('reporte_catorcenal',array('data'=>$data));
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    $pdf->setPaper('legal', 'landscape');
    return $pdf->stream('invoice');
    return $pdf->stream();
    }
    elseif ($funcion == 'Generar sobres')
    {
      $data =$this->calculo_planilla($peticion);
      $view = \View::make('sobres_catorcenal',array('data'=>$data));
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      $paper_size = array(0,0,360,360);
      $pdf->setPaper($paper_size, 'landscape');
      return $pdf->stream('invoice');
      return $pdf->stream();
    }
    elseif($funcion == 'Billetes'){
      $peticion=$request->all();
      //$data =$this->billetes($peticion);
      $planillas=$this->calculo_planilla($peticion);
      $data =$this->calcular_billetes($planillas);
      $view = \View::make('billetes_catorcenal',array('data'=>$data));
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      $pdf->setPaper('a4', 'landscape');
      return $pdf->stream('invoice');
      return $pdf->stream();
    }
  }
  public function billetes(Request $request){
    $peticion=$request->all();
    $planillas=$this->calculo_planilla($peticion);
    $data =$this->calcular_billetes($planillas);
    return $data;
  }
  public function calcular_billetes($planillas){
    foreach ($planillas as $planilla) {
      $nums[]=$planilla['salario_'];
    }

    foreach ($nums as $N) {
      //recibir el total de pagos en un array
      //recibe el nombre de la gente
      $billete=$N;
      $numero_de_billetes_500 = $billete / 500;
      $billete = $billete % 500;
      $numero_de_billetes_500=floor($numero_de_billetes_500);

      $numero_de_billetes_200 = floor($billete / 200);
      $billete = $billete % 200;

      $numero_de_billetes_100 =floor($billete / 100);
      $billete = $billete % 100;

      $numero_de_billetes_50 =floor ($billete / 50);
      $billete = $billete % 50;

      $numero_de_billetes_20 = floor($billete / 20);
      $billete = $billete % 20;

      $numero_de_billetes_10 =floor ($billete / 10);
      $billete = $billete % 10;

      $numero_de_billetes_5 = floor($billete / 5);
      $billete = $billete % 5;

      $numero_de_billetes_1 = floor($billete / 1);
      $billete = $billete % 1;
      $num[0]=$N;
      $num[500]=$numero_de_billetes_500;
      $num[200]=$numero_de_billetes_200;
      $num[100]=$numero_de_billetes_100;
      $num[50]=$numero_de_billetes_50;
      $num[20]=$numero_de_billetes_20;
      $num[10]=$numero_de_billetes_10;
      $num[5]=$numero_de_billetes_5;
      $num[1]=$numero_de_billetes_1;
      $num[2]=$billete;
      $todos[]=$num;
    }
    $tot_500=0;$tot_200=0;$tot_100=0;$tot_50=0;$tot_20=0;$tot_10=0;$tot_5=0;$tot_1=0;$tot_billetes=0;
    foreach ($todos as $key) {

      $tot_500=$key[500]+$tot_500;
      $tot_200=$key[200]+$tot_200;
      $tot_100=$key[100]+$tot_100;
      $tot_50=$key[50]+$tot_50;
      $tot_20=$key[20]+$tot_20;
      $tot_10=$key[10]+$tot_10;
      $tot_5=$key[5]+$tot_5;
      $tot_1=$key[1]+$tot_1;
      $tot_billetes=round($key[0]+$tot_billetes,2);
      $cant_mult_500=$tot_500*500;$tot_500*500;$cant_mult_200=$tot_200*200;$cant_mult_100=$tot_100*100;$cant_mult_50=$tot_50*50;$cant_mult_20=$tot_20*20;$cant_mult_10=$tot_10*10;
      $cant_mult_5=$tot_5*5;$cant_mult_1=$tot_1*1;
    }
    $cant_ind[500]=$tot_500;$cant_ind[200]=$tot_200;$cant_ind[100]=$tot_100;$cant_ind[50]=$tot_50;$cant_ind[20]=$tot_20;
    $cant_ind[10]=$tot_10;$cant_ind[5]=$tot_5;$cant_ind[1]=$tot_1;$cant_ind[0]=$tot_billetes;
    $tot_mul=$cant_mult_500+$cant_mult_200+$cant_mult_100+$cant_mult_50+$cant_mult_20+$cant_mult_10+$cant_mult_5+$cant_mult_1;
    $dif=round($tot_billetes-$tot_mul,2);
    $todos['diferencia']=$dif;
    $todos['cantidad_multiplicada']=$tot_mul;
    $todos['total_billetes']=$tot_billetes;
    $todos['total_individual']=$cant_ind;
    return $todos;
  }
  public function calculo_planilla($peticion){
    $finca_mayor='--';
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
      $inss_patronal=12;
    }

      $planillas= Preplanilla::whereBetween('fecha', [$fecha_ini, $fecha_fin]) /***********Buscar en preplanilla segun el rango de fecha*************/
                              ->get();

    //foreach ($planillas as $planilla) {
      //solo hay 3 tipos administrativo, campo y serv_tecn
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
           /********************Saber si tiene septimos****************/
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
                 $otros+=$trab->otros;
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
                 $inss_pat=(($total_acum-$agui_tot)*$inss_patronal)/100;
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
               "finca_septimo"=>$finca_mayor,
               "inss_patronal"=>$inss_pat,
               "fecha_ini"=>$fecha_ini,
               "fecha_fin"=>$fecha_fin
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


}
