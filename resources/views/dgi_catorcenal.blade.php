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

            <th>N° Ruc</th>
            <th>Nombre y Apellidos o Razón Social </th>
            <th>Ingreso Bruto Mensuales</th>
            <th>Valor Cotizacion INSS</th>
            <th>Valor Fondo Pensiones Ahorro</th>
            <th>Base Imponible </th>
            <th>Valor Retenido</th>
            <th>Alicuota de Retención </th>
            <th>Código de Renglón</th>

          </tr>
        </thead>
        <tbody>
          @foreach($data as $dat)
          <tr>
            <td>{{$dat['ruc']}}</td>
            <td>{{$dat['nombres']}}</td>
            <td>{{$dat['t_devengado']}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </div>


</body>
</html>
