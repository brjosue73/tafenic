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

    <body data-ng-app="moduleName">
      <a href="#/">Inicio</a>
      <span> | </span>
      <a data-ng-href="#/trabajadores/nuevo/">Nuevo trabajador</a>
      <main data-ng-controller="controllerName">
        <section data-ng-view=""></section>
      </main>

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
