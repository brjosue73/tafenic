
(function(){
	'use strict';

	//Create a new Angular module
	angular.module('moduleName',["ngRoute","ngResource"]);

	//Use an exist Angular Module
	var app = angular.module('moduleName');

	//Service Factory resource
	app.factory('Resource', ['$resource', function(r){
		return r('trabajadores/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	//Service Factory resource
	app.factory('fincaResource', ['$resource', function(r){
	  return r('fincas/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	//Service Factory resource
	app.factory('actividadResource', ['$resource', function(r){
	  return r('actividad/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	//Create and append a new cotroller for your module
	app.controller("fincaController",['$scope','$http','fincaResource', function(s,h,fr){
	  s.fincaSaveData = {};
	  s.fincaSave = function(){
	    console.log(s.fincaSaveData);
	    fr.save({data:s.fincaSaveData});
	  }
	}]);	//Create and append a new cotroller for your module
		app.controller("actividadController",['$scope','$http','actividadResource', function(s,h,ar){
		  s.actividadSaveData = {};
		  s.actividadSave = function(){
		    console.log(s.actividadSaveData);
		    ar.save({data:s.actividadSaveData});
		  }
		}]);
	//angular routes config
	app.config(function ($routeProvider) {
	$routeProvider
	    .when('/trabajadores/nuevo/', {
	      templateUrl: 'partials/saveForm.html',
	      controller: 'postOne',
	      controllerAs: 'CR0'
	    })
	    .when('/', {
	      templateUrl: 'partials/listar.html',
	      controller: 'getAll',
	      controllerAs: 'CR1'
	    })
	    .when('/trabajador/editar/:id', {
	      templateUrl: 'partials/saveForm.html',
	      controller: 'getOne',
	      controllerAs: 'CR2'
	    })
	    .otherwise({
	      redirectTo: '/'
	    });
	});
	//Create one
	app.controller('postOne', ['$scope','Resource','$location', function(s,r,l){
		s.boton = "Guardar";
		s.sendData = {};
		s.save = function(){
			r.save({data:s.sendData});
			l.path('/');
		}
	}]);
	//Read one && Update One
	app.controller('getOne', ['$scope','$routeParams','Resource','$location', function(s,p,r,l){
		//s.sendData = {};
		s.boton="Editar";
		s.sendData = r.get({id:p.id});
		s.save = function(){
			r.update({id:s.sendData.id},{data:s.sendData},function(data){
				console.log(data);
				l.path('/');
			});
		}
	}]);
	//Read all && Del One
	app.controller('getAll', ['$scope','Resource','$location', function(s,r,l){
		s.trabajadores = r.query();
		s.del = function(id){
			r.delete({id:id}, function(datos){
				console.log(datos);
				l.path('/');
			});
		}
	}]);
}());
