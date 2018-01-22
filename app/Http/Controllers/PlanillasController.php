<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Finca;
use App\Preplanilla;
use App\Trabajador;
use App\Labor;
use App\Variable;
use DB;
use Excel;

class PlanillasController extends Controller
{
  public function planilla_general2($request){
    set_time_limit(600);
    $peticion=$request->all();
     $data =$this->calculo_planilla($peticion);
     
     usort($data, function($a, $b) {
       return strcmp($a["nombre"], $b["nombre"]);
         return $a['order'] < $b['order']?1:-1;
     });
     return $data;
  }
  public function planilla_general(Request $request){
    $data=$this->planilla_general3($request);
      return $data;

  }
  public function planilla_general3($request){
    
    $data=$this->planilla_general2($request);
    return $data;
    $totales=$this->sum_totales($data); 

    $dev=$totales['sum_dev1'];
    $septimo=$totales['sum_septimos'];
    $feriados=$totales['sum_feriados'];
    $tot_dev2=$totales['sum_dev2'];
    $prestamos=$totales['sum_prestam'];
    $alim=$totales['sum_alim'];
    $tot_hext=$totales['sum_tot_hext'];
    $dinero_cuje=$totales['sum_dinero_activ'];
    $a_vac=$dev+$septimo+$feriados;
    $vacs=$a_vac*0.083333;
    $tot_acum=$vacs+$vacs+$tot_dev2+$tot_hext+$dinero_cuje;
    $inss_lab=(($tot_acum-$vacs-$alim)*4.25)/100;
    $tot_recib=$tot_acum-$inss_lab-$prestamos;
    $inss_pat=(($tot_acum-$vacs-$alim)*13)/100;
    $totales['sum_acum']=round($tot_acum,2);
    $totales['sum_aguin']=round($vacs,2);
    $totales['sum_vacs']=round($vacs,2);
    $totales['sum_inss_lab']=round($inss_lab,2);
    $totales['sum_tot_recib']=round($tot_recib,2);
    $totales['sum_inss_pat']=round($inss_pat,2);

    $data[]=$totales;
    return $data;
  }
  public function inss_catorcenal(Request $request){}

  public function reporte_planilla(Request $request){
    $peticion=$request->all();
    $funcion=$peticion['funcion'];
    set_time_limit(600);

    if ($funcion == 'Generar Imprimible'){
      $data=$this->planilla_general2($request);
      $totales=$this->sum_totales($data);
      $dev=$totales['sum_dev1'];
      $septimo=$totales['sum_septimos'];
      $feriados=$totales['sum_feriados'];
      $tot_dev2=$totales['sum_dev2'];
      $prestamos=$totales['sum_prestam'];
      $alim=$totales['sum_alim'];
      $tot_hext=$totales['sum_tot_hext'];
      $dinero_cuje=$totales['sum_dinero_activ'];

      $a_vac=$dev+$septimo+$feriados;
      $vacs=$a_vac*0.083333;
      $tot_acum=$vacs+$vacs+$tot_dev2+$tot_hext+$dinero_cuje;
      // $tot_acum=$vacs+$vacs+$tot_dev2;
      $inss_lab=(($tot_acum-$vacs-$alim)*4.25)/100;
      $tot_recib=$tot_acum-$inss_lab-$prestamos;
      $inss_pat=(($tot_acum-$vacs-$alim)*13)/100;
      $totales['sum_acum']=round($tot_acum,2);
      $totales['sum_aguin']=round($vacs,2);
      $totales['sum_vacs']=round($vacs,2);
      $totales['sum_inss_lab']=round($inss_lab,2);
      $totales['sum_tot_recib']=round($tot_recib,2);
      $totales['sum_inss_pat']=round($inss_pat,2);
      $encabezado=$this->estilos_planilla($data);
      $pdf = \PDF::loadView('reporte_catorcenal', array('data'=>$data,'totales'=>$totales));
      $pdf->setPaper('legal')->setOrientation('landscape')->setOption('margin-top', 20)->setOption('margin-bottom', 3);
      $pdf->setOption('header-html', $encabezado);
      //return view('reporte_catorcenal', array('data'=>$data,'totales'=>$totales));
      return $pdf->inline('Planilla_catorcenal.pdf');
    }
    elseif ($funcion == 'Generar sobres'){
      $datas =$this->calculo_planilla($peticion);
      usort($datas, function($a, $b) {
        return strcmp($a["nombre"], $b["nombre"]);
          return $a['order'] < $b['order']?1:-1;
      });
      ini_set("memory_limit", "1024M");
      ini_set("max_execution_time", "600");
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
        $array_1['feriados']=$dat["feriados"];
        $array_1['otros']=$dat["otros"];

        $array_1['dinero_cuje']=$dat["dinero_cuje"];
        $array_1['dinero_safa']=$dat["dinero_safa"];
        $array_1['tot_cuje_peq']=$dat["tot_cuje_peq"];
        $array_1['tot_cuje_gran']=$dat["tot_cuje_gran"];
        $array_1['tot_safa_peq']=$dat["tot_safa_peq"];
        $array_1['tot_safa_gran']=$dat["tot_safa_gran"];


        $data[]=$array_1;
      }
      $pdf = \PDF::loadView('sobres_catorcenal',array('data'=>$data));
      $pdf->setOrientation('landscape');
      $pdf->setOption('page-width', '9.5cm')->setOption('page-height', '19.05cm')->setOption('margin-top', 5)->setOption('margin-bottom', 3);
      //return view('sobres_catorcenal',array('data'=>$data));
      return $pdf->inline('sobres_catorcenal.pdf');


      $view = \View::make('sobres_catorcenal',array('data'=>$data));
      $pdf = \App::make('dompdf.wrapper');

      $pdf->loadHTML($view);
      $paper_size = array(0,0,278.9291,540);
      $pdf->setPaper($paper_size, 'landscape');

      return $pdf->stream('Sobre.pdf');
    }
    elseif($funcion == 'Billetes'){
      set_time_limit(600);
      ini_set('memory_limit', '2048M');

      $data=$this->planilla_general2($request);
      $totales=$this->sum_totales($data);

      $peticion=$request->all();

      $planillas=$this->calculo_planilla($peticion);

      $totales=$this->sum_totales($planillas);


      $dev=$totales['sum_dev1'];
      $septimo=$totales['sum_septimos'];
      $feriados=$totales['sum_feriados'];
      $tot_dev2=$totales['sum_dev2'];
      $prestamos=$totales['sum_prestam'];
      $alim=$totales['sum_alim'];
      $tot_hext=$totales['sum_tot_hext'];
      $dinero_cuje=$totales['sum_dinero_activ'];

      $a_vac=$dev+$septimo+$feriados;
      $vacs=$a_vac*0.083333;
      $tot_acum=$vacs+$vacs+$tot_dev2+$tot_hext+$dinero_cuje;
      // $tot_acum=$vacs+$vacs+$tot_dev2;
      $inss_lab=(($tot_acum-$vacs-$alim)*4.25)/100;
      $tot_recib=$tot_acum-$inss_lab-$prestamos;
      $inss_pat=(($tot_acum-$vacs-$alim)*13)/100;
      $totales['sum_acum']=round($tot_acum,2);
      $totales['sum_aguin']=round($vacs,2);
      $totales['sum_vacs']=round($vacs,2);
      $totales['sum_inss_lab']=round($inss_lab,2);
      $totales['sum_tot_recib']=round($tot_recib,2);
      $totales['sum_inss_pat']=round($inss_pat,2);
      $pdf='';
      $data=$this->calcular_billetes($planillas, $totales);
      // $totales2=$this->sum_totales($planillas);
      // return $totales2;
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
      //return $datas;
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
          "salario"=>$data['salario_'],
          "t_devengado"=>$data['devengado2'],

          "fecha_ini"=>$fecha_act,
        ];
        $tot[]=$array;
      }

      return view('inss_catorcenal')->with('data',$tot);
      return $tot;

    }
    elseif ($funcion == 'Rep. Excel') {
      $data=$this->planilla_general2($request);
      $totales=$this->sum_totales($data);
      $dev=$totales['sum_dev1'];
      $septimo=$totales['sum_septimos'];
      $feriados=$totales['sum_feriados'];
      $tot_dev2=$totales['sum_dev2'];
      $prestamos=$totales['sum_prestam'];
      $alim=$totales['sum_alim'];
      $tot_hext=$totales['sum_tot_hext'];
      $dinero_cuje=$totales['sum_dinero_activ'];

      $a_vac=$dev+$septimo+$feriados;
      $vacs=$a_vac*0.083333;
      $tot_acum=$vacs+$vacs+$tot_dev2+$tot_hext+$dinero_cuje;
      // $tot_acum=$vacs+$vacs+$tot_dev2;
      $inss_lab=(($tot_acum-$vacs-$alim)*4.25)/100;
      $tot_recib=$tot_acum-$inss_lab-$prestamos;
      $inss_pat=(($tot_acum-$vacs-$alim)*13)/100;
      $totales['sum_acum']=round($tot_acum,2);
      $totales['sum_aguin']=round($vacs,2);
      $totales['sum_vacs']=round($vacs,2);
      $totales['sum_inss_lab']=round($inss_lab,2);
      $totales['sum_tot_recib']=round($tot_recib,2);
      $totales['sum_inss_pat']=round($inss_pat,2);

      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      $fecha_ini=$data['0']['fecha_ini'];
      $fecha_fin=$data['0']['fecha_fin'];

      $fecha_1=date("d-m-Y", strtotime("$fecha_ini"));
      $dia_ini=date("d", strtotime($fecha_1));
      $mes_ini=date("m", strtotime($fecha_1));
      $ano="2017";//date("Y", strtotime($fecha_1));

      $fecha_2=date("d-F-Y", strtotime("$fecha_fin"));
      $dia_fin=date("d", strtotime($fecha_2));
      $mes_fin=date("m", strtotime($fecha_2));
      $i=0;
      Excel::create('Planilla', function($excel) use($data, $totales) {
          $excel->sheet('Excel sheet', function($sheet) use($data, $totales) {
              $sheet->loadView('reporte_catorcenal_excel', array('data'=>$data,'totales'=>$totales));
          });
      })->export('xls');
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
  public function calcular_billetes($planillas, $totales){
    $tot_dinero=$totales['sum_tot_recib'];
    foreach ($planillas as $planilla) {
      $nums[]=$planilla['salario_'];
    }

    $i=0;
    foreach ($nums as $N) {
      //recibir el total de pagos en un array
      //recibe el nombre de la gente
      $billete=$N;

      $numero_de_billetes_1000 = floor($billete / 1000);
      $billete = $billete % 1000;

      $numero_de_billetes_500 = floor($billete / 500);
      $billete = $billete % 500;

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
      $num[1000]=$numero_de_billetes_1000;
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
    $tot_1000=0;$tot_500=0;$tot_200=0;$tot_100=0;$tot_50=0;$tot_20=0;$tot_10=0;$tot_5=0;$tot_1=0;$tot_billetes=0;
    foreach ($todos as $key) {

      $tot_1000=$key[1000]+$tot_1000;
      $tot_500=$key[500]+$tot_500;
      $tot_200=$key[200]+$tot_200;
      $tot_100=$key[100]+$tot_100;
      $tot_50=$key[50]+$tot_50;
      $tot_20=$key[20]+$tot_20;
      $tot_10=$key[10]+$tot_10;
      $tot_5=$key[5]+$tot_5;
      $tot_1=$key[1]+$tot_1;
      $tot_billetes=round($key[0]+$tot_billetes,2);
      $cant_mult_1000=$tot_1000*1000;$cant_mult_500=$tot_500*500;
      $tot_500*500;$tot_1000*1000;$cant_mult_200=$tot_200*200;$cant_mult_100=$tot_100*100;$cant_mult_50=$tot_50*50;$cant_mult_20=$tot_20*20;$cant_mult_10=$tot_10*10;
      $cant_mult_5=$tot_5*5;$cant_mult_1=$tot_1*1;
    }
    $cant_ind[1000]=$tot_1000;$cant_ind[500]=$tot_500;$cant_ind[200]=$tot_200;$cant_ind[100]=$tot_100;$cant_ind[50]=$tot_50;$cant_ind[20]=$tot_20;
    $cant_ind[10]=$tot_10;$cant_ind[5]=$tot_5;$cant_ind[1]=$tot_1;$cant_ind[0]=$tot_billetes;
    $tot_mul=$cant_mult_1000+$cant_mult_500+$cant_mult_200+$cant_mult_100+$cant_mult_50+$cant_mult_20+$cant_mult_10+$cant_mult_5+$cant_mult_1;
    $dif=round($tot_dinero-$tot_mul,2);
    $todos['diferencia']=$dif;
    $todos['cantidad_multiplicada']=$tot_mul;
    $todos['total_billetes']=$tot_dinero;
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
    $sum_act_extra_tot=0;
    $sum_dinero_activ=0;
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
      $sum_feriados+=$trab['feriados'];
      $sum_dev2+=$trab['devengado2'];
      $sum_h_ext+=$trab['cant_horas_ext'];
      $sum_tot_hext+=$trab['horas_ext_tot'];
      $sum_act_extra_tot+=$trab['cant_act_ext'];
      $sum_dinero_activ+=$trab['act_extra_tot'];

      $sum_vacs+=$trab['vac_tot'];
      $sum_aguin+=$trab['agui_tot'];
      $sum_acum+=$trab['total_acum'];
      $sum_inss_lab+=$trab['inss'];
      $sum_prestam+=$trab['prestamos'];
      $sum_inss_pat+=$trab['inss_patronal'];
    }
    $test1=0;
    $totales=  [
        'aa_test1'=>$test1,
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
       'sum_act_extra_tot'=>round($sum_act_extra_tot,2),
       'sum_h_ext'=>round($sum_h_ext,2),
       'sum_tot_hext'=>round($sum_tot_hext,2),
       'sum_vacs'=>$sum_vacs,
       'sum_aguin'=>$sum_aguin,
       'sum_acum'=>$sum_acum,
       'sum_inss_lab'=>round($sum_inss_lab,2),
       'sum_prestam'=>round($sum_prestam,2),
       'sum_inss_pat'=>round($sum_inss_pat,2),
       'sum_dinero_activ'=>round($sum_dinero_activ,2),
    ];
    return $totales;
  }
  public function contar_dias($data){
    $dias=0;
    $horas=0;
    $dias_sept=0;
    foreach ($data as $trab) {
      $horas+=$trab['hora_trab'];
      if($trab['hora_trab']==8){
        $dias+=1;
        $dias_sept+=1;
      }
      elseif ($trab['hora_trab']==0) {
        $dias_sept+=1;
      }

      else {
        $x=($trab['hora_trab']*100)/8;
        $total=$x/100;
        $dias+=$total;
        $dias_sept+=$total;
      }
    }
    $arreglo=[
      'dias'=>$dias,
      'dias_sept'=>$dias_sept,
    ];
    return $arreglo;
  }
  public function calculo_planilla($peticion){
    ini_set('memory_limit', '2048M');
    $finca_mayor='--';
    $fecha_ini=$peticion['fecha_ini'];
    $fecha_fin=$peticion['fecha_fin'];
    $inss_recibido=$peticion['inss'];
    $planillas= Preplanilla::whereBetween('fecha', [$fecha_ini, $fecha_fin]) /***********Buscar en preplanilla segun el rango de fecha*************/
                              ->get();

    $tamano = sizeof($planillas);
    $trabajadores=array();$identif=array();$con_inss=array();$sin_inss=array();
    $trab=0; $count=0;
    $array_id=array();
    $id_sinRep=0;
    $tamano2=sizeof($array_id);
    $j=0;
    $v1=0;
    $v2=0;
    for ($i=0; $i < $tamano; $i++) { /*Recorre toda la planilla*/
      $valor_dia=$planillas[$i]['salario_dev'];
      //$id_trab=$array_id[$i];
      $id_trab=$planillas[$i]->id_trabajador;//Asigna el id del trabajador que esta recorriendo en la planilla actualmente
      $valor=in_array($id_trab, (array)$identif);//si ya existe la finca en el arreglo
      $converted_res = ($valor) ? 'true' : 'false';
      
      if ($converted_res=='false') { //Sino esta repetido
        $identif[]=$id_trab;
        $trabs= Preplanilla::where('id_trabajador',$id_trab) /*Todas las preplanillas de ese trabajador en ese rango de fecha*/
        ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
        ->get();

        $dias2= $trabs->count();
        $contar_dias=$this->contar_dias($trabs);
        $dias=$contar_dias['dias'];
        $dias_sept=$contar_dias['dias_sept'];
        $salario_tot=0; $alim_tot=0; $vac_tot=0; $agui_tot=0; $extra_tot=0; $tot_act_ext=0; $horas_ext_tot=0; $cuje_ext_tot=0; $total_dev2=0; $septimo=0;
        $otros=0; $feriados=0; $feriado_tot=0; $tot_dev=0; $tot_devengado=0; $subsidios=0; $cant_horas_ext=0; $cant_act_ext=0; $act_extra_tot=0; $sum_tot_recib=0; $prestamo=0;
        $feriado1=0;$feriado2=0; $tot_sept=0;
        $test1=0;$test2=0;
        $dinero_cuje=0;$dinero_safa=0;
        $tot_cuje_peq=0;$tot_safa_peq=0;$tot_cuje_gran=0; $tot_safa_gran=0;

        $trabajador=Trabajador::find($id_trab);
        $nombres=$trabajador->nombre;
        $apellido=$trabajador->apellidos;
        $nombre="$nombres   $apellido";
        $n_inss=$trabajador->inss;
        $sep3=0;$sep4=0;$sep1=0;$sep2=0;
        $dia_mayor=0;$dia_menor=0;
        foreach ($trabs as $trab) {
          
          $valor_dia=$trab['salario_dev'];
          $test1=$valor_dia;
          $x=($trab['hora_trab']*100)/8;
          $tot_hora=$x/100;
          // $dias+=$total;
          $hora_pag=$tot_hora*$valor_dia;
          $tot_dev+=$hora_pag;
          /**********************************************************************************************************************/
          //$test1[]=$trab['salario_dev'];
          $feriados+=$trab->feriados;
          if($dia_mayor<$valor_dia){
            $dia_menor=$dia_mayor;
            $dia_mayor=$valor_dia;
          }
          elseif ($dia_mayor<$valor_dia) {
            $dia_menor=$valor_dia;
          }
          if($trab->tipo_feriado==1){//Feriado no trabajado
            $feriado1+=1;
          }
          if($trab->tipo_feriado==2){//Feriado no trabajado
            $feriado2+=1;
          }
          if ($dia_menor==0){
              $valor_dia=$trab['salario_dev'];
              $dia_menor=$valor_dia;
          }
        }
        /********Contar los dias trabajados  Saber si tiene septimos**********/
        $cant_septimos=0;
        if($dias_sept>=6){
          $cant_septimos=1;
          if($dias_sept>=12){
            $cant_septimos=2;
            if ($dias_sept>=18) {
              $cant_septimos=3;
              if ($dias_sept>=24) {
                $cant_septimos=4;
              }
            }
          }
        }
        if ($cant_septimos==1) {
          $sep1=$trabs[0]['salario_dev'];
          $tot_sept=$dia_menor;
        }
        elseif($cant_septimos==2){
          $sep1=$trabs[0]['salario_dev'];
          $sep2=$trabs[11]['salario_dev'];
          $tot_sept=$dia_mayor+$dia_menor;

        }
        elseif ($cant_septimos==3) {
          $tot_sep=$dia_mayor+$dia_menor+$dia_mayor+$dia_mayor;
          $sep1=$trabs[0]['salario_dev'];
          $sep2=$trabs[11]['salario_dev'];
          $sep3=$trabs[17]['salario_dev'];
        }
        elseif ($cant_septimos==4) {
          $tot_sep=$dia_mayor+$dia_menor+$dia_mayor+$dia_menor;
          $sep1=$trabs[0]['salario_dev'];
          $sep2=$trabs[11]['salario_dev'];
          $sep3=$trabs[17]['salario_dev'];
          $sep4=$trabs[21]['salario_dev'];
        }
        $tot_sept=$sep1+$sep2+$sep3+$sep4;
        $feriado_nt=$feriado1*$valor_dia;
        $feriado_t=$feriado2*($valor_dia*2);
        $feriados=$feriado_t+$feriado_nt;
          foreach ($trabs as $trab) {
            $tot_safa_gran+=$trab['tot_safa_gran'];
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
            $horas_ext_tot +=$trab->hora_ext;
            $cuje_ext_tot +=$trab->cuje_ext;
            $act_ext=$trab['tot_act_ext'];
            $act_extra_tot+=$act_ext; //Suma de las ganancias de activi
            $extras=$trab['total_extras'];// Ganancia de las horas extras
            $extra_tot += $extras; // Suma de Ganancia de las horas extras
            $cant_horas_ext += $trab['hora_ext']; //Cantidad de horas extras
            $act_ext_sum=$trab['safa_ext'] + $trab['cuje_ext']; //Cantidad de extras, ya sea safa o ensarte
            $cant_act_ext += $act_ext_sum; //Cantidades totales de los extras
            $dinero_cuje+=$trab['tot_cuje_ext'];
            $dinero_safa+=$trab['tot_safa_ext'];
            $tot_cuje_peq+=$trab['tot_cuje_peq'];
            $tot_safa_peq+=$trab['tot_safa_peq'];
            $tot_cuje_gran+=$trab['tot_cuje_gran'];
            $lab_query=Labor::find($trab->id_labor);
            $labor=$lab_query->nombre;
            $labores[]=$labor;
            $subsidios += $trab['subsidios'];
            $fin_query= Finca::find($trab->id_finca);
            $finca=$fin_query->nombre;
            $fincas[]=$finca;
            $tot_basic=$tot_dev+$alim_tot;
            $total_dev3=$tot_basic + $tot_sept + $otros + $feriados;
            $total_dev2=round($total_dev3,2);
            $tot_sept=round($tot_sept,2);
            $tot_a_vacs=($tot_dev+$tot_sept+$feriados)*0.083333;
            $tot_a_vacs=round($tot_a_vacs,2);
            $total_acum=$total_dev2 + $extra_tot+ $tot_a_vacs + $tot_a_vacs+$act_extra_tot/*Total de las actividades extras*/;
            $tot_inss=$total_acum-round($tot_a_vacs,2)-$alim_tot;                                                                                          /*******************/
            $total_inss=($total_acum-$tot_a_vacs-$alim_tot);
            if($trabajador->nss>0){
              $inss=($total_inss*$inss_camp)/100;
            }
            else{
              $inss=0;
            }
            $inss_pat=($total_inss*$inss_patronal)/100;
            $tot_recib=$total_acum - $inss - $prestamo;
            
              $tot_recib=$total_acum-$prestamo;
            $f=0;
            $c=0;
          }
          $feriado_nt=$feriado1*$valor_dia;
          $feriado_t=$feriado2*($valor_dia*2);
          $feriados=$feriado_t+$feriado_nt;
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
            //'aa_var1'=>$test1,
            //  'aa_var2'=>$test2,
            "id_trab"=>$id_trab,
            "dias"=>$dias,
            "alim_tot"=>round($alim_tot,2),
            "vac_tot"=>round($tot_a_vacs,2),
            "agui_tot"=>round($tot_a_vacs,2),
            "nombre"=>$nombre,
            'n_inss'=>$trabajador->nss,
            "labores"=>$labores,
            "total_deven"=>round($tot_dev,2),
            "total_basic"=>round($tot_basic,2),
            "horas_ext_tot"=>round($extra_tot,2),
            "cant_horas_ext"=>round($cant_horas_ext,2),
            "cant_act_ext"=>round($cant_act_ext,2),
            "cuje_ext_tot"=>round($cuje_ext_tot,2),
            "act_extra_tot"=>round($act_extra_tot,2),
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
            "feriados"=>round($feriados,2),
            "devengado2"=>round($total_dev2,2),
            "sum_tot_recib"=>round($sum_tot_recib,2),
            "prestamos"=>round($prestamo,2),
            "fecha_ini"=>$fecha_ini,
            "fecha_fin"=>$fecha_fin,
            'dinero_cuje'=>round($dinero_cuje,2),
            'dinero_safa'=>round($dinero_safa,2),
            'tot_cuje_peq'=>$tot_cuje_peq,
              'tot_safa_peq'=>$tot_safa_peq,
              'tot_cuje_gran'=>$tot_cuje_gran,
              'tot_safa_gran'=>$tot_safa_gran,
          ];

          if($array['n_inss']==0){ //sino tiene inss
            $valor_inss=0;
            $v1+=1;
            $sin_inss[]=$array;
          }
          else{ //si tiene inss
            $v2+=1;
            $con_inss[]=$array;
          }
        $trabajadores[]=$array;
        unset($labores);
        unset($fincas);
        unset($fincas_sinRep);
      }/*Fin Si no esta repetido*/
    }//Fin For de recorrer toda la planilla
    //return $inss_recibido;
    if($inss_recibido==2){
      return $trabajadores;
    }
    elseif($inss_recibido==1){
      return $con_inss;
    }
    elseif($inss_recibido==0){
      return $sin_inss;
    }
    return $trabajadores;

  }//E

  public function eliminar(Request $request){
    $catorcenal = Preplanilla::find($request['id']);
    $catorcenal->delete();
    return 'Eliminada';

  }

public function estilos_planilla($data){
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha_ini=$data['0']['fecha_ini'];
    $fecha_fin=$data['0']['fecha_fin'];
    $fecha_1=date("d-m-Y", strtotime("$fecha_ini + 1 days"));
    $dia_ini=date("d", strtotime($fecha_1));
    $mes_ini=date("m", strtotime($fecha_1));
    $ano="2017";//date("Y", strtotime($fecha_1));
    $fecha_2=date("d-F-Y", strtotime("$fecha_fin"));
    $dia_fin=date("d", strtotime($fecha_2));
    $mes_fin=date("m", strtotime($fecha_2));
    $i=0;
    $encabezado='<!DOCTYPE html>
    <html>
      <head>
          <style type="text/css">
              /*(bootstrap source)*/
          </style>
          <style type="text/css">
              .cabecera {
                  text-align: center;
                  /*margin-bottom: 20px;*/
                  height: 70px;
                  padding:0;
                  margin-bottom: 0;
                  opacity: 1;
                  font-size:13px;
              }
              h4{
                padding: 2px;
                margin: 1px;
              }
          </style>
      </head>
      <body>
          <div class="cabecera">
            <h4>TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
            <h4>PLANILLA GENERAL</h4>
            <h4>Planilla de pago del '
             .$dia_ini.' de '.$meses[$mes_ini-1].' al '.$dia_fin. ' de ' .$meses[$mes_fin-1]. ' del '.$ano.
            '</h4>
          </div>
      </body>
    </html>';
    return $encabezado;
  }




}
