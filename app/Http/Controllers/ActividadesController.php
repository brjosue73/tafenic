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
          if ($converted_res=='false') { //Sino esta repetido
            $identif[]=$id_trab;
            $trabs2= Preplanilla::where('id_trabajador',$id_trab) /*Todas las preplanillas de ese trabajador en ese rango de fecha en esa finca*/
                    ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                    ->where('id_finca',$id_finca)
                    ->where('centro_costo',$centro_costo)
                    ->get();
            $trab_septimo= Preplanilla::where('id_trabajador',$id_trab) /*Todas las preplanillas de ese trabajador en ese rango de fecha*/
                    ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                    ->get();
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

            $labores=Labor::where('id_actividad',$id_activ)->get();
            return $labores;
            foreach ($labores as $lab) {
              $trabs= Preplanilla::whereBetween('fecha', [$fecha_ini, $fecha_fin])
                      //->where('id_finca',$id_finca)
                      //->where('centro_costo',$centro_costo)
                      ->where('id_actividad',$id_activ)
                      ->where('id_labor',$lab->id)
                      ->get();
              if (sizeof($trabs)>0) {
                $array1[]=$trabs;
                $contar_dias=app('App\Http\Controllers\PlanillasController')->contar_dias($trabs);
                $dias=$contar_dias['dias'];
                $dias_sept=$contar_dias['dias_sept'];

                $dias_sept=$trab_septimo->count();$salario_tot=0;$alim_tot=0;$vac_tot=0;$agui_tot=0;$extra_tot=0;$horas_ext_tot=0;
                $cuje_ext_tot=0;$total_dev2=0;$septimo=0;$otros=0;$feriados=0;$feriado_tot=0;$tot_dev=0;$subsidios=0;
                $cant_horas_ext=0;$act_extra_tot=0;$cant_act_ext=0;$sum_tot_recib=0;$prestamo=0;$feriado1=0;$feriado2=0;

                foreach ($trabs as $trab) {
                  $feriados+=$trab->feriados;
                  if($trab->tipo_feriado==1){//Feriado no trabajado
                    $feriado1+=1;
                  }
                  if($trab->tipo_feriado==2){//Feriado no trabajado
                    $feriado2+=1;
                  }
                }
                $calculo_septimo=[
                  'id_finAct'=>$peticion['id_finca'],
                  'centro_act'=>$peticion['centro_costo'],
                  'plani_trab'=>$trab_septimo,
                  'fecha_fin'=>$fecha_fin,
                  'fecha_ini'=>$fecha_ini,
                  'id_trab'=>$id_trab,
                  'valor_dia'=>$valor_dia,
                  'id_finca'=>$id_finca,
                  'feriados'=>$feriados,
                  'dias'=>$dias,
                ];

                $calculo_septimo=app('App\Http\Controllers\FincasController')->calcular_septimos($calculo_septimo);

                $cant_septimos=$calculo_septimo['dias_sept'];

                $trabajador=Trabajador::find($id_trab);
                $nombres=$trabajador->nombre;
                $apellido=$trabajador->apellidos;
                $nombre="$nombres $apellido";

                $tot_sept=$calculo_septimo['tot_sept'];
                $test1=$dias;
                $feriado_nt=$feriado1*$valor_dia;
                $feriado_t=$feriado2*($valor_dia*2);
                $feriados=$feriado_t+$feriado_nt;
                //Sumar los valores de total y agregarlos al array 1-> incluyendo los septimos y dias trabs
                //agregarlos al array 1 (La suma de los valores)
              }//Fin Si hay valores en esa actividad

             }//Fin del foreach de las actividades
             $array2[]=$array1;

           }//Fin de saber sino esta repetido
           return $array2;
        }
    }
}
