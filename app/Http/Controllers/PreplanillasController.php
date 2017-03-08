<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Preplanilla;
use App\Trabajador;
use App\Labor;
use App\Finca;
use DB;
use App\Variable;
use App\Lote;
use App\Actividad;


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


    public function create()  {
        $variables=Variable::all();
        foreach ($variables as $variable) {
          $dia=$variable->sal_diario;
          $alim=$variable->alimentacion;
          $vacaciones= 0.083333;

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


    public function store(Request $request){
      $peticion = $request->all();
      $arreglo = $peticion["data"];
      $prep=new Preplanilla($arreglo);
      $guardar=$this->guardar_act($prep, $arreglo);
      return $guardar;
    }
    public function updates(Request $request, $id)
    {
      $arreglo = $request;
      $prep = Preplanilla::find($id);
      $guardar=$this->guardar_act($prep, $arreglo);
      return 'Almacenada con exito';
    }
    public function guardar_act($prep, $arreglo)
    {

        //$peticion = $request->all();
        //$arreglo = $peticion["data"];
        $subsidio=0;
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
          $inss_patron_catorce=$variable->inss_patron_catorce;
        }
        $total_act_ext=0;
        //$prep= new Preplanilla($arreglo);
        //$subsidio=$arreglo['subsidios'];
        $prep->salario_dev =$dia;
        $prep->alimentacion =$alim;
        $prep->vacaciones= $vacaciones;
        $prep->aguinaldo= $vacaciones;
        $prep->prestamo =$arreglo['prestamos'];
        $prep->inss_campo=$inss_lab;
        $prep->inss_admin=$inss_admin;
        $prep->inss_patron=$inss_patron_catorce;
        $prep->hora_trab=$arreglo['hora_trab'];

        if (isset($arreglo['feriado'])) {
          $feriado=$arreglo['feriado'];
          if ($feriado==1) { //feriado no trabajado
            $prep->tipo_feriado=1;
            $tot_feriado=round($dia,2);
            $prep->feriados=$tot_feriado;
            $prep->save();
            return 'Agregada con exito Feriado no trab';
          }
          elseif($feriado==2) { //si es feriado trabajado
            $prep->total_actividad=$dia;//aqui
            $prep->tipo_feriado=2;
            $ext=0;
            $otros=$arreglo['otros'];
            $prep->otros=$otros;
            $labor_dat=Labor::find($arreglo['id_labor']);
            return $labor_dat['cuje_ext'];
            if($labor_dat['tipo_labor']=='prod' ){ //Si es de tipo actividad/cujes/ensarte
              if($arreglo['labName']=='cuje'){//si es cuje
                 $cant_cujes=$arreglo['cant_cujes'];
                 if($arreglo['tamano_cuje'] == 0){//pequeno
                   $total_act=round($cant_cujes * $cuje_peq,2);
                   $total_act=$dia;
                   $total_act_ext=round($arreglo['cuje_ext']*$cuje_peq_ext,2);
                   $prep->tot_cuje_peq=$total_act_ext;
                 }
                 else {//cuje grande
                   $total_act=round($cant_cujes * $cuje_grand,2);
                   $total_act_ext=round($arreglo['cuje_ext']*$cuje_grand_ext,2);
                   $prep->tot_cuje_gran=$total_act_ext;
                 }
                 $total_act=$dia;
                 $prep->cant_cujes=$cant_cujes;/****AFINAR AQUI y en safadura--agregar valors faltantes****/
                 $prep->tamano_cuje=$arreglo['tamano_cuje'];
                 $prep->tot_act_ext=$total_act_ext;
               }
               else {//si es safadura
                 $cant_safa=round($arreglo['cant_safa'],2);
                 if($arreglo['tamano_safa'] == 0){// safadura pequeno
                   $total_act_ext=$arreglo['safa_ext']*$safa_peq_ext;
                   $prep->tot_safa_peq  =$total_act_ext;
                 }
                 else { //safadura grande
                   $total_act_ext=$arreglo['safa_ext']*$safa_grand_ext;
                   $prep->tot_safa_gran=$total_act_ext;
                 }
                 $prep->cant_safa=$cant_safa;
                 $prep->tamano_safa=$arreglo['tamano_safa'];
                 $prep->tot_act_ext=$total_act_ext;
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

            $tot_feriado=round($dia*2,2);
            $prep->feriados=$tot_feriado;
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
          $cuje_ext=$arreglo['cuje_ext'];
          $labor_dat=Labor::find($arreglo['id_labor']);
          if($labor_dat['tipo_labor']=='prod'){ //Si es de tipo actividad/cujes/ensarte
            if($arreglo['labName']=='cuje' || $arreglo['cant_cujes']){//si es cuje
               $cant_cujes=$arreglo['cant_cujes'];
               if($arreglo['tamano_cuje'] == 0){//pequeno
                 $total_act=round($cant_cujes * $cuje_peq,2);
                 $total_act=$dia;
                 $total_act_ext=round($arreglo['cuje_ext']*$cuje_peq_ext,2);
                 $prep->tot_cuje_peq=$total_act_ext;
               }
               else {//cuje grande
                 $total_act=round($cant_cujes * $cuje_grand,2);
                 $total_act_ext=round($arreglo['cuje_ext']*$cuje_grand_ext,2);
                 $prep->tot_cuje_gran=$total_act_ext;
               }
               $prep->cuje_ext=$arreglo['cuje_ext'];
               $prep->tot_cuje_ext=$total_act_ext;
               $total_act=$dia;
               $prep->cant_cujes=$cant_cujes;/****AFINAR AQUI y en safadura--agregar valors faltantes****/
               $prep->tamano_cuje=$arreglo['tamano_cuje'];
               $prep->tot_act_ext=$total_act_ext;
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
               $prep->tot_act_ext=$total_act_ext;//falta el total de las actividades
               $prep->safa_ext=$arreglo['safa_ext'];
               $prep->total_actividad=$total_act;
               $prep->tot_safa_ext=$total_act_ext;
             }
          }
          else{ //Si es por Horas
            $prep->total_actividad=$dia;
            $ext= $arreglo['hora_ext'] * $h_ext_val;
            $prep->hora_ext = $arreglo['hora_ext'];
            $prep->total_extras=$ext;
          }
          $sal=$dia+$alim + $vacaciones +$vacaciones+$ext+$otros+$total_act_ext;
          $prep->salario_acum= $sal;
          $subsidio=0;
          $prep->inss_campo=$inss_lab;
          $prep->inss_admin=$inss_admin;
          $prep->inss_patron=$inss_patron_catorce;
          $prep->septimo=$arreglo['septimo'];
          $prep->centro_costo=$arreglo['centro_costo'];
          $prep->save();
          $subs=0;
          //return $prep;
          return "Actualizacion Agregada";
        }


    }

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
      $prep = Preplanilla::find($id);
      $trab= Trabajador::find($prep->id_trabajador);
      $finc= Finca::find($prep->id_finca);
      $centro=['Tabaco Sol','Tabaco Tapado','Semillero','Ensarte','Safadura'];
      $lote=Lote::find($prep->id_lote);
      $listero=Trabajador::find($prep->id_listero);
      $resp_finc=Trabajador::find($prep->id_respFinca);
      $actividad=Actividad::find($prep->id_actividad);
      $labor=Labor::find($prep->id_labor);
      //return $prep;
      if ($prep['tamano_cuje']==0) {
        $tamano_cuje=['id'=>'0','name'=>'Pequeño'];
      }
      else {
        $tamano_cuje=['id'=>'1','name'=>'Grande'];
      }
      if ($prep['tamano_safa']==0) {
        $tamano_safa=['id'=>'0','name'=>'Pequeño'];
      }
      else {
        $tamano_safa=['id'=>'1','name'=>'Grande'];
      }
      return view('edit_prep', ['data' => $prep,
      'trab'=>$trab,
      'finc'=>$finc,
      'centro'=>$centro,
      'lote'=>$lote,
      'listero'=>$listero,
      'resp_finc'=>$resp_finc,
      'actividad'=>$actividad,
      'labor'=>$labor,
      'cant_cujes'=>$prep['cant_cujes'],
      'cuje_ext'=>$prep['cuje_ext'],
      'safa_ext'=>$prep['safa_ext'],
      'cant_safa'=>$prep['cant_safa'],
      'tamano_cuje'=>$tamano_cuje,
      'tamano_safa'=>$tamano_safa,

    ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


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
