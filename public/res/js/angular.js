(function(){
	'use strict';
	/*******************************************************************************************************************\
		Create a new angular module
	\*******************************************************************************************************************/
	angular.module('moduleName',["ngRoute","ngResource","ui.router"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
  });
	/*******************************************************************************************************************\
		Use an exist Angular Module
	\*******************************************************************************************************************/
	var app = angular.module('moduleName');
	/*******************************************************************************************************************\
		Service Factory resources REST with Backend
	\*******************************************************************************************************************/
	app.factory('Resource', ['$resource', function(r){
		return r('trabajadores/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('fincaResource', ['$resource', function(r){
	  return r('fincas/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('actividadResource', ['$resource', function(r){
	  return r('actividad/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('laborResource', ['$resource', function(r){
	  return r('labor/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('prepResource', ['$resource', function(r){
		return r('preplanilla/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	/*******************************************************************************************************************\
		App Routing
	\*******************************************************************************************************************/
	/*UI-ROUTER*/
	app.config(function($stateProvider, $urlRouterProvider) {
		$urlRouterProvider.otherwise("/");

		$stateProvider
		.state('/', {
			url: "/",
			templateUrl: "partials/adminPane.html"
		})
		.state('/adminPane', {
			url: "/admin",
			templateUrl: "partials/adminPane.html",
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
			url: "/editar/:id",
			templateUrl: "partials/trabajadores/actualizarT.html",
			controller:"getOne"
		})
		.state('/preplanilla', {
			url: "/preplanilla",
			templateUrl: "partials/preplanillas/prepPanel.html",
			controller:"preplanilla"/*,
			views:{
				'lateral':{
					templateUrl:"partials/preplanillas/lateral.html"
				}
			}*/
		})
		.state('/prepxtrab', {
			url: "/preplanilla_trabajador",
			templateUrl: "partials/preplanillas/prepxTrab.html",
			controller:"preplanilla"
		})
		.state('/prepxfinc', {
			url: "/preplanilla_finca",
			templateUrl: "partials/preplanillas/prepxFinc.html",
			controller:"prepxfinc"
		})
		.state('/fincas', {
			url: "/fincas",
			templateUrl: "partials/fincas/fincasPane.html",
			controller:"fincaController"
		})
		.state('/fincas.nueva', {
			url: "/nueva_finca",
			templateUrl: "partials/fincas/crearFinca.html",
			controller:"fincaController"
		})
	});
	/*******************************************************************************************************************\
		Create and append a new cotrollers for your exist module in use
	\*******************************************************************************************************************/
	//Finca Controller
	app.controller("fincaController",['$scope','$http','fincaResource','actividadResource','laborResource', function(s,h,fr,ar,lr){

		var $btnFAceptar = $('#fincAceptar') ;

		s.fincas = fr.query();
		s.lasactividades = ar.query();

		s.fincaSaveData = {};
		s.actividadSaveData = {};
		s.laborSaveData = {};

	  s.fincaSave = function(){
	  	console.log(s.fincaSaveData);

			$('#fincaSpinner').css("display", "inline-block");

			fr.save({data:s.fincaSaveData}, function(res) {
				console.log(res);
				$('#fincaSpinner').css("display", "none");
				$('#exitofinca').css("display","inline");
				setTimeout(function(){
					$('#exitofinca').css("display","none");
				},3000);
				s.fincas = fr.query();
			},function(err){
				console.log(err.status);
				$('#fincaSpinner').css("display", "none");
				$('#errorfinca').css("display","inline");
				setTimeout(function(){
					$('#errorfinca').css("display","none");
				},3000)
			});
	  }
		s.actividadSave = function(){
			console.log(s.actividadSaveData);
			$('#actSpinner').css("display", "inline-block");
			ar.save({data:s.actividadSaveData}, function(res) {
				console.log(res);
				$('#actSpinner').css("display", "none");
				$('#exitoact').css("display","inline");
				setTimeout(function(){
					$('#exitoact').css("display","none");
				},3000);
				s.lasactividades = ar.query();
			},function(err){
				console.log(err.status);
				$('#actSpinner').css("display", "none");
				$('#erroract').css("display","block");
				setTimeout(function(){
					$('#erroract').css("display","none");
				},3000)
			});
		}
		s.laborSave = function(){
			console.log(s.laborSaveData);
			$('#laborSpinner').css("display", "inline-block");
			lr.save({data:s.laborSaveData}, function(res) {
				console.log(res);
				$('#laborSpinner').css("display", "none");
				$('#exitolabor').css("display","inline");
				setTimeout(function(){
					$('#exitolabor').css("display","none");
				},3000);
			},function(err){
				console.log(err.status);
				$('#laborSpinner').css("display", "none");
				$('#errorlabor').css("display","block");
				setTimeout(function(){
					$('#errorlabor').css("display","none");
				},3000)
			});
		}
	}]);
	/*TRABAJADOR REST CONTROLLERS*/
	//Create one
	app.controller('postOne', ['$scope','Resource','$location', function(s,r,l){
		s.titulo = "Ingreso de trabajadores nuevos";
		s.boton = "Guardar";
		s.sendData = {};
		s.save = function(){
			r.save({data:s.sendData},function(){
				l.path('/trabajadores');
			});
		}
	}]);
	//Read one && Update One
	app.controller('getOne', ['$scope','$stateParams','Resource','$location', function(s,sp,r,l){
		console.log(sp.id);
		s.titulo = "Modificar Trabajador";
		s.boton="Editar";
		s.sendData = r.get({id:sp.id});

		s.save = function(){
			r.update({id:s.sendData.id},{data:s.sendData}/*,function(data){
				l.path('/trabajadores');
			}*/);
		}
	}]);
	//Read all && Del One
	app.controller('getAll', ['$scope','Resource','$location', function(s,r,l){
		s.buscar;
		s.trabajadores = r.query();
		s.del = function(id){
			r.delete({id:id}, function(datos){
				console.log(datos);
				l.path('/trabajadores');
			});
		}
	}]);
	/*PREPLANILLA CONTROLLERS*/
	app.controller('preplanilla',['$scope','prepResource','$http','fincaResource', function(s,pr,h,fr){
		s.prepSendData = {};
		s.preplanillas = pr.query();
		s.lasfincas = fr.query();
		s.getActividades = function(){
			h.post('actividad_finca',{id_finca:s.prepSendData.id_finca})
			.success(function(data){
				s.lasactividades = data;
			})
			.error(function(err){
				console.log(err);
			});
		}

		s.getLabores=function(){
			h.post('labor_act',{id_actividad:s.prepSendData.id_actividad})
			.success(function(data){
				s.laslabores = data;
				//console.log(data);
			})
			.error(function(err){
				console.log(err);
			});
		}

		s.prepTrab = function() {
			pr.save({data:s.prepSendData});
		}

			s.reporTrab = {};
		s.getPrepxTrab = function(){
			//console.log(s.reporTrab);
			h.post('prep_trab',s.reporTrab)
			.success(function(data){
				s.reporTrabTot = data;
				console.log(data);
			})
			.error(function(err){
				console.log(err);
			});
		}
	}]);

	app.controller('prepxfinc',['$scope','$http','fincaResource', function(s,h,fr){
		s.fincs = fr.query();
		s.reporfinca = {};

		s.getPrepxfinc = function(){
			h.post('planilla_finca',s.reporfinca)
			.success(function(data){
				s.reporfincTot = data;
				console.log(data);
			})
			.error(function(err){
				console.log(err);
			});
		}
	}]);
	app.controller('valoresController',['$scope', function(s){

	}]);
}());
