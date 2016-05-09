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
