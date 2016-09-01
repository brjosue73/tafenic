<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <link rel="stylesheet" href="res/css/bootstrapTable.css">
</head>
<body>
  <h4>TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
  <h5>PLANILLA GENERAL</h5>

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
          <tr>
            <td> {{ $dat['nombre'] }} </td>
            <td> @foreach ( $dat['fincas'] as $fincass) <li>{{ $fincass }} </li><hr>  @endforeach</td>
            <td> @foreach ( $dat['labores'] as $labour)<li>{{ $labour }} </li><hr> @endforeach</td>
            <td> {{ $dat['dias'] }} </td>
            <td> {{ $dat['total_septimo'] }} </td>
            <td> {{ $dat['finca_septimo'] }} </td>
            <td> {{ $dat['total_deven'] }} </td>
            <td> {{ $dat['alim_tot'] }} </td>
            <td> {{ $dat['total_basic'] }} </td>
            <td></td>
            <td></td>
            <td> {{ $dat['horas_ext_tot'] }} </td>
            <td> {{ $dat['vac_tot'] }} </td>
            <td>{{ $dat['agui_tot'] }}</td>
            <td> {{ $dat['total_acum'] }} </td>
            <td>{{ $dat['inss'] }}</td>
            <td></td>
            <td> {{ $dat['salario_'] }} </td>
            <td></td>
            <td></td>
          </tr>
          @endforeach
          <tr>
            <td colspan="2">Total</td>
            <td></td>
            <td>{{ $totales['sum_dias_trab'] }}</td>
            <td>{{ $totales['sum_dev1'] }}</td>
            <td>{{ $totales['sum_alim'] }}</td>
            <td>{{ $totales['sum_basico'] }}</td>
            <td>{{ $totales['sum_septimos'] }}</td>
            <td>{{ $totales['sum_subsidios'] }}</td>
            <td>{{ $totales['sum_otros'] }}</td>
            <td>{{ $totales['sum_feriados'] }}</td>
            <td>{{ $totales['sum_dev2'] }}</td>
            <td>{{ $totales['sum_h_ext'] }}</td>
            <td></td>
            <td></td>
            <td>{{ $totales['sum_vacs'] }}</td>
            <td>{{ $totales['sum_aguin'] }}</td>
            <td>{{ $totales['sum_acum'] }}</td>
            <td>{{ $totales['sum_inss_lab'] }}</td>
            <td>{{ $totales['sum_prestam'] }}</td>
            <td>{{ $totales['sum_tot_recib'] }}</td>
            <td>{{ $totales['sum_inss_pat'] }}</td>
            <td></td>
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
