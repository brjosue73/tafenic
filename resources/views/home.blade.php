<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Laravel</title>
        <!-- <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" href="res/dependencies/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="res/css/styles.css">
        <link rel="stylesheet" href="res/dependencies/font-awesome/css/font-awesome.min.css">
    </head>
    <body data-ng-app="moduleName" class="container-fluid">
      <div class="row">
        <nav class="navbar navbar-inverse navbar-fixed">
            <div class="navbar-header">
              <a href="" data-ui-sref="/" class="navbar-brand">TAFENIC.SA</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a data-ui-sref="/adminPane">Inicio</a></li>
                <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Ir a...<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="" data-ui-sref="/trabajadores">Trabajadores</a></li>
                    <li><a href="" data-ui-sref="/fincas">Fincas</a></li>
                    <li><a href="" data-ui-sref="/preplanilla">Preplanillas</a></li>
                    <li><a href="" data-ui-sref="/prepxtrab">Preplanilla por trabajador</a></li>
                    <li><a href="" data-ui-sref="/prepxfinc">Preplanilla por Fincas</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Reportes<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="" data-ui-sref="/planilla">Planilla</a></li>
                    <li><a href="" data-ui-sref="preplanilla">preplanilla</a></li>
                    <li><a href="" data-ui-sref="/"></a></li>
                    <li><a href="" data-ui-sref="/"></a></li>
                    <li><a href="" data-ui-sref="/"></a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Ajustes<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="" data-toggle="modal" data-target="#valores">Valores</a></li>
                    <li><a href="" data-ui-sref="#/">Hola</a></li>
                    <li><a href="" data-ui-sref="#/">Adios</a></li>
                  </ul>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right" role="menu">
                  <li onClick="history.back();"><a href=""><i class="glyphicon glyphicon-chevron-left"></i> volver</a></li>
                  <li><a href="/logout"><i class="fa fa-btn fa-sign-out"></i> Cerrar Sesion</a></li>
              </ul>
            </div>
        </nav>
      </div>

      <main data-ui-view class="row"></main>

      <div class="modal fade" id="valores">
          <div class="modal-dialog">
            <div class="modal-content"  data-ng-controller="valoresController">

                <div class="modal-header">
                    <button class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Valores</h4>
                </div>
                <div class="modal-body">
                  <form>
                      <div class="form-group">
                          <label for="finca">Finca</label>
                          <input type="text" class="form-control" placeholder="Finca" name="finca" data-ng-model="fincaSaveData.nombre">
                      </div>
                      <div class="form-group">
                          <label for="estado">Estado</label>
                          <input type="text"class="form-control" placeholder="Estado" name="estado" data-ng-model="fincaSaveData.estado">
                      </div>
                  </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-ng-click="valorSave()">aceptar</button>
                    <button class="btn btn-default" data-dismiss="modal">cancelar</button>
                </div>

            </div>
          </div>
      </div>

      <script src="res/dependencies/jquery/dist/jquery.min.js"></script>
      <script src="res/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="res/dependencies/angular/angular.min.js"></script>
      <script src="res/dependencies/angular-route/angular-route.min.js"></script>
      <script src="res/dependencies/angular-resource/angular-resource.min.js"></script>
      <script src="res/dependencies/angular-ui-router/release/angular-ui-router.min.js"></script>
      <script src="res/js/angular.js"></script>
      <script src="res/js/scripts.min.js"></script>
    </body>
</html>
