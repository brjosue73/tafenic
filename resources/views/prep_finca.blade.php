<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <hr>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive table-container">
    <table class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr class="active">
          <th>N°</th>
          <th>Nombre del trabajador</th>
          <th>Ocupación</th>
          <th>Días trabajados</th>
          <th>Tot. Devengado</th>
          <th>Alimentación</th>
          <th>Tot. Básico</th>
          <th>septimo</th>
          <th>Subsidio</th>
          <th>Otros</th>
          <th>Feriados</th>
          <th>Tot. Dev 2</th>
          <th>Horas Extra</th>
          <th>Activ Extra</th>
          <th>Tot H. Ext.</th>
          <th>Vacaciones</th>
          <th>Aguinaldo</th>
          <th>Tot.Acumulado</th>
          <th>INSS laboral</th>
          <th>Préstamos</th>
          <th>Tot. a Recibir</th>
          <th>INSS patronal</th>
          <!-- <th>Acción</th> -->

        </tr>
      </thead>
      <tbody>
        @foreach($data as $dat)
        <tr>
          <td> {{ 1 }}</td>
          <td> {{ $dat['nombre'] }} </td>
          <td></td>
          <td> {{ $dat['dias'] }} </td>
          <td> {{ $dat['total_deven'] }} </td>
          <td> {{ $dat['alim_tot'] }} </td>
          <td> {{ $dat['total_basic'] }} </td>
          <td> {{ $dat['total_septimo'] }} </td>
          <td>{{ $dat['subsidio'] }}</td>
          <td>{{ $dat['otros'] }}</td>
          <td>{{ $dat['feriado'] }}</td>
          <td>{{ $dat['devengado2'] }}</td>
          <td>{{ $dat['cant_horas_ext']}}  </td>
          <td>{{ $dat['cant_act_ext']}}  </td>
          <td>{{ $dat['horas_ext_tot'] }}</td>
          <td>{{ $dat['vac_tot'] }}</td>
          <td>{{ $dat['agui_tot'] }}</td>
          <td> {{ $dat['total_acum'] }} </td>
          <td>{{ $dat['inss'] }}</td>
          <td>{{ $dat['prestamos'] }}</td>
          <td> {{ $dat['salario_'] }} </td>
          <td>{{ $dat['inss_patronal'] }}</td>
        </tr>
        @endforeach
        <tr>
          <td colspan="3">Total</td>
          <td>{{ totales.sum_dias_trab }}</td>
          <td>{{ totales.sum_dev1 }}</td>
          <td>{{ totales.sum_alim }}</td>
          <td>{{ totales.sum_basico }}</td>
          <td>{{ totales.sum_septimos }}</td>
          <td>{{ totales.sum_subsidios }}</td>
          <td>{{ totales.sum_otros }}</td>
          <td>{{ totales.sum_feriados }}</td>
          <td>{{ totales.sum_dev2 }}</td>
          <td>{{ totales.sum_h_ext }}</td>
          <td></td>
          <td></td>
          <td>{{ totales.sum_vacs }}</td>
          <td>{{ totales.sum_aguin }}</td>
          <td>{{ totales.sum_acum }}</td>
          <td>{{ totales.sum_inss_lab }}</td>
          <td>{{ totales.sum_prestam }}</td>
          <td>{{ totales.sum_tot_recib }}</td>
          <td>{{ totales.sum_inss_pat }}</td>
          <!-- <td></td> -->
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
