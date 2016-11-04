<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <!-- <link rel="stylesheet" href="res/css/bootstrapTable.css"> -->
  <style>
    @page { margin: 50px; }
    #header {
      position: fixed;
      top: -50px;
      left: 0px;
      right: 0px;
      height: 50px;
      padding: .5em;
      text-align: center;
    }
    @page{
       margin: 50px;
    }
    body{
      padding-top: 35px;
    }
  </style>
</head>
<body>
  <?php
  setlocale(LC_ALL,"es_ES");
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $fecha_ini=$data['0']->fecha_ini;
  $fecha_fin=$data['0']->fecha_fin;
  $fecha_1=date("d-m-Y", strtotime("$fecha_ini + 1 days"));
  $dia_ini=date("d", strtotime($fecha_1));
  $mes_ini=date("m", strtotime($fecha_1));
  $ano=date("Y", strtotime($fecha_1));

  $fecha_2=date("d-F-Y", strtotime("$fecha_fin - 1 days"));
  $dia_fin=date("d", strtotime($fecha_2));
  $mes_fin=date("m", strtotime($fecha_2));
  if($data[0]->tipo=='servicios tecnicos'){
    $tipo="Servicios Técnicos";
  }
  elseif ($data[0]->tipo=='administrativo') {
    $tipo="Administracion";
  }
  $i=0;
   ?>
   <div id="header">
     <h4>TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
     <h5>PLANILLA Quincenal</h5>
       <h5> Planilla de pago del {{$dia_ini}} de {{$meses[$mes_ini-1]}} al {{$dia_fin}} de {{$meses[$mes_fin-1]}} del {{$ano}}</h5>
     <h5>{{$tipo}}</h5>
   </div>



    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr class="active">
            <th>No.</th>
            <th>N° INSS</th>
            <th>Nombre de Trab.</th>
            <th>cargo</th>
            <th>Días trab.</th>
            <th>Básico</th>
            <th>Feriados</th>
            <th>Otros</th>
            <th>Subsidio</th>
            <th>Cant.<br>H.Ext.</th>
            <th>Tot.<br>H.Ext.</th>
            <th>Devengado</th>
            <th>INSS lab.</th>
            <th>IR</th>
            <th>Prestamos</th>
            <th>total_pagar</th>
            <th>Recibí Conforme</th>
            <th>INSS Patronal</th>
            <th>INATEC</th>

          </tr>
        </thead>
        <tbody>

          @foreach ($data as $dat)
          <tr>
            <?php
            $i++;
             ?>
            <td> {{$i}}  </td>
            <td> {{ $dat['inss']}} </td>
            <td> {{ $dat['nombre'] }} </td>
            <td> {{ $dat['cargo'] }} </td>
            <td> {{ $dat['dias_trab'] }} </td>
            <td> {{number_format( $dat['basico_real'] ,2 )}} </td>
            <td> {{number_format( $dat['feriados'] ,2 )}} </td>
            <td> {{number_format( $dat['otros'],2 ) }} </td>
            <td> {{number_format( $dat['subsidios'] ,2 )}} </td>
            <td> {{$dat['horas_extra']}} </td>
            <td> {{number_format( $dat['tot_h_ext'] ,2 )}} </td>
            <td> {{number_format( $dat['devengado'],2 ) }} </td>
            <td> {{ number_format($dat['inss_laboral'] ,2 )}}</td>
            <td> {{number_format( $dat['ir'] ,2 )}}</td>
            <td> {{number_format( $dat['prestamos'] ,2 )}} </td>
            <td> {{number_format( $dat['total_pagar'],2 )}}</td>
            <td class="firma"></td>
            <td> {{number_format( $dat['inss_patronal'] ,2 )}} </td>
            <td> {{number_format( $dat['inatec'] ,2 )}} </td>
          </tr>
          @endforeach
          <tr>
            <td colspan="4">Total</td>
            <td>{{ number_format($totales['sum_dias'],2 ) }}            </td>
            <td> {{ number_format($totales['sum_basico'],2 ) }} </td>
            <td> {{ number_format($totales['sum_feriados'],2 ) }} </td>
            <td> {{number_format( $totales['sum_otros'] ,2 )}} </td>
            <td> {{ number_format($totales['sum_subsidios'] ,2 )}} </td>
            <td> {{$totales['sum_h_ext'] }} </td>
            <td> {{number_format( $totales['sum_tot_hext'] ,2 )}} </td>
            <td> {{number_format( $totales['sum_dev'] ,2 )}} </td>
            <td> {{number_format( $totales['sum_inss_lab'] ,2 )}} </td>
            <td> {{number_format( $totales['sum_ir'] ,2 )}} </td>
            <td> {{number_format( $totales['sum_prestamos'] ,2 )}} </td>
            <td> {{number_format( $totales['sum_sum_pagar'] ,2 )}} </td>
            <td></td>
            <td> {{number_format( $totales['sum_inss_pat'],2 ) }} </td>
            <td> {{number_format( $totales['sum_inatec'] ,2 )}} </td>
          </tr>
        </tbody>
      </table>
    </div>


<div>
  <div class="firmas">
    Elaborado Por:____________________________
  </div>
  <div class="firmas">
    Revisado Por:____________________________
  </div>
  <div class="firmas">
    Autorizado Por:____________________________
  </div>
</div>

</body>
</html>
