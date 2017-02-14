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

            $labores2=Labor::where('id_actividad',$id_activ)->get();
            foreach ($labores2 as $labor2) {
              $labores[]=$labor2['nombre'];

              $array1=[
              'nombre'=>$labor2['nombre'],
              'total'=>0,
            ];
              $lab_array[]=$array1;
            }
            $var=0;

            $tamano=sizeof($data);
            foreach ($data as $dat) {
              if($dat!=$data[$tamano-1]){
                $labor_trab=$dat['labores'];
                $tot_labores=sizeof($labor_trab);
                foreach ($labor_trab as $lab_ind) {
                  $i=-1;
                  foreach ($lab_array as $lab_tot) {
                    $i++;
                    if($lab_ind==$lab_array[$i]['nombre']){
                      $acum_por_act=$dat['total_acum']/$tot_labores;
                      $var+=$acum_por_act;
                      $total_ant=$lab_array[$i]['total'];
                      $tot_nuevo=$total_ant+$acum_por_act;
                      $array1=[
                      'nombre'=>$lab_array[$i]['nombre'],
                      'total'=>$tot_nuevo,
                      ];
                      //return $array1;
                      $lab_array[$i]=$array1;
                    }
                  }
                }
              }
              else{
                $tot=0;
                foreach ($lab_array as $total) {
                  $tot+=$total['total'];
                }

                $lab_array[]=$tot;
                //return 'total: '.$tot . 'suma: '. $dat['sum_acum'];

                return $lab_array;
              }
            }
            $sum=0;
            $tamano=sizeof($data);
            /****************************Aqui va lo cortado********************************/
          }            return $lab_array;
//Fin de saber sino esta repetido 3
           //return $lab_comp;

        }
    }
}
