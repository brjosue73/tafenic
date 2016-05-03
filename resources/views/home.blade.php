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
<!--
                <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Opciones <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li data-ng-controller="fincaController"><a href="" data-toggle="modal" data-ng-mouseenter="obtener()" data-target="#miModal">Fincas</a></li>
                    <li data-ng-controller="actividadController"><a href="" data-toggle="modal" data-ng-mouseover="obtener()" data-target="#Activiades">Actividades</a></li>
                    <li data-ng-controller="laborController"><a href="" data-toggle="modal" data-ng-click="obtener()" data-target="#Labores">Labores</a></li>
                    <li><a href="" data-toggle="modal" data-target="#miModa">Otros</a></li>
                  </ul>
                </li>
 -->
      <div class="row">
        <nav class="navbar navbar-inverse navbar-fixed">
            <div class="navbar-header">
              <a href="" data-ui-sref="/" class="navbar-brand">TAFENIC.SA</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a data-ui-sref="/adminPane">Inicio</a></li>
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
                <li><a data-ui-sref="/adminPane">Inicio</a></li>
                <!-- <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Opciones <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li data-ng-controller="fincaController"><a href="" data-toggle="modal" data-ng-mouseenter="obtener()" data-target="#miModal">Fincas</a></li>
                    <li data-ng-controller="actividadController"><a href="" data-toggle="modal" data-ng-mouseover="obtener()" data-target="#Activiades">Actividades</a></li>
                    <li data-ng-controller="laborController"><a href="" data-toggle="modal" data-ng-click="obtener()" data-target="#Labores">Labores</a></li>
                  </ul>
                </li> -->
                <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Settings<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="" data-ui-sref="/trabajadores">Valores</a></li>
                    <li><a href="" data-ui-sref="#/">Hola</a></li>
                    <li><a href="" data-ui-sref="#/">Adios</a></li>
                  </ul>
                </li>
              </ul>
            </div>
        </nav>
      </div>


      <main data-ui-view class="row"></main>


      <!-- <div class="modal fade" id="miModal">
          <div class="modal-dialog">
            <div class="modal-content"  data-ng-controller="fincaController">

                <div class="modal-header">
                    <buton class="close" aria-hidden="true" data-dismiss="modal">&times;</buton>
                    <h4 class="modal-title">Fincas</h4>
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
                    <i id="fincaSpinner" class="fa fa-spinner fa-pulse fa-lg" style="color:blue; display:none;"></i>
                    <span id="exitofinca" style="color:green; display:none;">Guardado! <i class="fa fa-check-circle fa-lg"></i></span>
                    <span id="errorfinca" style="color:Red; display:none;">Error: vuelve a intentarlo <i class="fa fa-times-circle fa-lg"></i></span>
                    <button id="fincAceptar" class="btn btn-primary" data-ng-click="fincaSave()">aceptar</button>
                    <button class="btn btn-default" data-dismiss="modal">cancelar</button>
                </div>

            </div>
          </div>
      </div>
      <div class="modal fade" id="Activiades">
          <div class="modal-dialog">
            <div class="modal-content"  data-ng-controller="actividadController">
          </div>
      </div> -->



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
=======
        </div>
    </div>
</div>
@endsection
>>>>>>> 9ef182a276f475f4951377d210e68da25b8457c9
