<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive table-container">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr class="active">
            <th>N°</th>
            <th>Nombre del trabajador</th>
            <th>Ocupación</th>
            <th>Días trabajados</th>
            <th>Tot. Devengado</th>
            <th>Alimentación</th>
            <th>Tot. Básico</th>
            <th>septimo</th>
            <th>Subsidio</th>
            <th>Otros</th>
            <th>Feriados</th>
            <th>Tot. Dev 2</th>
            <th>Horas Extra</th>
            <th>Activ Extra</th>
            <th>Tot H. Ext.</th>
            <th>Vacaciones</th>
            <th>Aguinaldo</th>
            <th>Tot.Acumulado</th>
            <th>INSS laboral</th>
            <th>Préstamos</th>
            <th>Tot. a Recibir</th>
            <th>INSS patronal</th>
            <!-- <th>Acción</th> -->

          </tr>
        </thead>
        <tbody>
          <tr data-ng-repeat="reporfincTota in reporfincTot">

            <td> <% $index + 1 %></td>
            <td> <% reporfincTota.nombre %> </td>
            <td> <li data-ng-repeat="labour in reporfincTota.labores track by $index"><% labour %> </li></td>
            <td> <% reporfincTota.dias %> </td>
            <td> <% reporfincTota.total_deven %> </td>
            <td> <% reporfincTota.alim_tot %> </td>
            <td> <% reporfincTota.total_basic %> </td>
            <td> <% reporfincTota.total_septimo %> </td>
            <td><% reporfincTota.subsidio %></td>
            <td><% reporfincTota.otros %></td>
            <td><% reporfincTota.feriado %></td>
            <td><% reporfincTota.devengado2 %></td>
            <td><% reporfincTota.cant_horas_ext%>  </td>
            <td><% reporfincTota.cant_act_ext%>  </td>
            <td><% reporfincTota.horas_ext_tot %></td>
            <td><% reporfincTota.vac_tot %></td>
            <td><% reporfincTota.agui_tot %></td>
            <td> <% reporfincTota.total_acum %> </td>
            <td><% reporfincTota.inss %></td>
            <td><% reporfincTota.prestamos %></td>
            <td> <% reporfincTota.salario_ %> </td>
            <td><% reporfincTota.inss_patronal %></td>
            <!-- <td><a href=""  data-toggle="modal" data-target="#uncatorcenal" data-ng-click="revision(reporfincTota.id_trab, $index, reporfincTota.fecha_ini, reporfincTota.fecha_fin)">Revisar</a></td> -->
            <!-- <td> <% reporfincTota.aguinaldo %> </td>
            <td> <% reporfincTota.vacaciones %> </td> -->

          </tr>
          <tr>
            <td colspan="3">Total</td>
            <td><% totales.sum_dias_trab %></td>
            <td><% totales.sum_dev1 %></td>
            <td><% totales.sum_alim %></td>
            <td><% totales.sum_basico %></td>
            <td><% totales.sum_septimos %></td>
            <td><% totales.sum_subsidios %></td>
            <td><% totales.sum_otros %></td>
            <td><% totales.sum_feriados %></td>
            <td><% totales.sum_dev2 %></td>
            <td><% totales.sum_h_ext %></td>
            <td></td>
            <td></td>
            <td><% totales.sum_vacs %></td>
            <td><% totales.sum_aguin %></td>
            <td><% totales.sum_acum %></td>
            <td><% totales.sum_inss_lab %></td>
            <td><% totales.sum_prestam %></td>
            <td><% totales.sum_tot_recib %></td>
            <td><% totales.sum_inss_pat %></td>
            <!-- <td></td> -->
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>
