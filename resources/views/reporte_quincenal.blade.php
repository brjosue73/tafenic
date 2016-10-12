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
  <h5>PLANILLA Quincenal</h5>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr class="active">

            <th>N° INSS</th>
            <th>Nombre de Trab.</th>
            <th>cargo</th>
            <th>Días trab.</th>
            <th>Básico</th>
            <th>Feriados</th>
            <th>Otros</th>
            <th>Subsidio</th>
            <th>Cant. H. Ext.</th>
            <th>Tot. H. Ext.</th>
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
            <td> {{ $dat['inss']}} </td>
            <td> {{ $dat['nombre'] }} </td>
            <td> {{ $dat['cargo'] }} </td>
            <td> {{ $dat['dias_trab'] }} </td>
            <td> {{ $dat['basico'] }} </td>
            <td> {{ $dat['feriados'] }} </td>
            <td> {{ $dat['otros'] }} </td>
            <td> {{ $dat['subsidios'] }} </td>
            <td> {{ $dat['horas_extra'] }} </td>
            <td> {{ $dat['tot_h_ext'] }} </td>
            <td> {{ $dat['devengado'] }} </td>
            <td> {{ $dat['inss_laboral'] }}</td>
            <td> {{ $dat['ir'] }}</td>
            <td> {{ $dat['prestamos'] }} </td>
            <td> {{ $dat['total_pagar'] }}</td>
            <td></td>
            <td> {{ $dat['inss_patronal'] }} </td>
            <td> {{ $dat['inatec'] }} </td>
          </tr>
          @endforeach
          <tr>
            <td colspan="4">Total</td>
            <td> {{ $totales['sum_basico'] }} </td>
            <td> {{ $totales['sum_feriados'] }} </td>
            <td> {{ $totales['sum_otros'] }} </td>
            <td> {{ $totales['sum_subsidios'] }} </td>
            <td> {{ $totales['sum_h_ext'] }} </td>
            <td> {{ $totales['sum_tot_hext'] }} </td>
            <td> {{ $totales['sum_dev'] }} </td>
            <td> {{ $totales['sum_inss_lab'] }} </td>
            <td> {{ $totales['sum_ir'] }} </td>
            <td> {{ $totales['sum_prestamos'] }} </td>
            <td> {{ $totales['sum_sum_pagar'] }} </td>
            <td> {{ $totales['sum_inss_pat'] }} </td>
            <td> {{ $totales['sum_inatec'] }} </td>
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
