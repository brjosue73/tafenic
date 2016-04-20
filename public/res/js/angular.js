
(function(){
	'use strict';

	//Create a new Angular module
	angular.module('moduleName',["ngRoute","ngResource","ui.router"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
  });

	//Use an exist Angular Module
	var app = angular.module('moduleName');

	//Service Factory resource
	app.factory('Resource', ['$resource', function(r){
		return r('trabajadores/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	/*app.factory('Resource', ['$resource', function(r){
		return r('trabajadores/editar/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);*/
	//Service Factory resource
	app.factory('fincaResource', ['$resource', function(r){
	  return r('fincas/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	//Service Factory resource
	app.factory('actividadResource', ['$resource', function(r){
	  return r('actividad/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	//Service Factory resource
	app.factory('laborResource', ['$resource', function(r){
	  return r('labor/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('prepResource', ['$resource', function(r){
		return r('preplanilla/:id',{id:"@id"},{update:{method:"PUT"}});
	}])
	//Create and append a new cotroller for your module
	app.controller("fincaController",['$scope','$http','fincaResource', function(s,h,fr){
		var $btnFAceptar = $('#fincAceptar') ;
	  s.fincaSaveData = {};

	  s.fincaSave = function(){
	    console.log(s.fincaSaveData);

			$('#fincaSpinner').css("display", "inline-block");

			fr.save({data:s.fincaSaveData}, function(res) {
				console.log(res);
				$('#fincaSpinner').css("display", "none");
				$('#exitofinca').css("display","inline");
				setTimeout(function(){
					$('#exitofinca').css("display","none");
				},3000)
			},function(err){
				console.log(err.status);
				$('#fincaSpinner').css("display", "none");
				$('#errorfinca').css("display","inline");
				setTimeout(function(){
					$('#errorfinca').css("display","none");
				},3000)
			});
	  }
	}]);
	//Create and append a new cotroller for your module
	app.controller("actividadController",['$scope','$http','actividadResource','fincaResource', function(s,h,ar,fr){
	  s.actividadSaveData = {};

		/*var dataEntrante = fr.query();
		s.lasfincas = dataEntrante;

		console.log(dataEntrante);
		console.log(s.lasfincas);*/

		/*s.obtener = function(){
			console.log("actividades");
			// dataEntrante = fr.query();
			// s.lasfincas = dataEntrante;
			h.get('/fincas')
			.success(function(data){
				console.log(data);
				s.lasfincas = data;
			})
			.error(function(err){
				console.log(err);
			});
		}*/
		s.lasfincas = fr.query();
	  s.actividadSave = function(){
	    console.log(s.actividadSaveData);
	    ar.save({data:s.actividadSaveData});
	  }
	}]);
	//Create and append a new cotroller for your module
	app.controller("laborController",['$scope','$http','laborResource','actividadResource', function(s,h,lr,ar){
	  s.laborSaveData = {};

		var dataEntra = ar.query();
		s.lasactividades = dataEntra;
		s.laslabores=lr.query();
		s.obtener = function(){
			console.log("labores");
			s.lasactividades = "";
			dataEntra = "";
		}
	  s.laborSave = function(){
	    console.log(s.laborSaveData);
	    lr.save({data:s.laborSaveData});
	  }
	}]);
	//angular routes config
	/*app.config(function ($routeProvider) {
	$routeProvider
	    .when('/', {
	      templateUrl: 'partials/loggin.html',
	      controller: '',
	      controllerAs: ''
	    })
	    .when('/adminPane', {
	      templateUrl: 'partials/adminPane.html',
	      controller: '',
	      controllerAs: ''
	    })
	    .when('/trabajadores/nuevo/', {
	      templateUrl: 'partials/trabajadores/actualizarT.html',
	      controller: 'postOne',
	      controllerAs: 'CR0'
	    })
	    .when('/trabajadores', {
	      templateUrl: 'partials/trabajadores/listarT.html',
	      controller: 'getAll',
	      controllerAs: 'CR1'
	    })
	    .when('/trabajador/editar/:id', {
	      templateUrl: 'partials/trabajadores/actualizarT.html',
	      controller: 'getOne',
	      controllerAs: 'CR2'
	    })
	    .when('/preplanilla', {
	      templateUrl: 'partials/preplanillas/prepPanel.html',
	      controller: 'preplanilla',
	      controllerAs: 'pplla'
	    })
	    .otherwise({
	      redirectTo: '/'
	    });
	});*/
	/*UI-ROUTER*/
	app.config(function($stateProvider, $urlRouterProvider) {
  	$urlRouterProvider.otherwise("/");

		$stateProvider
		.state('/', {
			url: "/",
			templateUrl: "partials/loggin.html"
		})
		.state('/adminPane', {
			url: "/admin",
			templateUrl: "partials/adminPane.html"
		})
		.state('/trabajadores', {
			url: "/trabajadores",
			templateUrl: "partials/trabajadores/listarT.html",
			controller:"getAll"
		})
		.state('/trabajadores.nuevo', {
			url: "/nuevo",
			templateUrl: "partials/trabajadores/actualizarT.html",
			controller:"postOne"
		})
		.state('/trabajadores.editar', {
			url: "/editar",
			templateUrl: "partials/trabajadores/actualizarT.html",
			controller:"getOne"
		})
		.state('/preplanilla', {
			url: "/preplanilla",
			templateUrl: "partials/preplanillas/prepPanel.html",
			controller:"getAll"
		})/*
    .state('state1.list', {
      url: "/list",
      templateUrl: "partials/state1.list.html",
      controller: function($scope) {
        $scope.items = ["A", "List", "Of", "Items"];
      }
    })
    .state('state2', {
      url: "/state2",
      templateUrl: "partials/state2.html"
    })
    .state('state2.list', {
      url: "/list",
        templateUrl: "partials/state2.list.html",
        controller: function($scope) {
          $scope.things = ["A", "Set", "Of", "Things"];
        }
      })*/
    });
	//Create one
	app.controller('postOne', ['$scope','Resource','$location', function(s,r,l){
		s.boton = "Guardar";
		s.sendData = {};
		s.save = function(){
			r.save({data:s.sendData},function(){
				l.path('/trabajadores');
			});
		}
	}]);
	//Read one && Update One
	app.controller('getOne', ['$scope','$routeParams','Resource','$location','$stateParams', function(s,p,r,l,sp){
		//s.sendData = {};
		//s.id=sp.id;
		s.boton="Editar";
		//console.log(s.id);
		//console.log(sp.id):
		s.sendData = r.get({id:sp.id});
		s.save = function(){
			r.update({id:s.sendData.id},{data:s.sendData},function(data){
				console.log(data);
				l.path('/trabajadores');
			});
		}
	}]);
	//Read all && Del One
	app.controller('getAll', ['$scope','Resource','$location', function(s,r,l){
		s.trabajadores = r.query();
		s.del = function(id){
			r.delete({id:id}, function(datos){
				console.log(datos);
				$route.reload(false);
			});
		}
	}]);

	app.controller('preplanilla',['$scope','prepResource','fincaResource', function(s,pr,fr){
		s.prepSendData = {};
		s.preplanillas = pr.query();
		//s.fincas  = fr.query();
		//s.fincas = s.preplanillas.finca;
		s.prepTrab = function() {
			console.log(s.prepSendData);
			// console.log(s.preplanillas);
			pr.save({data:s.prepSendData});
		}
	}]);
}());
