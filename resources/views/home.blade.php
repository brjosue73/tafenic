<!DOCTYPE html>
<?php  use Illuminate\Support\Facades\Auth;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAFENICSA</title>
    <link rel="stylesheet" href="/res/dependencies/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/res/css/styles.css">
    <link rel="stylesheet" href="/res/dependencies/font-awesome/css/font-awesome.min.css">
</head>
<body data-ng-app="moduleName" class="container-fluid">
<!--************************************************************************************
                                HEADER START
****************************************************************************************-->
  <div class="row">
    <nav class="navbar navbar-inverse navbar-fixed">
      <div class="navbar-header">
        <a href="" data-ui-sref="/" class="navbar-brand">TAFENIC.SA</a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a data-ui-sref="/adminPane">Inicio</a></li>

          @if(auth::check())
          @if(auth::user()->type_user==1)
          <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">Ir a...<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="" data-ui-sref="/trabajadores">Trabajadores</a></li>
              <li><a href="" data-ui-sref="/fincas">Fincas</a></li>
              <li><a href="" data-ui-sref="/preplanilla">Preplanilla Diaria</a></li>
              <li><a href="" data-ui-sref="/planillaq">Planilla Quincenal</a></li>
            </ul>
          </li>
          @endif
          @endif


          <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">Reportes<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="" data-ui-sref="/planilla">Planilla Catorcenal</a></li>
              <li><a href="" data-ui-sref="/RplanillaQ">Planilla Quincenal</a></li>
              <!-- <li><a href="" data-ui-sref="/prepxtrab">Preplanilla por trabajador</a></li> -->
              <li><a href="" data-ui-sref="/prepxfinc">Preplanilla por Fincas</a></li>
              <li><a href="" data-ui-sref="/labsRep">Preplanilla por Labores</a></li>
              <!-- <li><a href="" data-ui-sref="/repActProd">R. Act. Prod.</a></li> -->
              <li><a href="" data-ui-sref="/totalescc">Totales C.C.</a></li>
            </ul>
          </li>

          @if(auth::check())
          @if(auth::user()->type_user==1)
            <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown">Ajustes<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="" data-toggle="modal" data-target="#valores">Valores</a></li>
              </ul>
            </li>
          @endif
          @endif


        </ul>
        <ul class="nav navbar-nav navbar-right" role="menu">
            <li onClick="history.back();"><a href=""><i class="glyphicon glyphicon-chevron-left"></i> volver</a></li>
            <li><a href="/logout"><i class="fa fa-btn fa-sign-out"></i> Cerrar Sesion</a></li>
        </ul>
      </div>
    </nav>
  </div>
<!--************************************************************************************
                                HEADER END
****************************************************************************************-->

<!--******************************VIEWS CONTAINER***************************************-->
  <main data-ui-view class="row gris">
    @yield('content')
  </main>
<!--************************************************************************************-->

        <!--************************************************************************************
                            VALORES MODAL START
****************************************************************************************-->
  <div class="modal fade" id="valores" data-ng-controller="valoresController">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Valores</h4>
        </div>
        <div class="modal-body" style="overflow: auto;">
          <form class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="dia">Día: </label>
              <input type="text" class="form-control" placeholder="valor dia" name="dia" data-ng-model="valoresSaveData.sal_diario">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="alimentacion">Alimentación: </label>
              <input type="text" class="form-control" placeholder="alimentacion" name="alimentacion" data-ng-model="valoresSaveData.alimentacion">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="vacaciones">Vacaciones: </label>
              <input type="text" class="form-control" placeholder="vacaciones" name="vacaciones" data-ng-model="valoresSaveData.vacaciones">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="inssC">INSS T. Campo: </label>
              <input type="text" class="form-control" placeholder="INSS Trabajador de Campo" name="inssC" data-ng-model="valoresSaveData.inss_campo">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="inssA">INSS Admin: </label>
              <input type="text" class="form-control" placeholder="INSS Trabajador Administrativo" name="inssA" data-ng-model="valoresSaveData.inss_admin">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="inssP">INSS Patronal 15nal: </label>
              <input type="text" class="form-control" placeholder="INSS Patronal Quincenal" name="inssp" data-ng-model="valoresSaveData.inss_patron">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="inssP">INSS Patronal 14nal: </label>
              <input type="text" class="form-control" placeholder="INSS Patronal Catorcenal" name="inssp" data-ng-model="valoresSaveData.inss_patron_catorce">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="cujeG">Cuje Grande: </label>
              <input type="text" class="form-control" placeholder="Cuje Grande" name="cujeG" data-ng-model="valoresSaveData.cuje_grand">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="cujeP">Cuje Pequeña: </label>
              <input type="text" class="form-control" placeholder="Cuje Pequeño" name="cujeP" data-ng-model="valoresSaveData.cuje_peq">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="safaG">Safadura Grande: </label>
              <input type="text" class="form-control" placeholder="Safa Grande" name="safaG" data-ng-model="valoresSaveData.safa_grand">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="safaP">Safadura Pequeño: </label>
              <input type="text" class="form-control" placeholder="Safa Pequeño" name="safaP" data-ng-model="valoresSaveData.safa_peq">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="horaX">Hora Extra: </label>
              <input type="text" class="form-control" placeholder="Hora Extra" name="horaX" data-ng-model="valoresSaveData.hora_ext">
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
              <label for="sept">Septimo: </label>
              <input type="text" class="form-control" placeholder="Septimo" name="sept" data-ng-model="valoresSaveData.septimo">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <i id="variableSpinner" class="fa fa-spinner fa-pulse fa-lg" style="color:blue; display:none;"></i>
          <span id="exitovariable" style="color:green; display:none;">Cambio Guardado! <i class="fa fa-check-circle fa-lg"></i></span>
          <span id="errorvariable" style="color:Red; display:none;">Error: vuelve a intentarlo <i class="fa fa-times-circle fa-lg"></i></span>
          <button id="buttonval" class="btn btn-primary" data-ng-click="valorUpdate()" >aceptar</button>
          <button class="btn btn-default" data-dismiss="modal">cancelar</button>
        </div>
      </div>
    </div>
  </div>
<!--************************************************************************************
                                VALORES MODAL END
****************************************************************************************-->

  <script src="/res/dependencies/jquery/dist/jquery.min.js"></script>
  <script src="/res/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="/res/dependencies/angular/angular.min.js"></script>
  <script src="/res/dependencies/angular-route/angular-route.min.js"></script>
  <script src="/res/dependencies/angular-resource/angular-resource.min.js"></script>
  <script src="/res/dependencies/angular-ui-router/release/angular-ui-router.min.js"></script>
  <script src="/res/dependencies/lodash/lodash.min.js"></script>
  <script src="/res/js/angular.js"></script>
  <script src="/res/js/scripts.min.js"></script>
  <script>
    $('[data-toggle="tooltip"]').tooltip();
  </script>
</body>
</html>
