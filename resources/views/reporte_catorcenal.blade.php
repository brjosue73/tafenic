<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <!-- <link rel="stylesheet" href="res/css/bootstrapTable.css"> -->
</head>
<body>
  <h4>TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
  <h5>PLANILLA GENERAL</h5>
  <?php
  setlocale(LC_ALL,"es_ES");
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");



  $i=0;
   ?>


    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr class="active">

            <th>Nombre del trabajador</th>
            <th>Fincas</th>
            <th>Labores</th>
            <th>Días trab.</th>
            <th>septimo</th>
            <th>finc. Sep.</th>
            <th>Tot. Devengado</th>
            <th>Alimentación</th>
            <th>Tot. Básico</th>
            <th>Otros</th>
            <th>Feriados</th>
            <th>Horas Extra</th>
            <th>Vacaciones</th>
            <th>Aguinaldo</th>
            <th>Tot.Acumulado</th>
            <th>INSS laboral</th>
            <th>Préstamos</th>
            <th>Tot. a Recibir</th>
            <th>Recibí Conforme</th>
            <th>INSS Patronal</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($data as $dat)
          <tr> <?php   $fecha_ini=$dat['fecha_ini'];
            $fecha_fin=$dat['fecha_fin']; ?>

            <td> {{ $dat['nombre'] }} </td>
            <td> @foreach ( $dat['fincas'] as $fincass) <li>{{ $fincass }} </li><hr>  @endforeach </td>
            <td> @foreach ( $dat['labores'] as $labour)<li>{{ $labour }} </li><hr> @endforeach </td>
            <td> {{ $dat['dias'] }} </td>
            <td> {{number_format( $dat['total_septimo'] ,2 )}} </td>
            <td> {{ $dat['finca_septimo'] }} </td>
            <td> {{number_format( $dat['total_deven'] ,2 )}} </td>
            <td> {{ number_format($dat['alim_tot'] ,2 )}} </td>
            <td> {{ number_format($dat['total_basic'] ,2 )}} </td>
            <td></td>
            <td></td>
            <td> {{number_format( $dat['horas_ext_tot'] ,2 )}} </td>
            <td> {{number_format( $dat['vac_tot'] ,2 )}} </td>
            <td>{{number_format( $dat['agui_tot'] ,2 )}}</td>
            <td> {{number_format( $dat['total_acum'] ,2 )}} </td>
            <td>{{number_format( $dat['inss'] ,2 )}}</td>
            <td></td>
            <td> {{number_format( $dat['salario_'] ,2 )}} </td>
            <td></td>
            <td>{{number_format( $dat['inss_patronal'] ,2 )}}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3">Total</td>
            <td>{{number_format( $totales['sum_dias_trab'] ,2 )}}</td>
            <td>{{number_format( $totales['sum_septimos'],2 ) }}</td>
            <td></td>
            <td>{{number_format( $totales['sum_dev1'],2 ) }}</td>
            <td>{{number_format( $totales['sum_alim'],2 ) }}</td>
            <td>{{number_format( $totales['sum_basico'],2 ) }}</td>
            <td>{{number_format( $totales['sum_otros'],2 ) }}</td>
            <td>{{number_format( $totales['sum_feriados'],2 ) }}</td>
            <td>{{number_format( $totales['sum_h_ext'],2 ) }}</td>
            <td>{{number_format( $totales['sum_vacs'],2 ) }}</td>
            <td>{{number_format( $totales['sum_aguin'],2 ) }}</td>
            <td>{{number_format( $totales['sum_acum'],2 ) }}</td>
            <td>{{number_format( $totales['sum_inss_lab'],2 ) }}</td>
            <td></td>
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
