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
    /**********Mostrar el reporte de planilla por finca y fecha************/
    public function planilla_finca(Request $request){
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
      $array_tot=[];
      $peticion=$request->all();
      $arreglo = $request->all();//$peticion["data"];
      $id_finca = $arreglo['id_finca'];
      // $id_finca=2;
      // $fecha_ini="2016-01-01";
      // $fecha_fin="2017-01-01";

      $fecha_ini= $arreglo['fecha_ini'];
      $fecha_fin= $arreglo['fecha_fin'];
      $fincas= Preplanilla::where('id_finca',$id_finca) /***********Buscar en preplanilla segun la finca y segun el rango de fecha*************/
                                ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                                ->get();
      //return $fincas;
      $tamano = sizeof($fincas);
      $trabajadores=array();
      $trab=0;

      for ($i=0; $i < $tamano; $i++) {
        $id_trab=$fincas[$i]->id_trabajador;

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

/************JSON para fincas, labores y actividades*************/
public function datos_fincas()
{
  $i=0;
  $fincas_todo=array();
  $fincas = Finca::all();
  $generales=array();
  $labores=array();
  $lab_tot=array();
  $activ_tot=array();
  $activ=array();
  $lote_tot=array();
  foreach ($fincas as $finca) {
    $generales=[
      "id_finca"=>$finca->id,
      "nombre"=>$finca->nombre,
    ];
    $id_finca=$finca->id;
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

    $lotes=Lote::where('id_finca',$finca->id)->get();
    foreach ($lotes as $lote) {
      $lote_tot[]=$lote;
    }
    $generales+=[
      "lotes"=>$lote_tot,
    ];

    $tot[]=$generales;
    unset($activ);
    $activ=array();
    unset($activ_tot);
    //unset($lab_tot);

  }
  return response()->json($tot);
}

/************JSON para fincas, labores y actividades*************/



    public function index()
    {
        $finca = Finca::all();
        return response()->json($finca);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*enviar ultimo valor de Fincas*/
        $id = Finca::all()->max('id');
        $query = Finca::find($id);
        return $query;
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $peticion = $request->all();
        $arreglo = $peticion["data"];

        $finca = new Finca($arreglo);
        $finca->estado=1;
        $finca->save();
        $id = Finca::all()->max('id');
        $query = Finca::find($id);
        return $query;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finca = Finca::find($id);
        return response()->json($finca);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $finca = Finca::find($id);
        $finca->delete();
        return "Registro Eliminado";
    }
}
