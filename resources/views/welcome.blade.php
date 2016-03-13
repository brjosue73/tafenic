<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="res/dependencies/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="res/css/styles.css">
    </head>
    <body data-ng-app="moduleName">
      <main data-ng-controller="controllerName">
      <a data-ng-href="#/admin/personas" data-ng-click="gotoPersonas()">Personas</a>
      <a data-ng-href="#/admin/listar" data-ng-click="read()">Listar</a>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
            </div>
        </div>
        <section data-ng-view=""></section>
      </main>
      <script src="res/dependencies/jquery/dist/jquery.min.js"></script>
      <script src="res/dependencies/angular/angular.min.js"></script>
      <script src="res/dependencies/angular-route/angular-route.min.js"></script>
      <script src="res/dependencies/angular-resource/angular-resource.min.js"></script>
      <script src="res/js/angular.js"></script>
      <script src="res/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="res/js/scripts.min.js"></script>
    </body>
</html>
