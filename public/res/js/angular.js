
(function(){
	'use strict';
	
	//Create a new Angular module
	angular.module('moduleName',["ngRoute","ngResource"]);

	//Use an exist Angular Module
	var app = angular.module('moduleName');

	//Service Factory resource
	app.factory('Resource', ['$resource', function(r){
		return r('admin/personas/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	
	
	//angular routes config
	app.config(function ($routeProvider) {
	$routeProvider  
	    .when('/admin/personas', {
	      templateUrl: 'partials/personas.html',
	      controller: 'postOne',
	      controllerAs: 'CR0'
	    })
	    .when('/admin/listar', {
	      templateUrl: 'partials/listar.html',
	      controller: 'getAll',
	      controllerAs: 'CR1'
	    })
	    .when('/admin/editar/:id', {
	      templateUrl: 'partials/personas.html',
	      controller: 'getOne',
	      controllerAs: 'CR2'
	    })
	    .otherwise({
	      redirectTo: '/'
	    });
	});
	//Create one
	app.controller('postOne', ['$scope','Resource', function(s,r){
		s.sendData = {};
		s.save = function(){
			r.save({data:s.sendData});	
		}
	}]);
	//Read one && Update One
	app.controller('getOne', ['$scope','$routeParams','Resource', function(s,p,r){
		//s.sendData = {};
		s.sendData = r.get({id:p.id});
		s.save = function(){
			r.update({id:s.sendData.id},{data:s.sendData},function(data){
				console.log(data);
			});	
		}
	}]);
	//Read all && Del One
	app.controller('getAll', ['$scope','Resource', function(s,r){
		s.personas = r.query();
		s.del = function(id){
			r.delete({id:id}, function(datos){
				console.log(datos);
				location.reload();
			});
		}
	}]);
	//Update one
	/*app.controller('putOne', ['$scope','$routeParams','Resource', function(){
		
	}])*/
	//Delete one
	/*app.controller('delOne', ['$scope','$routeParams','Resource', function(s,p,r){
		s.del = function(){
			r.delete({id:p.id}, function(datos){
				console.log(datos);
			});
		}
	}]);*/
	//Create and append a new cotroller for your module
	app.controller("controllerName",['$scope',"$http","$resource","$routeParams", function(s,h,r,p,$routeParams){
		//Resource 
		var Personas = r('admin/personas/:id',{id:"@id"},{update:{method:"PUT"}});

		//Data saliente y entrante
		s.sendData = {};
		s.enterData = [];

		/*s.gotoPersonas = function(){
			h.get('admin/personas')
			.success(function(data, status, headers, config){
				console.log(data);
				//console.log(status);
				//console.log(headers);
				//console.log(config);
			})
		}*/
		//Resourse Rest Functions/Methods
		/*s.obtener = function(aid){
			s.sendData = Personas.get({id:aid});
			console.log(s.sendData);
		}*/
		/*s.save = function(){
			Personas.save({data:s.sendData}, function(datas) {
				console.log(datas);
			});
		}*/

		/*s.read = function(){
			s.personas = Personas.query();
				//s.enterData.push(Personas.query());
			//console.log(s.personas);
		}*/
		/*s.del = function(id){
			//console.log(id);
			Personas.delete({id:id}, function(datos){
				console.log(datos);
			});
		}*/
		/*s.upd =  function(id) {
			console.log(id);
			Personas.update({id:id},{data:s.sendData}, function(dat){
				console.log(dat);
			});
		}*/
	}]);
}());