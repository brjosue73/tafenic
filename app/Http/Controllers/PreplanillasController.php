<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Preplanilla;
use App\Trabajador;
use App\Labor;
use DB;
use App\Variable;

class PreplanillasController extends Controller
{
     public function index()
    {
        //$preps=Preplanilla::all();
        $trabajadores = DB::table('trabajadores')->orderBy('created_at', 'desc')->orderBy('estado', 'desc')->get();
        $preps =DB::table('preplanillas')->orderBy('created_at','desc')->get();
        //$preps= Preplanilla::all();
        //return $preps;

        foreach ($preps as $prep) {
          $trabajador=Trabajador::find($prep->id_trabajador);
          $nombre=$trabajador->nombre;
          $apellido=$trabajador->apellidos;
          $completo="$nombre $apellido";
          $labor=Labor::find($prep->id_labor);
          $lab=$labor->nombre;
            $prep->nombres=$completo;
            $prep->labor=$lab;
        }
        return $preps;

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


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $variables=Variable::all();
        foreach ($variables as $variable) {
          $dia=$variable->sal_diario;
          $alim=$variable->alimentacion;
          $vacaciones= $dia*($variable->vacaciones);
          $cuje_grand= $variable->cuje_grand;
          $cuje_peq= $variable->cuje_peq;
        }
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
        $peticion = $request->all();
        $arreglo = $peticion["data"];
        $variables=Variable::all();//
        foreach ($variables as $variable) {//Toma los datos de la tabla variables
          $hora_trab=0;
          $dia=$variable->sal_diario;
          $alim=$variable->alimentacion;
          $vacaciones= $dia*($variable->vacaciones);
          $cuje_grand= $variable->cuje_grand;
          $cuje_peq= $variable->cuje_peq;
          $h_ext_val= $variable->hora_ext;
          $cuje_peq_ext=$cuje_peq*2;
          $cuje_grand_ext=$cuje_grand*2;
          $pago_hora=$dia/8;
          $pago_hora_ext=$pago_hora*2;
        }

        $prep= new Preplanilla($arreglo);
        $prep->salario_dev =$dia;
        $prep->alimentacion =$alim;
        $prep->vacaciones= $vacaciones;
        $prep->aguinaldo= $vacaciones;
        $ext=0;
        $otros=$arreglo['otros'];
        $prep->otros=$otros;
        if(isset($arreglo['cant_cujes'])){ //Si es de tipo actividad/cujes
           $cant_cujes=$arreglo['cant_cujes'];;
           if($arreglo['tamano_cuje'] == 0){//pequeno
             $total_act=$cant_cujes * $cuje_peq;
           }
           else {
             $total_act=$cant_cujes * $cuje_grand;
           }
           $prep->cant_cujes=$cant_cujes;
           $prep->tamano_cuje=$arreglo['tamano_cuje'];
           $prep->total_extras=$total_act;
        }
        else{ //Si es por Horas
          $ext= $arreglo['hora_ext'] * $h_ext_val;
          $prep->hora_ext = $arreglo['hora_ext'];
          $prep->total_extras=$ext;
          $prep->tamano_cuje=3;
        }
        $sal=$dia+$alim + $vacaciones +$vacaciones+$ext+$otros;;
        $prep->salario_acum= $sal;
        return $prep;
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
