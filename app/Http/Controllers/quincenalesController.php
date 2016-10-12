<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Quincenal;
use App\Variable;
use App\Trabajador;
use App\Finca;
class QuincenalesController extends Controller
{
    public function quincenal_fecha(Request $request){
      $peticion=$request->all();
            $data =$this->planilla_quincenal($peticion);
            $totales=$this->sum_totales($data);
            $data[]=$totales;
            return $data;
    }
    public function reporte_quincenal(Request $request){
      $funcion=$request['funcion'];
      if ($funcion == 'Generar Imprimible')
      {
        $peticion=$request->all();
        $data =$this->planilla_quincenal($peticion);
        $totales=$this->sum_totales($data);
        $view = \View::make('reporte_quincenal',array('data'=>$data,'totales'=>$totales)); // recuerden que data es la variable del arreglo
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->stream('invoice');
      }
      elseif ($funcion == 'Generar sobres')
      {
        $peticion=$request->all();
        $data =$this->planilla_quincenal($peticion);
        $view = \View::make('sobres_quincenal',array('data'=>$data));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $paper_size = array(0,0,360,360);
        $pdf->setPaper($paper_size,'landscape');
        //$pdf->setPaper('a4', 'landscape');
        return $pdf->stream('invoice');
        return $pdf->stream();
      }
      elseif($funcion == 'Billetes'){
        $peticion=$request->all();
          //$data =$this->billetes($peticion);
          $planillas=$this->planilla_quincenal($peticion);
          $data =$this->calcular_billetes($planillas);
          $totales=$data['total_individual'];
          $view = \View::make('billetes_quincenal',array('data'=>$data,'totales'=>$totales));
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($view);
          $pdf->setPaper('a4', 'landscape');
          return $pdf->stream('invoice');
          return $pdf->stream();
      }
      elseif ($funcion == 'reporte_inss') {
        $peticion=$request->all();
        $tot=array();
        // $peticion=[
        //   "fecha_ini"=>'2016-01-01',
        //   'fecha_fin'=>'2017-01-01',
        // ];
        $datas=$this->planilla_quincenal($peticion);
        foreach ($datas as $data) {
          $id=$data['id_trabajador'];
          $trabajador= Trabajador::find($id);
          $sep_nombre=explode(' ', $trabajador->nombre);
          $sep_ape=explode(' ', $trabajador->apellidos);
          $nombre="'".$sep_nombre[0];
          $apellido="'".$sep_ape[0];

          $array=[
            "nss"=>$trabajador->nss,
            "pnombre"=>$nombre,
            "papellido"=>$apellido,
            "t_devengado"=>$data['total_pagar'],

          ];
          $tot[]=$array;
        }
        return view('inss_quincenal')->with('data',$tot);
        return $tot;

      }
    }
    public function billetes(Request $request){
      $peticion=$request->all();
      $planillas=$this->planilla_quincenal($peticion);
      $data =$this->calcular_billetes($planillas);
      return $data;
    }
    public function sum_totales($data){
     $sum_dev = 0;
     $sum_dias = 0;
     $sum_h_ext =0;
     $sum_inatec=0;
     $sum_inss_lab=0;
     $sum_inss_pat=0;
     $sum_ir=0;
     $sum_otros=0;
     $sum_prestamos=0;
     $sum_salario=0;
     $sum_subsidios=0;
     $sum_feriados=0;
     $sum_basico=0;
     $sum_tot_hext=0;
     $sum_sum_pagar=0;
     $sum_dev=0;
     foreach ($data as $plani) {
       $sum_dev += $plani['devengado'];
       $sum_dias += $plani['dias_trab'];
       $sum_h_ext +=$plani['horas_extra'];
       $sum_inatec+=$plani['inatec'];
       $sum_inss_lab+=$plani['inss_laboral'];
       $sum_inss_pat+=$plani['inss_patronal'];
       $sum_ir+=$plani['ir'];
       $sum_otros+=$plani['otros'];
       $sum_prestamos+=$plani['prestamos'];
       $sum_salario+=$plani['salario_quinc'];
       $sum_subsidios+=$plani['subsidios'];
       $sum_feriados+=$plani['feriados'];
       $sum_basico+=$plani['basico_real'];
       $sum_tot_hext+=$plani['tot_h_ext'];
       $sum_sum_pagar+=$plani['total_pagar'];
     }
     $totales=  [
       'sum_dev'=>$sum_dev,
       'sum_dias'=>$sum_dias,
       'sum_h_ext'=>$sum_h_ext,
       'sum_inatec'=>$sum_inatec,
       'sum_inss_lab'=>$sum_inss_lab,
       'sum_inss_pat'=>$sum_inss_pat,
       'sum_ir'=>$sum_ir,
       'sum_otros'=>$sum_otros,
       'sum_prestamos'=>$sum_prestamos,
       'sum_salario'=>$sum_salario,
       'sum_subsidios'=>$sum_subsidios,
       'sum_feriados'=>$sum_feriados,
       'sum_basico'=>$sum_basico,
       'sum_tot_hext'=>$sum_tot_hext,
       'sum_sum_pagar'=>$sum_sum_pagar,
     ];
     return $totales;
   }
    public function planilla_quincenal($peticion){
      //RETOR$NAR la planilla de quincenales
      // $peticion = $request->all();
      $fecha_ini=$peticion['fecha_ini'];
      $fecha_fin=$peticion['fecha_fin'];
      $tipo=$peticion['tipo'];
      // $tipo='servicios tecnicos';
      // $fecha_ini='2016-06-10';
      // $fecha_fin='2016-06-25';
      $planilla=Quincenal::where('fecha_ini','>=',$fecha_ini)
                ->where('fecha_fin','<=',$fecha_fin)
                //whereBetween('fecha_ini', [$fecha_ini, $fecha_fin])
                //->whereBetween('fecha_fin', [$fecha_ini, $fecha_fin])
                ->where('tipo',$tipo)
                ->get();
        foreach ($planilla as $plan){
            $id= $plan['id_trabajador'];
            $trabajador=Trabajador::find($id);
            $nom=$trabajador['nombre'];
            $ape=$trabajador['apellidos'];
            $nombre=$nom.' '.$ape;
            $fincas=Finca::find($plan['id_finc']);
            $finca=$fincas['nombre'];
            $plan->finca=$finca;
            $cargo=$trabajador['cargo'];
            $inss=$trabajador['nss'];
            $plan->inss=$inss;
            $plan->cargo=$cargo;
            $plan->nombre=$nombre;
            $planillas[]=$plan;
        }
        if (isset($planillas)){
          return $planillas;
        }
        else {
          return '$No hay datos';
        }
        //return response()->json($planilla);
    }
    public function calcular_billetes($planillas){
      foreach ($planillas as $planilla) {
        $nums[]=$planilla['total_pagar'];
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
    public function g_quincenal(Request $request){
      $variables=Variable::all();
      foreach ($variables as $variable) {
        $inss_admin=$variable->inss_admin;
        $inss_patron=$variable->inss_patron;
      }
      $peticion = $request->all();
      $arreglo = $peticion;
      $planilla = new Quincenal($arreglo);
      $dias_trab=$arreglo['dias_trab'];
      $salario_quinc=$arreglo['salario_quinc'];
      $finca=$arreglo['id_finc'];
      $planilla->id_finc=$finca;
      $salario_dia2=$salario_quinc/15;
      $salario_dia=round($salario_dia2,4);
      $planilla->basico=$salario_quinc; //Salario Quincenal
      $sal_hora=$salario_dia/8;
      $feriados1=$arreglo['feriado_trab'];//cuenta en los dias trab + valor del feriado
      $feriados2=$arreglo['feriado_ntrab'];//no cuenta como dia trabajado
      $feriados=$feriados1+$feriados2;
      $feriados_n_trab=$feriados2*$salario_dia;
      $feriados_trab=($feriados1*$salario_dia)*2;
      $feriado_tot2=$feriados_n_trab+$feriados_trab;
      $feriado_tot=round($feriado_tot2,2);
      $dias_menosfer=$dias_trab;

      $basico2=$dias_menosfer*$salario_dia;//menos los feriados y los subsidios, porque ya hay una caja de texto
      $basico=round($basico2, 2);
      $planilla->basico_real=$basico; //total de dias por salario por dias_trab
      $prueb=$basico+$feriado_tot;
      $planilla->feriados=$feriado_tot;
      $otros=$arreglo['otros'];
      $subsi=$arreglo['subsidios'];
      $tot_sub2=$subsi*$salario_dia;
      $tot_sub=round($tot_sub2, 2);
      $horas_ext=$arreglo['horas_ext'];
      $planilla->horas_extra=$horas_ext;
      $tot_h_ext2=$horas_ext*($sal_hora*2);
      $tot_h_ext=round($tot_h_ext2,2);
      $planilla->tot_h_ext=$tot_h_ext;
      $devengado=round($basico+$feriado_tot+$otros+$subsi+$tot_h_ext,2);
      $planilla->devengado=$devengado;
      $inss_lab2=(($devengado-$subsi)*$inss_admin)/100;
      $inss_lab=round($inss_lab2,2);
      $planilla->inss_laboral=$inss_lab;
      $quinc_i=round($devengado-$inss_lab,2);
      $devengado_mensual=$quinc_i*2;
      $dev_anual=$devengado_mensual*12;
      $IR=0;
      if($dev_anual<=10000){
        $IR=0;
      }
      elseif ($dev_anual>=100000.01 && $dev_anual<=200000) {
        $dev_sobre=$dev_anual-100000;
        $dev_por=($dev_sobre*15)/100;
        $imp_base=0;
        $ir_anual=$dev_por+$imp_base;
        $IR=$ir_anual/24;
      }
      elseif ($dev_anual>=200000.01 && $dev_anual<=350000) {
        $dev_sobre=$dev_anual-200000;
        $dev_por=($dev_sobre*20)/100;
        $imp_base=15000;
        $ir_anual=$dev_por+$imp_base;
        $IR=$ir_anual/24;
      }
      elseif ($dev_anual>=350000.01 && $dev_anual<=500000) {
        $dev_sobre=$dev_anual-350000;
        $dev_por=($dev_sobre*25)/100;
        $imp_base=45000;
        $ir_anual=$dev_por+$imp_base;
        $IR=$ir_anual/24;
      }
      elseif ($dev_anual>=500000.01) {
        $dev_sobre=$dev_anual-500000;
        $dev_por=($dev_sobre*30)/100;
        $imp_base=82500;
        $ir_anual=$dev_por+$imp_base;
        $IR=$ir_anual/24;
      }
      $prestamo=$arreglo['prestamos'];
        $total_pagar=round($devengado-$inss_lab-$IR-$prestamo,2);
        $planilla->ir=$IR;
        $inss_patronal2=($devengado*$inss_patron)/100;
        $inss_patronal=round($inss_patronal2,2);
        $inatec2=(($devengado-$subsi)*2)/100;
        $inatec=round($inatec2,2);
        $planilla->total_pagar=$total_pagar;
        $planilla->inss_patronal=$inss_patronal;
        $planilla->inatec=$inatec;
        $planilla->save();
        return $planilla;
    }
    public function calculo_ir($devengado){
      return $IR;
    }
    // public function sobres_quincenal(Request $request){
    //   $peticion=$request->all();
    //   $data =$this->planilla_quincenal($peticion);
    //
    //   $view = \View::make('sobres_quincenal',array('data'=>$data));
    //   $pdf = \App::make('dompdf.wrapper');
    //   $pdf->loadHTML($view);
    //   $pdf->setPaper('legal', 'landscape');
    //   return $pdf->stream('invoice');
    //   return $pdf->stream();
    // }

    public function editar_quince(Request $request){
      $id=$request->id;
      $planilla=Quincenal::find($id);
      return $planilla;
    }
}
