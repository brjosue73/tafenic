<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lote;

class LotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**************************Para devolver el lote segun su finca********************************/
    public function lotes_por_finca(Request $request){

        $peticion = $request->all();
        $arreglo= $peticion["data"];

        $id_act=Lote::where('id_finca',$arreglo->id_finca)->get();
        return response()->json($id_act);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*enviar ultimo valor de Lotes*/
        $id = Lote::all()->max('id');
        $query = Lote::find($id);
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
        $arreglo= $peticion ["data"];

        $lote = new Lote($arreglo);
        $lote->save();
        /*enviar ultimo valor de Lotes*/
        $id = Lote::all()->max('id');
        $query = Lote::find($id);
        return $query;
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lote = Lote::where('id_finca', $id)->get();
        return response()->json($lote);
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
        $lote= Lote::find($id);

        $lote->lote=$arreglo['lote'];
        $lote->id_finca=$arreglo['id_finca'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lote = Lote::find($id);
        $lote->delete();
        return "Registro Eliminado";
    }
}
