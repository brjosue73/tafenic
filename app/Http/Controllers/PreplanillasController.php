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

        $preps=Preplanilla::all();


        foreach ($preps as $prep) {
            $prep->trabajador;
            $prep->finca;
            $prep->actividad;
            $prep->labor;
            $prep->lote;
            $prep->listero;
            $prep->resp_finca;
        }
        return response()->json($preps);

        //enviar los datos de la preplanilla para que aparezcan en los combo box
    }

    public function constantes(){ /*Envia las constantes para ser modificadas con algular */
        $constants = array();
        $array = [
            "dia" => 106.25,
            "septimo" => 106.25,
            "alimentacion" => 30,
            "vacaciones" => 15,
            "aguinaldo" => 15,
            "h_extra" => 37,
        ];
        return $array;
    }

    public function preplanilla_fecha(Request $request){
        $prep= DB::table('preplanillas')
                    ->whereBetween('fecha',[$request->fecha_inic, $request->fecha_fin])
                    ->get();
        return response()->json($prep);
          /*if $request->finca =! 'Todas' { //sino quiere todas las fincas
            $prep= DB::table('preplanillas')
                    ->where('finca',$request->finca)
                    ->whereBetween('fecha',[$request->fecha_inic, $request->fecha_fin])
                    ->get();
            //hacer la consulta solamente en el rango de fechas
        }
        else
        {
            $prep= DB::table('preplanillas')
                    ->whereBetween('fecha',[$request->fecha_inic, $request->fecha_fin])
                    ->get();
            //hacer la consulta con el rango de fecha y agregar un where ->where('fincas', $request->finca)
        }
        */

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dia= 106.25;
        $alim = 30;
        $vacaciones= $dia*0.083333;
        $prep= Preplanilla::find(1);

        $prep->salario_dev =$dia;
        $prep->alimentacion =$alim;
        $prep->vacaciones= $vacaciones;
        $prep->aguinaldo= $vacaciones;
        $sal=$dia+$alim + $vacaciones +$vacaciones;
        $prep->salario_acum= $sal;


        //$prep->save();

        return $prep;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    /*Mejorar tomando los valores de la tabla de constantes*/
        $peticion = $request->all();
        $arreglo = $peticion["data"];

        $dia= 106.25;
        $alim = 30;
        $vacaciones= $dia*0.083333;
        $prep= new Preplanilla($arreglo);
        $prep->salario_dev =$dia;
        $prep->alimentacion =$alim;
        $prep->vacaciones= $vacaciones;
        $prep->aguinaldo= $vacaciones;
        $prep->hora_ext=
        $ext=0;
        // if ($arreglo['hora_ext']=!null){
        //     $ext=$arreglo->hora_ext * 26.56;
        // }
        // else{
        //     $ext=0;
        // }
        $ext= $arreglo['hora_ext'] * 26.56;
        $prep->hora_ext = $arreglo['hora_ext'];
        $prep->total_extras=$ext;
        $sal=$dia+$alim + $vacaciones +$vacaciones+$ext;
        $prep->salario_acum= $sal;
        $prep->save();
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
        $prep = Preplanilla::find($id);
        return response()->json($prep);
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
        $preplanilla->salario_dev = $arreglo['salario_dev'];
        $preplanilla->alimentacion = $arreglo['alimentacion'];
        $preplanilla->vacaciones = $arreglo['vacaciones'];
        $preplanilla->aguinaldo = $arreglo['aguinaldo'];
        $preplanilla->salario_acum = $arreglo['salario_acum'];
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
