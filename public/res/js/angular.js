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
			url: "/editar/:id",
			templateUrl: "partials/trabajadores/actualizarT.html",
			controller:"getOne"
		})
		.state('/preplanilla', {
			url: "/preplanilla",
			templateUrl: "partials/preplanillas/prepPanel.html",
			controller:"preplanilla"
		})
		.state('/prepxtrab', {
			url: "/preplanilla_trabajador",
			templateUrl: "partials/preplanillas/prepxTrab.html",
			controller:"preplanilla"
		})
		.state('/fincas', {
			url: "/fincas",
			templateUrl: "partials/fincas/fincasPane.html",
			controller:"fincaController"
		})
	});
	/*******************************************************************************************************************\
		Create and append a new cotrollers for your exist module in use
	\*******************************************************************************************************************/
	//Finca Controller
	app.controller("fincaController",['$scope','$http','fincaResource', function(s,h,fr){
		var $btnFAceptar = $('#fincAceptar') ;
	  s.fincaSaveData = {};
		s.fincas = fr.query();
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
	//Actividad Controller
	app.controller("actividadController",['$scope','$http','actividadResource','fincaResource', function(s,h,ar,fr){
	  s.actividadSaveData = {};

		s.lasfincas = fr.query();
	  s.actividadSave = function(){
	    console.log(s.actividadSaveData);
	    ar.save({data:s.actividadSaveData});
	  }
	}]);
	//Labores controller
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
	/*TRABAJADOR REST CONTROLLERS*/
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
	app.controller('getOne', ['$scope','$stateParams','Resource','$location', function(s,sp,r,l){
		console.log(sp.id);
		s.boton="Editar";
		s.sendData = r.get({id:sp.id});

		s.save = function(){
			r.update({id:s.sendData.id},{data:s.sendData},function(data){

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
				l.path('/trabajadores');
			});
		}
	}]);
	/*PREPLANILLA CONTROLLERS*/
	app.controller('preplanilla',['$scope','prepResource','$http', function(s,pr,h){
		s.prepSendData = {};
		s.preplanillas = pr.query();

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
			console.log(s.reporTrab);
			h.post('prep_trab',s.reporTrab)
			.success(function(data){
				s.reporTrabTot = data;
				//console.log(data);
			})
			.error(function(err){
				console.log(err);
			});
		}
	}]);
}());
