<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <style>
    table,th,td,tr{
      border: 1px solid black;
      /*margin: 0;*/
    }
    table tbody tr td{
      font-size: 8px !important;
    }/*
    .cien{
      width: 100%;
    }
    .cincuenta{
      width: 50%;
    }*/
    .text-centro{
      text-align: center;
      margin-top: 0;
      margin-bottom: 0;
    }
    .centrado{
      margin: 0 auto;
    }
    table{
      width: 75%;
    }
    h4 {
      margin-top: 1rem !important;
    }
  </style>
</head>
<body>
  @foreach($data as $dat)
  <h4 class="text-centro">TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
  <h5 class="text-centro">PLANILLA DE PAGO DEL {{$dat['fecha_ini']}} al {{$dat['fecha_fin']}}</h5>
  <h5 class="text-centro">SOBRE DE PAGO</h5>
  <table class="centrado">
      <tr><th colspan="4">{{$dat['nombre']}}</th></tr>
      <tr>
          <th>INGRESOS</th><th>-------</th>
          <th>DEDUCCIONES</th><th>-------</th>
      </tr>
    <tbody>
      <tr>
        <td> BASICO </td>
        <td> {{$dat['basico']}} </td>
        <td> INSS </td>
        <td>  </td>
      </tr>
      <tr>
        <td> SEPTIMO </td>
        <td>  </td>
        <td> PRESTAMOS </td>
        <td> {{$dat['prestamos']}} </td>
      </tr>
      <tr>
        <td> IR </td>
        <td> {{$dat['ir']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> N° HORAS EXTRAS </td>
        <td> {{$dat['horas_extra']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> HORAS EXTRAS </td>
        <td> {{$dat['tot_h_ext']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> FERIADO </td>
        <td> {{$dat['feriados']}} </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> VACACIONES </td>
        <td> </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> AGUINALDO </td>
        <td>  </td>
        <td>  </td>
        <td>  </td>
      </tr>
      <tr>
        <td> OTROS </td>
        <td> {{$dat['otros']}} </td>
        <td> TOTAL DEDUCCIONES </td>
        <td>  </td>
      </tr>
      <tr>
        <td> DEVENGADO </td>
        <td> {{$dat['devengado']}} </td>
        <td> TOTAL A PAGAR </td>
        <td> {{$dat['total_pagar']}} </td>
      </tr>
    </tbody>
  </table>
  @endforeach
</body>
</html>
