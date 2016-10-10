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
          $vacaciones= ($variable->vacaciones)/100;

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
          $vacaciones=$variable->vacaciones/100;
          $cuje_grand= $variable->cuje_grand;
          $cuje_peq= $variable->cuje_peq;
          $h_ext_val= $variable->hora_ext;
          $cuje_peq_ext=$cuje_peq*2;
          $cuje_grand_ext=$cuje_grand*2;
          $pago_hora=$dia/8;
          $pago_hora_ext=$pago_hora*2;
          $safa_peq=$variable->safa_peq;
          $safa_grand=$variable->safa_grand;
          $safa_peq_ext=$safa_peq*2;
          $safa_grand_ext=$safa_grand*2;
          $inss_lab=$variable->inss_campo;
          $inss_admin=$variable->inss_admin;
          $inss_patron=$variable->inss_patron;
        }

        $prep= new Preplanilla($arreglo);
        $subsidio=$arreglo['subsidio'];

        $prep->salario_dev =$dia;
        $prep->alimentacion =$alim;
        $prep->vacaciones= $vacaciones;
        $prep->aguinaldo= $vacaciones;
        $prep->prestamo =$arreglo['prestamos'];

        if (isset($arreglo['feriado'])) {
          $feriado=$arreglo['feriado'];
          if ($feriado==0) { //feriado no trabajado
            $tot_feriado=round($dia,2);
            $prep->feriados=$tot_feriado;
            $prep->save();
            return 'Agregada con exito Feriado no trab';
          }
          else { //si es feriado trabajado
            $prep->total_actividad=$dia;//aqui
            $ext=0;
            $otros=$arreglo['otros'];
            $prep->otros=$otros;
            $labor_dat=Labor::find($arreglo['id_labor']);
            if($labor_dat['tipo_labor']=='prod'){ //Si es de tipo actividad/cujes/ensarte
              if($arreglo['labName']=='cuje'){//si es cuje
                 $cant_cujes=$arreglo['cant_cujes'];
                 if($arreglo['tamano_cuje'] == 0){//pequeno
                   $total_act=round($cant_cujes * $cuje_peq,2);
                   $total_act=$dia;
                   $total_act_ext=round($arreglo['cuje_ext']*$cuje_peq_ext,2);

                 }
                 else {//cuje grande
                   $total_act=round($cant_cujes * $cuje_grand,2);
                   $total_act_ext=round($arreglo['cuje_ext']*$cuje_grand_ext,2);

                 }
                 $total_act=$dia;
                 $prep->cant_cujes=$cant_cujes;/****AFINAR AQUI y en safadura--agregar valors faltantes****/
                 $prep->tamano_cuje=$arreglo['tamano_cuje'];
                 $prep->total_extras=$total_act_ext;
               }
               else {//si es safadura
                 return $arreglo;
                 $cant_safa=round($arreglo['cant_safa'],2);
                 if($arreglo['tamano_safa'] == 0){// safadura pequeno
                   $total_act_ext=$arreglo['safa_ext']*$safa_peq_ext;
                 }
                 else { //safadura grande
                   $total_act_ext=$arreglo['safa_ext']*$safa_grand_ext;
                 }
                 $prep->cant_safa=$cant_safa;
                 $prep->tamano_safa=$arreglo['tamano_safa'];
                 $prep->total_extras=$total_act_ext;

               }
            }
            else{ //Si es por Horas
              $total_act=$dia;
              $prep->total_actividad=$dia;
              $ext= $arreglo['hora_ext'] * $h_ext_val;
              $prep->hora_ext = $arreglo['hora_ext'];
              $prep->total_extras=$ext;
            }
            $prep->total_actividad=$dia;
            $sal1=$dia+$alim + $vacaciones +$vacaciones+$ext+$otros;
            $sal=$sal1*2;
            $prep->salario_acum= $sal;
            $subsidio=0;

            $prep->save();
            return "Agregada! 333";
          }
        }

        if ($subsidio===true) {//si esta de subsidio
          $subs=$dia+$alim+$vacaciones+$vacaciones;
          $prep->subsidios=$subs;
          $prep->save();
          return "Agregada! subsidio";
        }
        else {
          $ext=0;
          $otros=$arreglo['otros'];
          $prep->otros=$otros;
          $labor_dat=Labor::find($arreglo['id_labor']);
          if($labor_dat['tipo_labor']=='prod'){ //Si es de tipo actividad/cujes/ensarte
            if($arreglo['labName']=='cuje'){//si es cuje
               $cant_cujes=$arreglo['cant_cujes'];
               if($arreglo['tamano_cuje'] == 0){//pequeno
                 $total_act=$cant_cujes * $cuje_peq;
               }
               else {//cuje grande
                 $total_act=$cant_cujes * $cuje_grand;
               }
               $prep->cant_cujes=$cant_cujes;/****AFINAR AQUI y en safadura--agregar valors faltantes****/
               $prep->tamano_cuje=$arreglo['tamano_cuje'];
               $prep->cuje_ext=$arreglo['cuje_ext'];
               $prep->total_extras=$total_act;
             }
             else {//si es safadura
               $cant_safa=$arreglo['cant_safa'];
               if($arreglo['tamano_safa'] == 0){// safadura pequeno
                 $total_act=$cant_safa * $safa_peq;
                 $total_act_ext=$arreglo['safa_ext']*$safa_peq_ext;
               }
               else { //safadura grande
                 $total_act=$cant_safa * $safa_grand;
                 $total_act_ext=$arreglo['safa_ext']*$safa_grand_ext;
               }
               $prep->cant_safa=$cant_safa;
               $prep->tamano_safa=$arreglo['tamano_safa'];
               $prep->total_extras=$total_act_ext;//falta el total de las actividades
               $prep->safa_ext=$arreglo['safa_ext'];
               $prep->total_actividad=$total_act;
             }
          }
          else{ //Si es por Horas
            $prep->total_actividad=$dia;
            $ext= $arreglo['hora_ext'] * $h_ext_val;
            $prep->hora_ext = $arreglo['hora_ext'];
            $prep->total_extras=$ext;
          }
          $sal=$dia+$alim + $vacaciones +$vacaciones+$ext+$otros;
          $prep->salario_acum= $sal;
          $subsidio=0;
          $prep->inss_campo=$inss_lab;
          $prep->inss_admin=$inss_admin;
          $prep->inss_patron=$inss_patron;
          $prep->save();
          $subs=0;
          return "Agregada! supuestamente normal";
        }


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
