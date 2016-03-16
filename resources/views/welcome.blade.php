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
        <nav class="navbar navbar-default navbar-fixed">
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
                    <li><a href="" data-toggle="modal" data-target="#miModal">Labores</a></li>
                    <li><a href="" data-toggle="modal" data-target="#miModal">Actividades</a></li>
                    <li><a href="" data-toggle="modal" data-target="#miModal">Otros</a></li>
                  </ul>
                </li>
              </ul>
            </div>
        </nav>
      </div>


      <main data-ng-controller="controllerName">
        <section data-ng-view="" class="row"></section>
      </main>



      <div class="modal fade" id="miModal">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <buton class="close" aria-hidden="true" data-dismiss="modal">&times;</buton>
                          <h4 class="modal-title">Cabecera</h4>
                      </div>
                      <div class="modal-body">
                          <form>
                              <div class="form-group">
                                  <label for="Usuario">Usuario</label>
                                  <input type="text" class="form-control" placeholder="User">
                              </div>
                              <div class="form-group">
                                  <label for="Contraseña">Contraseña</label>
                                  <input type="text"class="form-control" placeholder="PWD">
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-primary">aceptar</button>
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
