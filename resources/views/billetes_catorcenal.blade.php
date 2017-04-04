<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Distribucion de Billetes</title>
  <link rel="stylesheet" href="res/css/bootstrapTable.css">
  <link type="text/css" media="all" rel="stylesheet" href="{{ public_path('res/css/bootstrapTable.css') }}">

  <style>
    .text-centro{
      text-align: center;
    }
    table, tr, td, th, tbody, thead, tfoot {
        page-break-inside: avoid !important;
    }
  </style>
</head>
<body>
  <?php
  foreach ($data as $dat) {
    $data1000=$dat['1000'];
    $data500=$dat['500'];
    $data200=$dat['200'];
    $data100=$dat['100'];
    $data50=$dat['50'];
    $data20=$dat['20'];
    $data10=$dat['10'];
    $data5=$dat['5'];
    $data1=$dat['1'];
  }
  $tot500=$data500*500;
  $tot_gen=$data1000*1000+$data500*500+$data200*200+$data100*100+$data50*50+$data20*20+$data10*10+$data5*5+$data1;

  ?>
  <h4 class="text-centro">TABACALERA FERNANDEZ DE NICARAGUA S. A.</h4>
  <h5 class="text-centro">DISTRIBUCION DE BILLETES</h5>
<h5 class="text-centro">Esteli, Nicaragua		</h5>
<h5 class="text-centro">Telefono: 2773-9100, 2710-1015 </h5>


  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr>
          <th>
            Denominación
          </th>
          <th>
            Cantidad de billetes
          </th>
          <th>
            Total
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>
            1000
          </th>
          <th>
            {{number_format( $data1000 ,2 )}}
          </th>
          <th>            {{number_format( $data1000*1000 ,2 )}}</th>
        </tr>

        <tr>
          <th>
            500
          </th>
          <th>
            {{number_format( $data500 ,2 )}}
          </th>
          <th>            {{number_format( $data500*500 ,2 )}}</th>
        </tr>
        <tr>
          <th>
            200
          </th>
          <th>{{number_format( $data200 ,2 )}}</th>
          <th>{{number_format( $data200*200 ,2 )}}</th>

        </tr>
        <tr>
          <th>
            100
          </th>
          <th>{{number_format( $data100 ,2 )}}</th>
          <th>{{number_format( $data100*100 ,2 )}}</th>

        </tr>
        <tr>
          <th>
            50
          </th>
          <th>{{number_format( $data50 ,2 )}}</th>
          <th>{{number_format( $data50*50 ,2 )}}</th>

        </tr>
        <tr>
          <th>
            20
          </th>
          <th>{{number_format( $data20 ,2 )}}</th>
          <th>{{number_format( $data20*20 ,2 )}}</th>

        </tr>
        <tr>
          <th>
            10
          </th>
          <th>{{number_format( $data10 ,2 )}}</th>
          <th>{{number_format( $data10*10 ,2 )}}</th>

        </tr>
        <tr>
          <th>5</th>
          <th>{{number_format( $data5 ,2 )}}</th>
          <th>{{number_format( $data5*5 ,2 )}}</th>

        </tr>
        <tr>
          <th>1</th>
          <th>{{number_format( $data1 ,2 )}}</th>
          <th>{{number_format( $data1*1 ,2 )}}</th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th>{{number_format( $data['diferencia'],2 )}}</th>
        </tr>
        <tr>
          <th></th>
          <th>Total:</th>
          <th>{{number_format( $tot_gen+$data['diferencia'],2 )}}</th>

        </tr>
      </tbody>
    </table>
  </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

  <div class="table-responsive">

    <table class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr class="active">
          <th>Nombre</th>
          <th>SALARIO</th>
          <th class="danger">C$ 500</th>
          <th>C$ 200</th>
          <th class="info">C$ 100</th>
          <th class="primary">C$ 50</th>
          <th class="warning">C$ 20</th>
          <th class="success">C$ 10</th>
          <th>C$ 5</th>
          <th>C$ 1</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $tamano=sizeof($data);
         ?>
         @for($j=0;$j<$tamano-4;$j++)
         <tr>
           <td>{{$nombres[$j]}}</td>
           <td>{{$data[$j]['0']}}</td>
           <td class="danger">{{ $data[$j]['500'] }}</td>
           <td>{{ $data[$j]['200'] }}</td>
           <td class="info">{{ $data[$j]['100'] }}</td>
           <td class="primary">{{ $data[$j]['50'] }}</td>
           <td class="warning">{{ $data[$j]['20'] }}</td>
           <td class="success">{{ $data[$j]['10'] }}</td>
           <td>{{ $data[$j]['5'] }}</td>
           <td>{{ $data[$j]['1'] }}</td>
         </tr>
         @endfor
        <tr>
      </tbody>
    </table>


  </div>
</body>
</html>
