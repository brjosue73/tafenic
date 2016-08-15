<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <style>
    table,th,td,tr{
      border: 1px solid black;
      margin: 0;
    }
    hr{
      margin-top: 0;
      margin-bottom: 8cm;
    }
    .cien{
      width: 100%;
    }
    .cincuenta{
      width: 50%;
    }
    .text-centro{
      text-align: center;
      margin-top: 0;
      margin-bottom: 0;
    }
    .centrado{
      margin: 0 auto;
    }
  </style>
</head>
<body>
  @foreach($data as $dat)
  <h4 class="text-centro">TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
  <h5 class="text-centro">FINCA</h5>
  <h5 class="text-centro">PLANILLA DE PAGO DEL {{$dat['fecha_ini']}} al {{$dat['fecha_fin']}}</h5>
  <table class="centrado">
      <tr><th>{{$dat['nombre']}}</th></tr>
      <tr>
          <th>INGRESOS</th><th>-------</th>
          <th>DEDUCCIONES</th><th>-------</th>
      </tr>
    <tbody>
      <tr>
        <td> BASICO </td>
        <td> {{$dat['total_basic']}} </td>
        <td> INSS </td>
        <td> {{$dat['inss']}} </td>
      </tr>
      <tr>
        <td> SEPTIMO </td>
        <td> {{$dat['total_septimo']}} </td>
        <td> PRESTAMOS </td>
        <td> </td>
      </tr>
      <tr>
        <td> IR </td>
        <td>  </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> N° HORAS EXTRAS </td>
        <td> {{$dat['horas_ext_tot']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> HORAS EXTRAS </td>
        <td> {{$dat['extra_tot']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> FERIADO </td>
        <td>  </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> VACACIONES </td>
        <td> {{$dat['vac_tot']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> AGUINALDO </td>
        <td> {{$dat['agui_tot']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> OTROS </td>
        <td>  </td>
        <td> TOTAL DEDUCCIONES </td>
        <td>  </td>
      </tr>
      <tr>
        <td> DEVENGADO </td>
        <td> {{$dat['total_deven']}} </td>
        <td> TOTAL A PAGAR </td>
        <td> {{$dat['salario_']}} </td>
      </tr>
    </tbody>
  </table>
<hr>
  @endforeach
</body>
</html>