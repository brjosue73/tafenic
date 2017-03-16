<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">

  <style>

  h4,h5 {
    text-align: center;
    margin: 5px;
    font-size: 13px;
  }
  .firmas {
    width: 33%;
    display: inline-block;
    float: left;
  }
  table {
    border-collapse: collapse;
    margin-top: 1.5rem;
    margin-bottom: 12px;
  }
  tbody>tr:nth-child(even) {
    background-color: #ddd;
  }
  th {
    background-color: #ddd;
  }
  td,th {
    padding: 5px 2px;
    border: 1px solid black;
    margin: 0 !important;
  }
  .firm {
     /*padding: 10px 70px;*/
     margin-top: 3.3rem;
  }
  .centrado {
    margin: 0 auto;
  }



    table,th,td,tr{
      border: 1px solid black;
      /*margin: 0;*/
    }
    /*table tbody tr td{
      font-size: 8px !important;
    }*//*
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
      width: 85%;
      margin: 1.5em auto !important;
    }
    h4 {
      margin-top: 1rem !important;
    }
    td, tr>td {
      font-size: 12px !important;
      padding: 1px;
    }
    .numeracion {
      font-size: 1.2em;
      color: #222;
    }
  </style>
</head>
<body>

  <?php
  setlocale(LC_ALL,"es_ES");
  $fecha_1='';
  $fecha2='21';
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $fecha_ini=$data[0]['fecha_ini'];;
  $fecha_1=date("d-m-Y", strtotime("$fecha_ini + 1 days"));


  $i=1;
   ?>
  @foreach($data as $dat)

  <h4 class="text-centro">TABACALERA FERNANDEZ DE NICARAGUA S. A.       <span class="numeracion"> #{{ $i++ }} </span></h4>
  <h5 class="text-centro">FINCA</h5>
  <h5 class="text-centro">PLANILLA DE PAGO DEL {{$fecha_1}} al {{$dat['fecha_fin']}}</h5>
  <table>
      <tr><th colspan="4">{{$dat['nombre']}}</th></tr>
      <tr>
          <th>INGRESOS</th><th>-------</th>
          <th>DEDUCCIONES</th><th>-------</th>
      </tr>
    <tbody>
      <tr>
      {{--Aqui--}}
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
      <!-- <tr>
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
      </tr>-->
      <tr>
        <td> HORAS EXTRAS </td>
        <td> {{$dat['horas_ext_tot']}} </td>
        <td> Cuje G.</td>
        <td> {{ $dat['tot_cuje_gran'] }} </td>
      </tr>
      <tr>
        <td> FERIADO </td>
        <td> {{$dat['feriados']}} </td>
        <td> Cuje Peq. </td>
        <td> {{ $dat['tot_cuje_peq'] }} </td>
      </tr>
      <tr>
        <td> VACACIONES </td>
        <td> {{$dat['vac_tot']}} </td>
        <td> Safadura G. </td>
        <td> {{$dat['tot_safa_gran']}} </td>
      </tr>
      <tr>
        <td> AGUINALDO </td>
        <td> {{$dat['agui_tot']}} </td>
        <td> Safadura Peq. </td>
        <td> {{ $dat['tot_safa_peq'] }} </td>
      </tr>
      <tr>
        <td> OTROS </td>
        <td> {{$dat['otros']}} </td>
        <td> TOTAL DEDUCCIONES </td>
        <td>  </td>
      </tr>
      <tr>
        <td> DEVENGADO </td>
        <td> {{$dat['total_deven']}} </td>
        <td> TOTAL A PAGAR </td>
        <td> {{$dat['salario_']}} </td>
      </tr>
      {{--Aqui--}}

    </tbody>
  </table>
  @endforeach
</body>
</html>
