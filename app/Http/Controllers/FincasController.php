<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Finca;
use App\Preplanilla;
use App\Trabajador;
use App\Labor;
use App\Variable;
use App\Actividad;
use App\Lote;


class FincasController extends Controller
{

    public function planilla_finca(Request $request){
      $cargo='tcampo';
      $fecha_ini=$request['fecha_ini'];
      $fecha_fin=$request['fecha_fin'];
      $id_finca=$request['id_finca'];
      $variables=Variable::all();
      foreach ($variables as $variable) {
        $alim_var=$variable->alimentacion;
        $valor_dia= $variable->sal_diario;
        $cuje_grand= $variable->cuje_grand;
        $cuje_peq= $variable->cuje_peq;
        $vacaciones=$variable->vacaciones/100;
        $pago_dia=$variable->sal_diario;
      }

      $planillas= Preplanilla::where('id_finca',$id_finca) /***********Buscar en preplanilla segun la finca y segun el rango de fecha*************/
                                ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                                ->get();

      $tamano = sizeof($planillas);
      $trabajadores=array();
      $identif=array();
      $trab=0;
      $count=0;
      $dias=0;
        for ($i=0; $i < $tamano; $i++) { /*Recorre toda la planilla*/
          $id_trab=$planillas[$i]->id_trabajador;//Asigna el id del trabajador que esta recorriendo en la planilla actualmente
          $valor=in_array($id_trab, (array)$identif);//si ya existe la finca en el arreglo
          $converted_res = ($valor) ? 'true' : 'false';
          if ($converted_res=='false') { //Sino esta repetido
            $identif[]=$id_trab;
            $trabs= Preplanilla::where('id_trabajador',$id_trab) /*Todas las preplanillas de ese trabajador en ese rango de fecha*/
            ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
            ->where('id_finca',$id_finca)
            ->get();
                                      //->where('id_finca',$id_finca)

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
             $dias=0;
               foreach ($trabs as $trab) {
                  $dias+=1;
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

                  /**************SEPTIMO**************/
                  //dias trabs en una Finca
                  //saber las fincas unicas en las que trabajo
                  $f=0;
                  $c=0;
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
                    $nombre_finca_quer=Finca::find($id_finca);
                    $nombre_finca=$nombre_finca_quer->nombre;

                    if($finca_mayor==$nombre_finca){
                     $tot_sept=0;
                    }

                  }




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
        usort($trabajadores, function($a, $b) {
          return strcmp($a["nombre"], $b["nombre"]);
            return $a['order'] < $b['order']?1:-1;
        });
        $totales=$this->sum_totales($trabajadores);

        $trabajadores[]=$totales;

        return $trabajadores;
    }
    /**********Mostrar el reporte de planilla por finca y fecha************/
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
         'sum_dias_trab'=>round($sum_dias_trab,2),
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

/************JSON para fincas, labores y actividades*************/
public function datos_fincas(){
  $i=0;
  $fincas_todo=array();
  $fincas = Finca::all();
  $fincas->actividades = array();
  $generales=array();
  $labores=array();
  $lab_tot=array();
  $activ_tot=array();
  $activ=array();
  $lote_tot=array();
  $tot = array();
  foreach ($fincas as $finca) {
    $generales=[
      "id_finca"=>$finca->id,
      "nombre"=>$finca->nombre
    ];

    $id_finca=$finca->id;
    $lote_tot=array();
    $lotes=Lote::where('id_finca',$id_finca)->get();
    foreach ($lotes as $lote) {
      $lote_tot[]=$lote;
    }
    $generales+=[
      "lotes"=>$lote_tot,
    ];
    unset($lote_tot);
    $actividades=Actividad::where('id_finca',$id_finca)->get();
    foreach ($actividades as $actividad) {
      $activ_tot=[
        "id_actividad"=>$actividad->id,
        "nombre_actividad"=>$actividad->nombre,
      ];

      $labores=Labor::where('id_actividad',$actividad->id)->get();
      foreach ($labores as $lab) {
        $lab_tot[]=$lab;
      }
      $activ_tot+=[
        "labores"=>$lab_tot,
      ];
      $activ[]=$activ_tot;
      unset($lab_tot);
      $lab_tot=array();

    }
    $generales+=[
      "actividades"=>$activ,
    ];
    unset($activ);



    $tot[]=$generales;
    unset($activ);
    $activ=array();
    unset($activ_tot);
    //unset($lab_tot);

  }
  return response()->json($tot);
}
/************JSON para fincas, labores y actividades*************/



    public function index() {
        $finca = Finca::all();
        return response()->json($finca);
    }


    public function create()
    {
        /*enviar ultimo valor de Fincas*/
        $id = Finca::all()->max('id');
        $query = Finca::find($id);
        return $query;
        //
    }


    public function store(Request $request)
    {
        $peticion = $request->all();
        $arreglo = $peticion["data"];

        $finca = new Finca($arreglo);
        $finca->estado=1;
        $finca->save();
        $id = Finca::all()->max('id');
        $query = Finca::find($id);
        $ultimo=[
          "nombre"=>$query->nombre,
          "id_finca"=>$query->id,
          "actividades"=>[]
        ];
        return $ultimo;
    }


    public function show($id)
    {
        $finca = Finca::find($id);
        return response()->json($finca);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $peticion = $request->all();
        $arreglo = $peticion["data"];

        $finca = Finca::find($id);

        $finca->nombre = $arreglo['nombre'];
        $finca->estado = $arreglo['estado'];

        $finca->save();
        return "Done!";
    }

    public function destroy($id)
    {
        $finca = Finca::find($id);
        $finca->delete();
        return "Registro Eliminado";
    }
}
