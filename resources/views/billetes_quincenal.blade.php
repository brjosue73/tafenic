<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Distribucion de Billetes</title>
  <link rel="stylesheet" href="res/css/bootstrapTable.css">
  <style>
    .text-centro{
      text-align: center;
    }
  </style>
</head>
<body>
  <h5 class="text-centro">DISTRIBUCION DE BILLETES</h5>
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr class="active">
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


        @foreach($data as $dat)

        <tr>
          <td>{{ $dat['0'] }}</td>
          <td class="danger">{{ $dat['500'] }}</td>
          <td>{{ $dat['200'] }}</td>
          <td class="info">{{ $dat['100'] }}</td>
          <td class="primary">{{ $dat['50'] }}</td>
          <td class="warning">{{ $dat['20'] }}</td>
          <td class="success">{{ $dat['10'] }}</td>
          <td>{{ $dat['5'] }}</td>
          <td>{{ $dat['1'] }}</td>
        </tr>

        @endforeach
        <?php
        foreach ($data as $dat) {
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
        ?>
      </tbody>
    </table>

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
            500
          </th>
          <th>
            {{$data500}}
          </th>
          <th>{{$data500*500}}</th>
        </tr>
        <tr>
          <th>
            200
          </th>
          <th>
            {{$dat['200']}}
          </th>
          <th>{{$data200*200}}</th>

        </tr>
        <tr>
          <th>
            100
          </th>
          <th>
            {{$dat['100']}}

          </th>
          <th>{{$data100*100}}</th>

        </tr>
        <tr>
          <th>
            50
          </th>
          <th>
            {{$dat['50']}}

          </th>
          <th>{{$data50*50}}</th>

        </tr>
        <tr>
          <th>
            20
          </th>
          <th>
            {{$dat['20']}}

          </th>
          <th>{{$data20*20}}</th>

        </tr>
        <tr>
          <th>
            10
          </th>
          <th>
            {{$dat['10']}}

          </th>
          <th>{{$data10*10}}</th>

        </tr>
        <tr>
          <th>
            5
          </th>
          <th>
            {{$dat['5']}}

          </th>
          <th>{{$data5*5}}</th>

        </tr>
        <tr>
          <th>
            1
          </th>
          <th>
            {{$dat['1']}}

          </th>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
