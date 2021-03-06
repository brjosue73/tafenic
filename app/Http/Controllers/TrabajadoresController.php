<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trabajador;
use App\Preplanilla;
use App\Actividad;
use App\Finca;
use App\Labor;

use DB;

class TrabajadoresController extends Controller
{

     public function quincenal(){
       $trabajadores = DB::table('trabajadores')
       //->orderBy('nombre', 'desc')
       ->orderBy('created_at', 'desc')
       ->orderBy('estado', 'desc')
       ->where('tipo','quincenal')->get();
       return response()->json($trabajadores);
     }
     public function resp_finca(){
       $trabajadores = DB::table('trabajadores')->orderBy('created_at', 'desc')->orderBy('estado', 'desc')->where('cargo','respfinca')->get();
       return response()->json($trabajadores);
     }
     public function listero(){
       $trabajadores = DB::table('trabajadores')
       ->orderBy('created_at', 'desc')->orderBy('estado', 'desc')
       ->where('cargo','listero')->get();
       return response()->json($trabajadores);
     }
     public function campo(){
       $trabajadores = DB::table('trabajadores')
       ->orderBy('created_at', 'desc')
       ->orderBy('estado', 'desc')
       //->orderBy('nombre', 'asc')
       ->where('cargo','tcampo')
       ->orWhere('cargo','guardia')->get();
       return response()->json($trabajadores);
     }

    public function index()
    {

        $trabajadores = DB::table('trabajadores')
        ->orderBy('created_at', 'desc')
        ->orderBy('estado', 'desc')->get();
      return response()->json($trabajadores);
    }


    public function create()
    {
        //
    }

      //Request $request
    public function prep_trab(Request $request){
      $peticion = $request->all();
      $arreglo = $request->all();//$peticion["data"];
      $id_trab = $arreglo['id_trab'];
      $planilla=array();

      $fecha_ini= $arreglo['fecha_ini'];
      $fecha_fin= $arreglo['fecha_fin'];
      $trabs= Preplanilla::where('id_trabajador',$id_trab)
                                ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                                ->get();
      //return $trabs;
      foreach ($trabs as $trab) {
        $finca=Finca::find($trab->id_finca);
        $actividad=Actividad::find($trab->id_actividad);
        $labor=Labor::find($trab->id_labor);
        $array=[
          'id'=>$trab['id'],
          'fecha'=>$trab['fecha'],
          'hora_ext'=>$trab['hora_ext'],
          'total_extras'=>$trab['total_extras'],
          'hora_trab'=>$trab['hora_trab'],
          'otros'=>$trab['otros'],
          'prestamo'=>$trab['prestamo'],
          'feriados'=>$trab['feriados'],
          'tot_cuje_peq'=>$trab['tot_cuje_peq'],
          'tot_safa_peq'=>$trab['tot_safa_peq'],
          'tot_cuje_gran'=>$trab['tot_cuje_gran'],
          'tot_safa_gran'=>$trab['tot_safa_gran'],
          'finca'=>$finca->nombre,
          'actividad'=>$actividad->nombre,
          'labor'=>$labor->nombre,
        ];
        $planilla[]=$array;
      }


      $trabajador=Trabajador::find($id_trab);
      $nombres=$trabajador->nombre;

      $apellido=$trabajador->apellidos;
      $completo="$nombres $apellido";

      $dias= $trabajador->count();
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
        $array2 = [
          "dias"=>$dias,
          "salario_tot"=>$salario_tot,
          "alim_tot"=>$alim_tot,
          "vac_tot"=>$vac_tot,
          "agui_tot"=>$agui_tot,
          "extra_tot"=>$extra_tot,
          "nombre"=>$completo
        ];
      }
      $planilla[]=$array2;
      $trabs[] = $array2;
      //return $trabs;
      return $planilla;
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
      $trabajador->estado= 1;
      $trabajador->save();
      $ultimo_trab=Trabajador::all()->last();
      return $ultimo_trab;
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
       $trabajador->tipo = $arreglo['tipo'];
       $trabajador->estado = $arreglo['estado'];
       $trabajador->cedula = $arreglo['cedula'];
       $trabajador->cargo = $arreglo['cargo'];
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
