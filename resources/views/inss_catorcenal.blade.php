  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <link rel="stylesheet" href="res/css/bootstrapTable.css">
</head>
<body>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr class="active">

            <th>NSS</th>
            <th>P.Nombre</th>
            <th>P.Apellido</th>
            <th>Nomina</th>
            <th>Novedad</th>
            <th>Fecha Novedad</th>
            <th>Total Devengado</th>
            <th>Salario Mens</th>
            <th>Aporte</th>
            <th>Semanas</th>
            <th>Cto. Costo</th>
            <th>T Empleo</th>
            <th></th>

          </tr>
        </thead>
        <tbody>
          @foreach($data as $dat)
          <tr>
            <td>{{$dat['nss']}}</td>
            <td>{{$dat['pnombre']}}</td>
            <td>{{$dat['papellido']}}</td>
            <td>2</td>
            <td>03</td>
            <td>{{$dat['fecha_ini']}}-01 </td>
            <td>{{$dat['t_devengado']}}</td>
            <td>{{$dat['salario']}}</td>
            <td>0</td>
            <td></td>
            <td>0</td>
            <td></td>
            <td>{{$dat['nss']}};{{$dat['pnombre']}};{{$dat['papellido']}};2;3;</td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </div>


</body>
</html>
