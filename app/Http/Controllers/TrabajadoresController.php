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
      //agregar el request
    public function prep_trab(Request $request){
      //$peticion = $request->all();
      $arreglo = $request->all();//$peticion["data"];
      $id_trab = $arreglo['id_trab'];
      $fecha_ini= $arreglo['fecha_ini'];
      $fecha_fin= $arreglo['fecha_fin'];
      $query= Preplanilla::where('id_trabajador',$id_trab)
                                ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                                ->get();
      return $query;
      //return $arreglo['id_trab'];
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
