<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="res/css/planilla.css">
  <link rel="stylesheet" href="res/css/bootstrapTable.css">
  <style>
    @page { margin: 50px; }
    #header {
      position: fixed;
      top: -50px;
      left: 0px;
      right: 0px;
      height: 50px;
      padding: .5em;
      text-align: center;
    }
    @page{
       margin: 50px;
    }
    body{
      padding-top: 35px;
    }
  </style>
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
            <th>INSS Patronal</th>
            <th>INATEC</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($data as $dat)
          <tr>
            <td>hola  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</body>
</html>
