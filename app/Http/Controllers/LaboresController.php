<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\labor;

class LaboresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labores= Labor::all();
        return response()->json($labores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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

        $labor = new Labor($arreglo);
        $labor->save();
        return "Labor Agregada!";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $labor = Labor::find($id);
        $labor->actividad;
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

        $labor = Labor::find($id);

        $labor->nombre = $arreglo['nombre'];
        $labor->id_actividad = $arreglo['id_actividad'];

        $labor->save();
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
        $labor = Labor::find($id);
        $labor->delete();
        return "Registro Eliminado";
    }
}
