<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="res/dependencies/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="res/css/styles.css">
        <link rel="stylesheet" href="res/dependencies/font-awesome/css/font-awesome.min.css">
    </head>

    <body class="container-fluid" data-ng-app="moduleName">

      <div class="row">
        <nav class="navbar navbar-inverse navbar-fixed">
            <div class="navbar-header">
              <a href="#/" class="navbar-brand">TAFENIC.SA</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="#/">Inicio</a></li>
                <li><a href="#/trabajadores/nuevo/">Crear Trabj.</a></li>
                <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Opciones <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="" data-toggle="modal" data-target="#miModal">Fincas</a></li>
                    <li><a href="" data-toggle="modal" data-target="#Activiades">Actividades</a></li>
                    <li><a href="" data-toggle="modal" data-target="#Labores">Labores</a></li>
                    <li><a href="" data-toggle="modal" data-target="#miModa">Otros</a></li>
                  </ul>
                </li>
              </ul>
            </div>
        </nav>
      </div>


      <main>
        <section data-ng-view="" class="row"></section>
      </main>



            <div class="modal fade" id="miModal">
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
                          <button class="btn btn-primary" data-ng-click="fincaSave()">aceptar</button>
                          <button class="btn btn-default" data-dismiss="modal">cancelar</button>
                      </div>

                  </div>
                </div>
            </div>
            <div class="modal fade" id="Activiades">
                <div class="modal-dialog">
                  <div class="modal-content"  data-ng-controller="actividadController">

                      <div class="modal-header">
                          <buton class="close" aria-hidden="true" data-dismiss="modal">&times;</buton>
                          <h4 class="modal-title">Actividades</h4>
                      </div>
                      <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="actividad">Actividad</label>
                                <input type="text" class="form-control" placeholder="Actividad" name="actividad" data-ng-model="actividadSaveData.nombre">
                            </div>
                            <div class="form-group">
                              <label for="finca">Finca</label>
                              <select name="finca" id="fincaSelect" class="form-control" data-ng-model="actividadSaveData.id_finca">
                                <optgroup label="Fincas">
                                  <option data-ng-repeat="lafinca in lasfincas" value="<% lafinca.id %>"><% lafinca.nombre %></option>
                                </optgroup>
                              </select>
                            </div>
                        </form>

                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-primary" data-ng-click="actividadSave()">Guardar</button>
                          <button class="btn btn-default" data-dismiss="modal">cancelar</button>
                      </div>

                  </div>
                </div>
            </div>
            <div class="modal fade" id="Labores">
                <div class="modal-dialog">
                  <div class="modal-content"  data-ng-controller="laborController">

                      <div class="modal-header">
                          <buton class="close" aria-hidden="true" data-dismiss="modal">&times;</buton>
                          <h4 class="modal-title">Labores</h4>
                      </div>
                      <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="labor">Labor</label>
                                <input type="text" class="form-control" placeholder="Labor" name="labor" data-ng-model="laborSaveData.nombre">
                            </div>
                            <div class="form-group">
                              <label for="actividad">Actividad</label>
                              <select name="actividad" id="actividadSelect" class="form-control" data-ng-model="laborSaveData.id_actividad">
                                <optgroup label="Actividades">
                                  <option data-ng-repeat="laactividad in lasactividades" value="<% laactividad.id %>"><% laactividad.nombre %></option>
                                </optgroup>
                              </select>
                            </div>
                      </form>

                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-primary" data-ng-click="laborSave()">Guardar</button>
                          <button class="btn btn-default" data-dismiss="modal">cancelar</button>
                      </div>

                  </div>
                </div>
            </div>



      <script src="res/dependencies/jquery/dist/jquery.min.js"></script>
      <script src="res/dependencies/angular/angular.min.js"></script>
      <script src="res/dependencies/angular-route/angular-route.min.js"></script>
      <script src="res/dependencies/angular-resource/angular-resource.min.js"></script>
      <script src="res/dependencies/angular-ui-router/release/angular-ui-router.min.js"></script>
      <script src="res/js/angular.js"></script>
      <script src="res/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="res/js/scripts.min.js"></script>
    </body>
</html>
