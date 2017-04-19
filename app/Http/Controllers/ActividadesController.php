<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Actividad;
use App\Finca;
use App\Preplanilla;
use App\Trabajador;
use App\Labor;
use App\Variable;
use App\Lote;
use DB;
class ActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividad= Actividad::all();
        return response()->json($actividad);
    }
    /**************************Para devolver la actividad segun su finca********************************/
    public function actividad_por_finca(Request $request){
        $id_act=Actividad::where('id_finca',$request->all())->get();
        return response()->json($id_act);
    }
    public function create()
    {
        /*enviar ultimo valor de actividades*/
        $id = Actividad::all()->max('id');
        $query = Actividad::find($id);
        return $query;
    }
    public function store(Request $request){
        $peticion = $request->all();
        $arreglo = $peticion["data"];

        $actividad = new Actividad($arreglo);
        $actividad->save();
        $id = Actividad::all()->max('id');
        $query = Actividad::find($id);
        $ultimo=[
          "nombre_actividad"=>$query->nombre,
          "id_actividad"=>$query->id,
          "labores"=>[]
        ];
        return $ultimo;
    }
    public function show($id){
        $actividad = Actividad::find($id);
        $actividad ->finca->nombre;
        return response()->json($actividad);
    }
    public function edit($id){
        //
    }
    public function update(Request $request, $id){
        $peticion = $request->all();
        $arreglo = $peticion["data"];
        $actividad = Actividad::find($id);
        $actividad->nombre = $arreglo['nombre'];
        $actividad->id_finca = $arreglo['id_finca'];
        $actividad->save();
        return "Done!";
    }
    public function destroy($id){
        $actividad = Actividad::find($id);
        $actividad->delete();
        return "Registro Eliminado";
    }
    public function reporteAct(Request $request){
      //return $request;
      $data =app('App\Http\Controllers\FincasController')->calculo_finca($request);
      // $labor_trab=$data['4']['labores'];
      // foreach ($labor_trab as $labs) {
      //   return $labs;
      // }
      $peticion=$request; $fecha_ini=$peticion['fecha_ini']; $fecha_fin=$peticion['fecha_fin']; $id_finca=$peticion['id_finca'];
      $centro_costo=$peticion['centro_costo']; $nombre_cc=$peticion['nombre_cc']; $variables=Variable::all();
      foreach ($variables as $variable) {
        $alim_var=$variable->alimentacion; $valor_dia= $variable->sal_diario; $cuje_grand= $variable->cuje_grand; $cuje_peq= $variable->cuje_peq;
         $vacaciones=$variable->vacaciones/100; $pago_dia=$variable->sal_diario;
      }
      $planillas= Preplanilla::whereBetween('fecha', [$fecha_ini, $fecha_fin]) /***********Buscar en preplanilla segun el rango de fecha*************/
                              ->where('id_finca',$id_finca)
                              ->where('centro_costo',$centro_costo)
                                ->get();
      $tamano = sizeof($planillas); $trabajadores=array(); $identif=array(); $trab=0; $count=0;
        for ($i=0; $i < $tamano; $i++) { /*Recorre toda la planilla*/
          $id_trab=$planillas[$i]->id_trabajador;//Asigna el id del trabajador que esta recorriendo en la planilla actualmente
          $valor=in_array($id_trab, (array)$identif);//si ya existe la finca en el arreglo
          $converted_res = ($valor) ? 'true' : 'false';
          if ($converted_res=='false') { //Sino esta repetido3
            /*******************************************Capturar todas las labores(actividades) de ese Centro de costos***********************************************/
            $actividad = DB::table('fincas')
            ->join('actividades', 'fincas.id', '=', 'actividades.id_finca')
            ->select('actividades.id', 'actividades.nombre')
            ->where('fincas.id',$id_finca)
            ->where('actividades.nombre','like',$nombre_cc)
            ->get();
            $id_activ=$actividad[0]->id;
            $array1=array();
            $array2=array();
            $lab_array=array();
            $tamano=sizeof($data);
            $labores2=Labor::where('id_actividad',$id_activ)->get();
            foreach ($labores2 as $labor2) {
              $labores[]=$labor2['nombre'];
              $array1=[
              'nombre'=>$labor2['nombre'],
              'total'=>0,
              'cantidad'=>0,
              'tot_dias'=>$data[$tamano-1]['sum_dias_trab'],
              'tot_acum'=>$data[$tamano-1]['sum_acum'],
            ];
              $lab_array[]=$array1;
            }
            $var=0;

            $tamano=sizeof($data);
            $contad=0;
            $arraytest=array();
            $arraytest2=array();
            foreach ($data as $dat) {
              if($dat!=$data[$tamano-1]){
                $total_acum=$data[$tamano-1]['sum_acum'];
                $labor_trab=$dat['labores'];
                $tot_labores=sizeof($labor_trab);

                foreach ($labor_trab as $lab_ind) {
                  $acum_ind=$dat['total_acum'];
                  $arraytest=[
                  'nombre'=>$lab_ind,
                  'total'=>$acum_ind/$tot_labores,
                  ];
                  $arraytest2[]=$arraytest;
                }

                foreach ($labor_trab as $lab_ind) {
                  $i=-1;
                  $contad++;
                  foreach ($lab_array as $lab_tot) {
                    $i++;
                    if($lab_ind==$lab_tot['nombre']){
                      $cantid=$lab_array[$i]['cantidad']+1;
                      // $cant_2=$cantid;
                      $lab_array[$i]['cantidad']=$cantid;
                      $acum_por_act=$dat['total_acum']/$tot_labores;
                      $total_ant=$lab_tot['total'];
                      $tot_nuevo=$total_ant+$acum_por_act;
                      $array1=[
                      'nombre'=>$lab_tot['nombre'],
                      'total'=>$tot_nuevo,
                      ];
                      $lab_array[$i]['total']=$tot_nuevo;
                      //return $array1;
                      //$lab_array[$i]=$array1;
                    }
                  }
                  /**********4*********/
                }
              }
              else{
                $dias_general=$lab_array['0']['tot_dias'];
                $i=-1;

                $tot=0;
                $tot_dias=0;
                $ultimo_tot=array();
                foreach ($lab_array as $mast) {//quito los repetidos
                  if (in_array($mast, $ultimo_tot)){}else{$ultimo_tot[]=$mast;}
                }
                $master=array();
                $dias_ind=0;
                foreach ($ultimo_tot as $total) {//elimino los valores en 0 y sumo los valores
                  //$tot+=$total['total'];
                  $dias_ind+=$total['cantidad'];
                  if($total['total']!=0){
                    $master[]=$total;
                  }
                }
                $k=0;
                foreach ($master as $master2) {
                  $porc=($master2['cantidad']*100)/$dias_ind;
                  $tot2= ($porc*$master[0]['tot_acum'])/100;
                  $tot+=$tot2;
                  $porc_cant=($master2['cantidad']*100)/$dias_ind;
                  $cantid=round(($porc_cant*$master2['tot_dias'])/100 , 0);
                  $tot_dias+=$cantid;
                  // $tot2=$total_acum/$master2['cantidad'];
                  $master[$k]['total']=$tot2;
                  $master[$k]['tot_dias']=$cantid;
                  $k++;
                }

                $master[]=$dias_general;
                $master[]=$tot;
                return $master;
              }
            }
            $sum=0;
            $tamano=sizeof($data);
            /****************************Aqui va lo cortado********************************/
          }            return $master;
      //Fin de saber sino esta repetido 3
                 //return $lab_comp;

        }
     }
    public function reporte_cujesafa(Request $request){
      //return 'hola shennier';
      $fecha_ini=$request['fecha_ini'];
      $fecha_fin=$request['fecha_fin'];
      $variables=Variable::all();
      $var= $variables[0];
      $val_cuje_gran=$var['cuje_grand'];
      $val_cuje_peq=$var['cuje_peq'];
      $val_safa_gran=$var['safa_grand'];
      $val_safa_peq=$var['cuje_grand'];
      $cuje_peq= Preplanilla::where('tamano_cuje',0)
      ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
      ->where('cuje_ext','>',0)
      ->sum('cuje_ext');

      $cuje_gran= Preplanilla::where('tamano_cuje',1)
      ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
      ->where('cuje_ext','>',0)
      ->sum('cuje_ext');

      $safa_peq= Preplanilla::where('tamano_safa',0)
      ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
      ->where('safa_ext','>',0)
      ->sum('safa_ext');

      $safa_gran= Preplanilla::where('tamano_safa',1)
      ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
      ->where('safa_ext','>',0)
      ->sum('safa_ext');


      $total_activs=$safa_peq+$cuje_peq+$safa_gran+$cuje_gran;

      $tot_cant_safa_peq =$safa_peq*$val_safa_peq;
      $tot_cant_cuje_peq =$cuje_peq*$val_cuje_peq;
      $tot_cant_safa_gran=$safa_gran*$val_safa_gran;
      $tot_cant_cuje_gran=$cuje_gran*$val_cuje_gran;
      $total_dinero=$tot_cant_safa_peq+$tot_cant_cuje_peq+$tot_cant_safa_gran+$tot_cant_cuje_gran;
      $totales=[
        'cant_safa_peq'=>$safa_peq,
        'cant_cuje_peq'=>$cuje_peq,
        'cant_safa_gran'=>$safa_gran,
        'cant_cuje_gran'=>$cuje_gran,
        'tot_cant_safa_peq'=>$tot_cant_safa_peq ,
        'tot_cant_cuje_peq'=>$tot_cant_cuje_peq ,
        'tot_cant_safa_gran'=>$tot_cant_safa_gran,
        'tot_cant_cuje_gran'=>$tot_cant_cuje_gran,
        'total_dinero'=>$total_dinero,
        'total_activs'=>$total_activs,
      ];
      return $totales;
    }

}
