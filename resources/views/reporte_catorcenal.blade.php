<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <!-- <link rel="stylesheet" href="res/css/bootstrapTable.css"> -->
</head>
<body>
  <?php
  setlocale(LC_ALL,"es_ES");
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $fecha_ini=$data['0']['fecha_ini'];
  $fecha_fin=$data['0']['fecha_fin'];

  $fecha_1=date("d-m-Y", strtotime("$fecha_ini + 1 days"));
  $dia_ini=date("d", strtotime($fecha_1));
  $mes_ini=date("m", strtotime($fecha_1));
  $ano=date("Y", strtotime($fecha_1));

  $fecha_2=date("d-F-Y", strtotime("$fecha_fin"));
  $dia_fin=date("d", strtotime($fecha_2));
  $mes_fin=date("m", strtotime($fecha_2));
  $i=0;
   ?>
  <h4>TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
  <h5>PLANILLA GENERAL</h5>
  <h5> Planilla de pago del {{$dia_ini}} de {{$meses[$mes_ini-1]}} al {{$dia_fin}} de {{$meses[$mes_fin-1]}} del {{$ano}}</h5>
  
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr class="active">

            <th> N° </th>
            <th>Nombre &</th>
            <th>Días trab</th>
            <th>Tot. Deven</th>
            <th>Alim.</th>
            <th>Tot. Básico</th>
            <th>Septimo</th>
            <th>subsidio</th>
            <th>Otros</th>
            <th>Feriados</th>
            <th>Tot. Deven</th>
            <th>H. Ext</th>
            <th>Act. Ext</th>
            <th>T. Extras</th>
            <th>Vac</th>
            <th>Aguin</th>
            <th>Tot.Acumu</th>
            <th>INSS laboral</th>
            <th>Présta</th>
            <th>Tot. a Recibir</th>
            <th>Recibí Conforme</th>
            <th>INSS Patronal</th>
            <!-- <th>Finc. Sep.</th> -->

          </tr>
        </thead>
        <tbody>
          @foreach ($data as $dat)
          <tr> <?php   $fecha_ini=$dat['fecha_ini'];
            $fecha_fin=$dat['fecha_fin']; ?>
            <td> {{ ++$i }}</td>
            <td> {{ $dat['nombre'] }} </td>
            <td> {{ $dat['dias'] }} </td>
            <td> {{number_format( $dat['total_deven'] ,2 )}} </td>
            <td> {{ number_format($dat['alim_tot'] ,2 )}} </td>
            <td> {{ number_format($dat['total_basic'] ,2 )}} </td>
            <td> {{number_format( $dat['total_septimo'] ,2 )}} </td>
            <td> {{number_format( $dat['subsidio'] ,2 )}}</td>
            <td> {{number_format( $dat['otros'] ,2 )}}</td>
            <td> {{number_format( $dat['feriado'] ,2 )}} </td>
            <td>  {{number_format( $dat['devengado2'] ,2 )}}</td>
            <td>  {{ $dat['cant_horas_ext'] }}</td>
            <td>0</td>
            <td> {{number_format( $dat['horas_ext_tot'] ,2 )}} </td>
            <td> {{number_format( $dat['vac_tot'] ,2 )}} </td>
            <td>{{number_format( $dat['agui_tot'] ,2 )}}</td>
            <td> {{number_format( $dat['total_acum'] ,2 )}} </td>
            <td>{{number_format( $dat['inss'] ,2 )}}</td>
            <td>{{number_format( $dat['prestamos'] ,2 )}}</td>
            <td> {{number_format( $dat['salario_'] ,2 )}} </td>
            <td class="firma"></td>
            <td>{{number_format( $dat['inss_patronal'] ,2 )}}</td>
            <!-- <td> {{ $dat['finca_septimo'] }} </td> -->
          </tr>
          @endforeach
          <tr>
            <td colspan="2">Total</td>
            <td>{{number_format( $totales['sum_dias_trab'] ,2 )}}</td>
            <td>{{number_format( $totales['sum_dev1'],2 ) }}</td>
            <td>{{number_format( $totales['sum_alim'],2 ) }}</td>
            <td>{{number_format( $totales['sum_basico'],2 ) }}</td>
            <td>{{number_format( $totales['sum_septimos'],2 ) }}</td>
            <td>{{number_format( $totales['sum_subsidios'],2 ) }}</td>
            <td>{{number_format( $totales['sum_otros'],2 ) }}</td>
            <td>{{number_format( $totales['sum_feriados'],2 ) }}</td>
            <td>{{number_format( $totales['sum_dev2'],2 ) }}</td>
            <td>{{number_format( $totales['sum_h_ext'],2 ) }}</td>
            <td>0</td>
            <td>{{number_format( $totales['sum_tot_hext'],2 ) }}</td>
            <td>{{number_format( $totales['sum_vacs'],2 ) }}</td>
            <td>{{number_format( $totales['sum_aguin'],2 ) }}</td>
            <td>{{number_format( $totales['sum_acum'],2 ) }}</td>
            <td>{{number_format( $totales['sum_inss_lab'],2 ) }}</td>
            <td>{{number_format( $totales['sum_prestam'],2 ) }}</td>
            <td>{{number_format( $totales['sum_tot_recib'],2 ) }}</td>
            <td></td>
            <td>{{number_format( $totales['sum_inss_pat'],2 ) }}</td>
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
