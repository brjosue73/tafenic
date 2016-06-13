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
  <h4 class="text-centro">TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
  <h5 class="text-centro">FINCA</h5>
  <h5 class="text-centro">PLANILLA DE PAGO DEL 27 ENERO 09 DE FEBRERO DEL 2016</h5>
  <table class="centrado">
      <tr><th>{{ $dat['nombre'] }}</th></tr>
      <tr>
          <th>INGRESOS</th><th>-------</th>
          <th>DEDUCCIONES</th><th>-------</th>
      </tr>
    <tbody>
      <tr>
        <td> BASICO </td>
        <td> {{ $dat[''] }} </td>
        <td> INSS </td>
        <td> {{ $dat[''] }} </td>
      </tr>
      <tr>
        <td> SEPTIMO </td>
        <td> {{ $dat[''] }} </td>
        <td> PRESTAMOS </td>
        <td> {{ $dat[''] }} </td>
      </tr>
      <tr>
        <td> IR </td>
        <td> {{ $dat[''] }} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> N° HORAS EXTRAS </td>
        <td> {{ $dat[''] }} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> HORAS EXTRAS </td>
        <td> {{ $dat[''] }} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> FERIADO </td>
        <td> {{ $dat[''] }} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> VACACIONES </td>
        <td> {{ $dat[''] }} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> AGUINALDO </td>
        <td> {{ $dat[''] }} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> OTROS </td>
        <td> {{ $dat[''] }} </td>
        <td> TOTAL DEDUCCIONES </td>
        <td> {{ $dat[''] }} </td>
      </tr>
      <tr>
        <td> DEVENGADO </td>
        <td> {{ $dat[''] }} </td>
        <td> TOTAL A PAGAR </td>
        <td> {{ $dat[''] }} </td>
      </tr>
    </tbody>
  </table>
</body>
</html>
