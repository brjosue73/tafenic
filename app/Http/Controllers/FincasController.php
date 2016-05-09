<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Finca;
use App\Preplanilla;
use App\Trabajador;

class FincasController extends Controller
{
    /**********Mostrar el reporte de planilla por finca y fecha************/
    public function planilla_finca(Request $request){
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
           $name='';
             foreach ($trabs as $trab) {
                 $salario=$trab->salario_acum;
                 $salario_tot += $salario;
                 $alim=$trab->alimentacion;
                 $alim_tot += $alim;
                 $vac= $trab->vacaciones;
                 $vac_tot += $vac;
                 $agui_tot= $vac_tot;
                 $extras=$trab->total_extras;
                 $extra_tot += $extras;
             }

             $array = [
               "id_trab"=>$id_trab,
               "dias"=>$dias,
               "salario_tot"=>$salario_tot,
               "alim_tot"=>$alim_tot,
               "vac_tot"=>$vac_tot,
               "agui_tot"=>$agui_tot,
               "extra_tot"=>$extra_tot
             ];

          $trabajadores[]=$array;
          $trab=$id_trab;
        }
      }
      return $trabajadores;

//pegar aca
            //return $array_tot;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return "Finca Agregada!";
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
