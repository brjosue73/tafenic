<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trabajador;
use App\Preplanilla;

class TrabajadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $trabajadores = Trabajador::all();
      return response()->json($trabajadores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

      //Request $request
    public function prep_trab(){
      //$peticion = $request->all();
      //$arreglo = $request->all();//$peticion["data"];
      //$id_trab = $arreglo['id_trab'];
      $id_trab=2;
      $fecha_ini="2016-01-01";
      $fecha_fin="2017-01-01";
      // $fecha_ini= $arreglo['fecha_ini'];
      // $fecha_fin= $arreglo['fecha_fin'];
      $trabs= Preplanilla::where('id_trabajador',$id_trab)
                                ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                                ->get();
      $dias= $trabs->count();
      $salario_tot=0;
      $alim_tot=0;
      $vac_tot=0;
      $agui_tot=0;
      $extra_tot=0;
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
      // $trabs->dias=$dias;
      // $trabs->salario_tot=$salario_tot;
      // $trabs->alim_tot=$alim_tot;
      // $trabs->vac_tot=$vac_tot;
      // $trabs->agui_tot=$agui_tot;
      // $trabs->extra_tot=$extra_tot;
      $array = [
        "dias"=>$dias,
        "salario_tot"=>$salario_tot,
        "alim_tot"=>$alim_tot,
        "vac_tot"=>$vac_tot,
        "agui_tot"=>$agui_tot,
        "extra_tot"=>$extra_tot
      ];
      $trabs[] = $array;
      return $trabs;
      $todo= array_merge($array2,$array);
      return $todo;
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

      $trabajador = new Trabajador($arreglo);
      $trabajador->save();
      return "Trabajador Creado!";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $trabajador = Trabajador::find($id);
      return response()->json($trabajador);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

       $trabajador = Trabajador::find($id);

       $trabajador->nombre = $arreglo['nombre'];
       $trabajador->nss = $arreglo['nss'];
       $trabajador->cedula = $arreglo['cedula'];
       $trabajador->celular = $arreglo['celular'];
       $trabajador->apellidos = $arreglo['apellidos'];

       $trabajador->save();
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
      $trabajador = Trabajador::find($id);
      $trabajador->delete();
      return "Registro Eliminado";
    }
}
