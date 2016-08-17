<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Variable;


class VariablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $variables= Variable::all();
      return response()->json($variables);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      return 'yeah';
      $peticion = $request->all();
      $arreglo = $peticion["data"];

      $variable = new Variable($arreglo);
      $variable->save();
      return "Valores Actualizados!";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

      $variable = Variable::find($id);

      $variable->sal_diario = $arreglo['sal_diario'];
      $variable->alimentacion = $arreglo['alimentacion'];
      $variable->vacaciones = $arreglo['vacaciones'];
      $variable->inss_campo = $arreglo['inss_campo'];
      $variable->inss_admin = $arreglo['inss_admin'];
      $variable->cuje_peq = $arreglo['cuje_peq'];
      $variable->cuje_grand = $arreglo['cuje_grand'];
      $variable->hora_ext = $arreglo['hora_ext'];
      $variable->septimo = $arreglo['septimo'];
      $variable->inss_patron = $arreglo['inss_patron'];
      $variable->safadura = $arreglo['safadura'];
      $variable->save();
      return "Registro Actualizado";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $variable = Variable::find($id);
      $variable->delete();
      return "Registro Eliminado";
    }
}
