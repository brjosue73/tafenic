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
     $data =$this->calculo_planilla($peticion);
     $totales=$this->sum_totales($data);
     usort($data, function($a, $b) {
       return strcmp($a["nombre"], $b["nombre"]);
         return $a['order'] < $b['order']?1:-1;
     });
     $data[]=$totales;

     return $data;
  }
  public function inss_catorcenal(Request $request){

  }

  public function reporte_planilla(Request $request){
    $peticion=$request->all();
    $funcion=$peticion['funcion'];
    if ($funcion == 'Generar Imprimible'){
    $data =$this->calculo_planilla($peticion);
    usort($data, function($a, $b) {
      return strcmp($a["nombre"], $b["nombre"]);
        return $a['order'] < $b['order']?1:-1;
    });
    $totales=$this->sum_totales($data);

    $pdf = \PDF::loadView('reporte_catorcenal', array('data'=>$data,'totales'=>$totales));
    $pdf->setPaper('legal')->setOrientation('landscape')->setOption('margin-top', 4)->setOption('margin-bottom', 3);
    //$pdf->setOption('header-html', public_path('res/header_14nal.html'));
    //return view('reporte_catorcenal', array('data'=>$data,'totales'=>$totales));
    return $pdf->inline('Planilla_catorcenal.pdf');


    //return $pdf->download('Planilla_general.pdf');
    }
    elseif ($funcion == 'Generar sobres'){
      $datas =$this->calculo_planilla($peticion);
      usort($datas, function($a, $b) {
        return strcmp($a["nombre"], $b["nombre"]);
          return $a['order'] < $b['order']?1:-1;
      });
      ini_set("memory_limit", "452M");
      ini_set("max_execution_time", "600");
    //  return $datas;
    $data=array();
      foreach ($datas as $dat) {
        $array_1=array();
        $array_1['nombre']=$dat['nombre'];
        $array_1['total_septimo']=$dat["total_septimo"];
        $array_1['total_basic']=$dat["total_basic"];
        $array_1['horas_ext_tot']=$dat["horas_ext_tot"];
        $array_1['cant_horas_ext']=$dat["cant_horas_ext"];
        $array_1['vac_tot']=$dat["vac_tot"];
        $array_1['agui_tot']=$dat["agui_tot"];
        $array_1['horas_ext_tot']=$dat["horas_ext_tot"];
        $array_1['total_deven']=$dat["total_deven"];
        $array_1['salario_']=$dat["salario_"];
        $array_1['inss']=$dat["inss"];
        $array_1['fecha_ini']=$dat["fecha_ini"];
        $array_1['fecha_fin']=$dat["fecha_fin"];
        $data[]=$array_1;
      }
      //return $data[0]['fecha_ini'];

      // return $data;

      $pdf = \PDF::loadView('sobres_catorcenal',array('data'=>$data));
      $pdf->setOrientation('landscape');
      $pdf->setOption('page-width', '9.5cm')->setOption('page-height', '19.05cm');
      return $pdf->inline('sobres_catorcenal.pdf');


      $view = \View::make('sobres_catorcenal',array('data'=>$data));
      $pdf = \App::make('dompdf.wrapper');

      $pdf->loadHTML($view);
      $paper_size = array(0,0,278.9291,540);
      $pdf->setPaper($paper_size, 'landscape');

      return $pdf->stream('Sobre.pdf');
    }
    elseif($funcion == 'Billetes'){
      $peticion=$request->all();
      //$data =$this->billetes($peticion);
      $planillas=$this->calculo_planilla($peticion);

      usort($planillas, function($a, $b) {
        return strcmp($a["nombre"], $b["nombre"]);
          return $a['order'] < $b['order']?1:-1;
      });
      $pdf='';
      $data =$this->calcular_billetes($planillas);
      $nombres=$this->nombres_billetes($planillas);
      $pdf = \PDF::loadView('billetes_catorcenal',array('data'=>$data,'nombres'=>$nombres));
      $pdf->setPaper('a4')->setOrientation('landscape');
      return $pdf->inline('Billetes_catorcenal.pdf');
    }
    elseif($funcion == 'Reporte DGI'){
      $peticion=$request->all();
      $tot=array();
      $datas =$this->calculo_planilla($peticion);
      // usort($data, function($a, $b) {
      //   return strcmp($a["nombre"], $b["nombre"]);
      //     return $a['order'] < $b['order']?1:-1;
      // });
      foreach ($datas as $data) {
        $id=$data['id_trab'];
        $trabajador= Trabajador::find($id);
        $fecha=explode('-',$data['fecha_ini']);
        $fecha_act=$fecha[0].'-'.$fecha[1];
        $array=[
          "ruc"=>$trabajador->cedula,
          "nombres"=>$trabajador->nombre.' '.$trabajador->apellidos,
          "t_devengado"=>$data['salario_'],
        ];
        $tot[]=$array;
      }
      return view('dgi_catorcenal')->with('data',$tot);
      return $tot;
    }
    elseif ($funcion == 'Reporte INSS') {
      $peticion=$request->all();
      $tot=array();
      $datas =$this->calculo_planilla($peticion);
      // usort($data, function($a, $b) {
      //   return strcmp($a["nombre"], $b["nombre"]);
      //     return $a['order'] < $b['order']?1:-1;
      // });
      foreach ($datas as $data) {
        $id=$data['id_trab'];
        $trabajador= Trabajador::find($id);
        $sep_nombre=explode(' ', $trabajador->nombre);
        $sep_ape=explode(' ', $trabajador->apellidos);
        $nombre=strtoupper("'".$sep_nombre[0]);
        $apellido=strtoupper("'".$sep_ape[0]);

        $fecha=explode('-',$data['fecha_ini']);
        $fecha_act=$fecha[0].'-'.$fecha[1];
        $array=[
          "nss"=>$trabajador->nss,
          "pnombre"=>$nombre,
          "papellido"=>$apellido,
          "t_devengado"=>$data['salario_'],
          "fecha_ini"=>$fecha_act,
        ];
        $tot[]=$array;
      }

      return view('inss_catorcenal')->with('data',$tot);
      return $tot;

    }
  }
  public function billetes(Request $request){
    $peticion=$request->all();
    $planillas=$this->calculo_planilla($peticion);
    $data =$this->calcular_billetes($planillas);
    return $data;
  }
  public function nombres_billetes($planillas){
    foreach ($planillas as $planilla) {
      $nombres[]=$planilla['nombre'];
    }
    return $nombres;
  }
  public function calcular_billetes($planillas){
    foreach ($planillas as $planilla) {
      $nums[]=$planilla['salario_'];
    }

    $i=0;
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
      $i++;
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
  public function sum_totales($data){
    $sum_dias_trab=0;
    $sum_dev1=0;
    $sum_alim=0;
    $sum_basico=0;
    $sum_septimos=0;
    $sum_subsidios=0;
    $sum_otros=0;
    $sum_feriados=0;
    $sum_dev2=0;
    $sum_h_ext=0;
    $sum_tot_hext=0;
    $sum_vacs=0;
    $sum_aguin=0;
    $sum_acum=0;
    $sum_inss_lab=0;
    $sum_prestam=0;
    $sum_inss_pat=0;
    $sum_tot_recib=0;


    foreach ($data as $trab) {
      $sum_tot_recib +=$trab['salario_'];
      $sum_dias_trab+=$trab['dias'];
      $sum_dev1+=$trab['total_deven'];
      $sum_alim+=$trab['alim_tot'];
      $sum_basico+=$trab['total_basic'];
      $sum_septimos+=$trab['total_septimo'];
      $sum_subsidios+=$trab['subsidio'];
      $sum_otros+=$trab['otros'];
      $sum_feriados+=$trab['feriado'];
      $sum_dev2+=$trab['devengado2'];
      $sum_h_ext+=$trab['cant_horas_ext'];
      $sum_tot_hext+=$trab['horas_ext_tot'];
      $sum_vacs+=$trab['vac_tot'];
      $sum_aguin+=$trab['agui_tot'];
      $sum_acum+=$trab['total_acum'];
      $sum_inss_lab+=$trab['inss'];
      $sum_prestam+=$trab['prestamos'];
      $sum_inss_pat+=$trab['inss_patronal'];
    }
    $totales=  [
       "sum_tot_recib"=>round($sum_tot_recib,2),
       'sum_dias_trab'=>$sum_dias_trab,
       "sum_dev1"=>round($sum_dev1,2),
       "sum_alim"=>round($sum_alim,2),
       "sum_basico"=>round($sum_basico,2),
       'sum_septimos'=>round($sum_septimos,2),
       'sum_subsidios'=>round($sum_subsidios,2),
       'sum_otros'=>round($sum_otros,2),
       'sum_feriados'=>round($sum_feriados,2),
       'sum_dev2'=>round($sum_dev2,2),
       'sum_h_ext'=>round($sum_h_ext,2),
       'sum_tot_hext'=>round($sum_tot_hext,2),
       'sum_vacs'=>$sum_vacs,
       'sum_aguin'=>$sum_aguin,
       'sum_acum'=>$sum_acum,
       'sum_inss_lab'=>round($sum_inss_lab,2),
       'sum_prestam'=>round($sum_prestam,2),
       'sum_inss_pat'=>round($sum_inss_pat,2),
    ];
    return $totales;
  }
  public function calculo_planilla($peticion){
    $finca_mayor='--';
    $cargo='tcampo';
    $fecha_ini=$peticion['fecha_ini'];
    $fecha_fin=$peticion['fecha_fin'];
    $variables=Variable::all();
    foreach ($variables as $variable) {
      $alim_var=$variable->alimentacion;
      $valor_dia= $variable->sal_diario;
      $cuje_grand= $variable->cuje_grand;
      $cuje_peq= $variable->cuje_peq;
      $vacaciones=$variable->vacaciones/100;
      $pago_dia=$variable->sal_diario;
    }
    $planillas= Preplanilla::whereBetween('fecha', [$fecha_ini, $fecha_fin]) /***********Buscar en preplanilla segun el rango de fecha*************/
                              ->get();

    $tamano = sizeof($planillas);
    $trabajadores=array();
    $identif=array();
    $trab=0;
    $count=0;
      for ($i=0; $i < $tamano; $i++) { /*Recorre toda la planilla*/
        $id_trab=$planillas[$i]->id_trabajador;//Asigna el id del trabajador que esta recorriendo en la planilla actualmente
        $valor=in_array($id_trab, (array)$identif);//si ya existe la finca en el arreglo
        $converted_res = ($valor) ? 'true' : 'false';
        if ($converted_res=='false') { //Sino esta repetido
          $identif[]=$id_trab;
          $trabs= Preplanilla::where('id_trabajador',$id_trab) /*Todas las preplanillas de ese trabajador en ese rango de fecha*/
          ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
          // ->where('fecha',<=,$fecha_ini)
          // ->where('fecha',>=,$fecha_fin)
          ->get();
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
           $feriado_tot=0;
           $tot_dev=0;
           $subsidios=0;
           $cant_horas_ext=0;
           $cant_act_ext=0;
           $sum_tot_recib=0;
           $prestamo=0;


           $trabajador=Trabajador::find($id_trab);
           $nombres=$trabajador->nombre;
           $apellido=$trabajador->apellidos;
           $nombre="$nombres   $apellido";
           /********************Saber si tiene septimos****************/
           /********************Contar los dias trabajados*****************/
          $cant_septimos=0;
           if($dias>=6){ //merece por lo menos 1 septimo
             $cant_septimos=1;
             if($dias>=12){//merece 2 septimos
               $cant_septimos=2;
             }
           }
           foreach ($trabs as $trab) {
             $feriados+=$trab->feriados;

           }


           $tot_sept=$cant_septimos*$valor_dia;

           $feriados=0;
             foreach ($trabs as $trab) {
                 $inss_camp=$trab['inss_campo'];
                 $tot_sept+=$trab['septimo'];
                 $inss_patronal=$trab->inss_patron;
                 $otros+=$trab->otros;
                 $salario=$trab->salario_acum;
                 $salario_tot += $salario;
                 $alim=$trab->alimentacion;
                 $alim_tot = $dias*$alim;
                 $vac= $trab->vacaciones;
                 $prestamo+= $trab->prestamo;
                //  $vac_tot += $vac;
                //  $agui_tot= $vac_tot;
                 $horas_ext_tot +=$trab->hora_ext;
                 $cuje_ext_tot +=$trab->cuje_ext;
                 $extras=$trab['total_extras'];
                 $extra_tot += $extras;
                 $cant_horas_ext += $trab['hora_ext'];
                 $act_ext_sum=$trab['safa_ext'] + $trab['cuje_ext'];
                 $cant_act_ext += $act_ext_sum;
                 $lab_query=Labor::find($trab->id_labor);
                 $labor=$lab_query->nombre;
                 $labores[]=$labor;
                 $tot_dev +=$trab['total_actividad'];
                 $feriados+=$trab->feriados;
                 //$feriado_tot+=$feriados;
                 $subsidios += $trab['subsidios'];
                 $fin_query= Finca::find($trab->id_finca);
                 $finca=$fin_query->nombre;
                 $fincas[]=$finca;
                 //si la labor es de hora o de actividad
                //  if($lab_query['tipo_labor']=='prod'){ //Si es de tipo actividad/cujes/ensarte
                //      $tot_dev=$trab['total_actividad'];
                //  }
                //  else {//si es por horas
                //    $tot_dev=$dias * $pago_dia;
                //  }


                 $tot_dev=$dias * $pago_dia;
                 $tot_basic=$tot_dev+$alim_tot;
                 $total_dev3=$tot_basic + $tot_sept + $otros + $feriados;
                 $total_dev2=round($total_dev3,2);
                 $tot_sept=round($tot_sept,2);

                 $tot_a_vacs=($tot_dev+$tot_sept+$feriados)*$vac;
                 $tot_a_vacs=round($tot_a_vacs,2);
                 //return $vac;
                 $total_acum=$total_dev2+ $extra_tot+$tot_a_vacs+$tot_a_vacs;
                //  return $total_acum;
                //  return $total_dev2.' Vacaciones: '.$tot_a_vacs;

                 $tot_inss=$total_acum-round($tot_a_vacs,2)-$alim_tot;

                //  return $tot_inss;
                 $inss= ($tot_inss*$inss_camp)/100;
                 //return ($tot_inss." ". $inss_camp);
                 $inss_pat=($tot_inss*$inss_patronal)/100;
                 //return $inss;

                 //return ("acum: ".$total_acum." agui_tot: ".round($tot_a_vacs,2)." alim_tot: ".$alim_tot);

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
              else {
                $finca_mayor='---';
              }


             $array = [
               "id_trab"=>round($id_trab,2),
               "dias"=>round($dias,2),
               "alim_tot"=>round($alim_tot,2),
               "vac_tot"=>round($tot_a_vacs,2),
               "agui_tot"=>round($tot_a_vacs,2),
               "nombre"=>$nombre,
               "labores"=>$labores,
               "total_deven"=>round($tot_dev,2),
               "total_basic"=>round($tot_basic,2),
               "horas_ext_tot"=>round($extra_tot,2),
               "cant_horas_ext"=>round($cant_horas_ext,2),
               "cant_act_ext"=>round($cant_act_ext,2),
               "cuje_ext_tot"=>round($cuje_ext_tot,2),
               "total_acum"=>round($total_acum,2),
               "inss"=>round($inss,2),
               "salario_"=>round($tot_recib,2),
               "fincas"=>$fincas,
               "total_septimo"=>round($tot_sept,2),
               "finca_septimo"=>$finca_mayor,
               "inss_patronal"=>round($inss_pat,2),
               "fecha_ini"=>$fecha_ini,
               "fecha_fin"=>($fecha_fin),
               "subsidio"=>round($subsidios,2),
               "otros"=>round($otros,2),
               "feriado"=>round($feriados,2),
               "devengado2"=>round($total_dev2,2),
               "sum_tot_recib"=>round($sum_tot_recib,2),
               "prestamos"=>round($prestamo,2),
               "fecha_ini"=>$fecha_ini,
               "fecha_fin"=>$fecha_fin,
             ];
          $trabajadores[]=$array;

          unset($labores);
          unset($fincas);
          unset($fincas_sinRep);
        }/*Fin Si no esta repetido*/
      }//Fin For de recorrer toda la planilla

      return $trabajadores;

  }//E

  public function eliminar(Request $request){
    $catorcenal = Preplanilla::find($request['id']);
    $catorcenal->delete();
    return 'Eliminada';

  }




}
