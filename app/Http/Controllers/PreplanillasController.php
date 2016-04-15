<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Preplanilla;

class PreplanillasController extends Controller
{
     public function index()
    {
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prep=Preplanilla::find(1);
        $prep->trabajador;
        $prep->finca;
        $prep->actividad;
        $prep->labor;
        $prep->lote;
        $prep->listero;
        $prep->resp_finca;

        return $prep;
        //enviar los datos de la preplanilla para que aparezcan en los combo box 
        
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

        $labor = new Preplanilla($arreglo);
        $labor->save();
        return "Agregada!";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $labor = Preplanilla::find($id);
        return response()->json($labor);
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

        $preplanilla = Preplanilla::find($id);

        $preplanilla->id_trabajador = $arreglo['id_trabajador'];
        $preplanilla->id_finca = $arreglo['id_finca'];
        $preplanilla->id_actividad = $arreglo['id_actividad'];
        $preplanilla->id_labor = $arreglo['id_labor'];
        $preplanilla->fecha = $arreglo['fecha'];
        $preplanilla->lote = $arreglo['lote'];
        $preplanilla->id_listero = $arreglo['id_listero'];
        $preplanilla->id_respFinca = $arreglo['id_respFinca'];
        $preplanilla->cantidad = $arreglo['cantidad'];
        $preplanilla->hora_ext = $arreglo['hora_ext'];
        $preplanilla->actividad_ext = $arreglo['actividad_ext'];
        $preplanilla->save();
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
        $preplanilla = Preplanilla::find($id);
        $preplanilla->delete();
        return "Registro Eliminado";
    }
}
