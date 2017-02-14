(function(){
	'use strict';
	/*******************************************************************************************************************\
		Create a new angular module
	\*******************************************************************************************************************/
	angular.module('moduleName',["ngRoute","ngResource","ui.router"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
	}).filter("tipoCuje",function(){
		return function(tipo){
			if(tipo==0){
				return "Pequeño";
			}else if (tipo==1) {
				return "Grande";
			}
		}
	}).filter("tipoTrab",function(){
		return function(tipo){
			if(tipo==0){
				return "Catorcenal";
			}else if (tipo==1) {
				return "Quincenal";
			}
		}
	}).filter("estadoTrab",function(){
		return function(tipo){
			if(tipo==0){
				return "Inactivo";
			}else if (tipo==1) {
				return "Activo";
			}
		}
	}).filter("labelState",function(){
		return function(tipo){
			if(tipo==0){
				return "label-danger";
			}else if (tipo==1) {
				return "label-success";
			}
		}
	}).filter("centroCosto", function(){
		return function(centro){
			switch (centro) {
				case 0:
					return "Tabaco Sol";
					break;
				case 1:
					return "Tabaco Tapado";
					break;
				case 2:
					return "Semillero";
					break;
				case 3:
					return "Ensarte";
					break;
				case 4:
					return "Safadura";
					break;
				default: return "NaCC";

			}
		}
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
	app.factory('loteResource', ['$resource', function(r){
	 	return r('lotes/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('prepResource', ['$resource', function(r){
		return r('preplanilla/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('planillaResource', ['$resource', function(r){
		return r('planilla/:id',{id:"@id"},{update:{method:"PUT"}});
	}]);
	app.factory('variablesResource', ['$resource', function(r){
		return r('variables/:id',{id:"@id"},{update:{method:"PUT"}});
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
			controller:"getAll"
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
		.state('/preplanillaR', {
			url: "/preplanilla_repote",
			templateUrl: "partials/preplanillas/prepReport.html",
			controller:"preplanilla"
		})
		.state('/labsRep', {
			url: "/reporte-de-labores",
			templateUrl: "partials/preplanillas/prepxFinc.html",
			controller:"preplanillaLab"
		})
		.state('/preplanilla.editar',{
			url: "/editar/:id",
			templateUrl: "partials/preplanillas/prepEdit.html",
			controller: "catorcenalEditar"
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
		.state('/fincas.ver', {
			url: "/finca/:id",
			templateUrl: "partials/fincas/unaFinca.html",
			controller:"fincaOneController"
		})
		.state('/planilla',{
			url:"/planilla",
			templateUrl: "partials/planillas/planillas.html",
			controller: "planillaController"
		})
		.state('/RplanillaQ',{
			url:"/reporte_planilla_quincenal",
			templateUrl: "partials/reportes/RplanillasQ.html",
			controller: "RplanillaQController"
		})
		.state('/quincenal-editar', {
			url:"/quincenal-editar/:id",
			templateUrl:"partials/planillas/planilla.html",
			controller:"quincenalEditar"
		})
		.state('/planillaq',{
			url:"/planilla_quincenal",
			templateUrl: "partials/planillas/planilla.html",
			controller: "planillaQController"
		})
		.state('/reportes', {
			url:"/reportes",
			templateUrl: "partials/reportes/reportesPanel.html"
		})
		.state('/totalescc', {
			url:"/totales-centros-costos",
			templateUrl: "partials/reportes/totalescc.html",
			controller: "centrosCostos"
		});
	});
	/*******************************************************************************************************************\
		Create and append a new cotrollers for your exist module in use
	\*******************************************************************************************************************/
	//Finca Controller
	app.controller("fincaController",['$scope','$http','fincaResource','actividadResource','laborResource','loteResource','$location','$stateParams', function(s,h,fr,ar,lr,ltr,l,sp){

		var $btnFAceptar = $('#fincAceptar') ;

		/***************************************/
		h.get('/datos_fincas')
		.success(function(data){
			console.log(data);
			s.nuevas_Fincas = data;
		})
		.error(function(err){
			console.log(err);
		});
		/***************************************/
		/*s.fincas = fr.query();
		s.lasactividades = ar.query();*/

		s.fincaSaveData = {};
		s.actividadSaveData = {};
		s.laborSaveData = {tipo_lab:"hora"};
		s.loteSaveData = {};

		/*s.getActividade = function(){
			h.post('actividad_finca',{id_finca:s.actividadSaveData.id_finca})
			.success(function(data){
				s.actividades = data;
			})
			.error(function(err){
				console.log(err);
			});
		}*/
		s.loteSave = function(fincIndex) {
			s.loteSaveData.lote = s.nuevas_Fincas[fincIndex-1].lotes.length+1;
			s.loteSaveData.id_finca = fincIndex;
			//console.log(s.nuevas_Fincas[fincIndex-1].lotes.length);
			//console.log(fincIndex);
			console.log(s.loteSaveData);
			//$('#loteSpinner').css("display", "inline-block");

			ltr.save({data:s.loteSaveData}, function(res) {
				console.log(res);
				s.nuevas_Fincas[fincIndex-1].lotes.push(res);
				/*$('#loteSpinner').css("display", "none");
				$('#exitolote').css("display","inline");
				setTimeout(function(){
					$('#exitolote').css("display","none");
				},3000);*/
				//s.fincas = fr.query();
			},function(err){
				/*console.log(err.status);
				$('#loteSpinner').css("display", "none");
				$('#errorlote').css("display","inline");
				setTimeout(function(){
					$('#errorlote').css("display","none");
				},3000)*/
			});
		}
	  s.fincaSave = function(){
	  	//console.log(s.fincaSaveData);

			$('#fincaSpinner').css("display", "inline-block");

			fr.save({data:s.fincaSaveData}, function(res) {
				console.log(res);
				s.nuevas_Fincas.push(res)
				$('#registro-finca')[0].reset();
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
		s.actividadSave = function(idfinca){
			var $formAct = $(".form-act");

			s.actividadSaveData.id_finca = idfinca;
			s.actividadSaveData.nombre = $formAct[idfinca-1].value;

			if(s.actividadSaveData.nombre == "" || s.actividadSaveData.nombre.length == 0){
				$formAct[idfinca-1].parentNode.className += " has-error";
				//console.log($formAct[idfinca-1].parentNode);
			} else {
				$(".form-group").removeClass(" has-error");
				var spinners = document.getElementsByClassName('actSpinner');
				var successAlert = document.getElementsByClassName('exitoact');
				var errorAlert = document.getElementsByClassName('erroract');

				spinners[idfinca-1].style.display = "inline-block";

				ar.save({data:s.actividadSaveData}, function(res) {
					$('.form-control').val('');
					s.nuevas_Fincas[idfinca-1].actividades.push(res);
					spinners[idfinca-1].style.display = "none";
					successAlert[idfinca-1].style.display = "inline";
					setTimeout(function(){
						successAlert[idfinca-1].style.display = "none";
					},3000);
				},function(err){
					console.log(err.status);
					spinners[idfinca-1].style.display = "none";
					errorAlert[idfinca-1].style.display = "block";
					setTimeout(function(){
						errorAlert[idfinca-1].style.display = "none";
					},3000)
				});
			}
		}
		s.laborSave = function(idactividad, idfinca, indice){
			s.laborSaveData.id_actividad = idactividad;
			if($('.chklabor').is(':checked')){
				s.laborSaveData.tipo_lab = "prod"
				console.log(s.laborSaveData.tipo_lab);
			} else {
				s.laborSaveData.tipo_lab = "hora";
			}
			console.log(s.laborSaveData);
			console.log(indice);
			//console.log(idfinca);
			//console.log(s.nuevas_Fincas);
			$('#laborSpinner').css("display", "inline-block");
			lr.save({data:s.laborSaveData}, function(res) {
				console.log(res);
				$('.form-control').val('');
				$('.chklabor').prop('checked', false);
				s.nuevas_Fincas[idfinca-1].actividades[indice].labores.push(res);
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
		s.delAct = function(idAct, indice, Pindice, fincId){
			console.log(idAct, indice, Pindice, fincId);
			ar.delete({id:idAct}, function(res){
				console.log(res);
				s.nuevas_Fincas[Pindice].actividades.splice(indice, 1);
			}, function(err){
				console.log(err);
			});
		}

		s.delLab = function(fincId, actId, id, labId) {
			console.log(fincId, actId, id, labId);
			lr.delete({id:labId}, function(res){
				console.log(res);
				s.nuevas_Fincas[fincId-1].actividades[actId].labores.splice(id, 1);
			}, function(err){
				console.log(err);
			});
		}
	}]);
	app.controller('fincaOneController', ['$scope','fincaResource','$stateParams','laborResource','actividadResource', function(s,fr,sp,lr,ar){
		s.unaFinca = fr.get({id:sp.id}, function(data){
			console.log(data);
		});
		s.estaAct = ar.query(function(data){
			console.log(data);
		});
		s.estaLab = lr.query(function(data){
			console.log(data);
		})
	}]);
	/*TRABAJADOR REST CONTROLLERS*/
	//Create one
	app.controller('postOne', ['$scope','Resource','$location', function(s,r,l){
		s.titulo = "Ingreso de trabajadores nuevos";
		s.boton = "Guardar";
		s.sendData = {};
		s.save = function(){
			$('#trabSpinner').css("display", "inline-block");
			r.save({data:s.sendData},function(){
					$('#trabSpinner').css("display", "none");
					$('#exitotrab').css("display","inline");
					//s.$apply();
					setTimeout(function(){
						$('#exitotrab').css("display","none");
						$("#trabForm")[0].reset();
					},1000);
				},function(err){
					console.log(err.status);
					$('#trabSpinner').css("display", "none");
					$('#errortrab').css("display","block");
					setTimeout(function(){
						$('#errortrab').css("display","none");
					},3000);
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
			$('#trabSpinner').css("display", "inline-block");
			r.update({id:s.sendData.id},{data:s.sendData},function(data){
				$('#trabSpinner').css("display", "none");
				$('#exitotrab').css("display","inline");
				$('#exitotrab').css("display","none");
				$("#trabForm")[0].reset();
				l.path('/trabajadores');
				/*setTimeout(function(){
					$('#exitotrab').css("display","none");
					$("#trabForm")[0].reset();
					l.path('/trabajadores');
				},100);*/
				//l.path('/trabajadores');
			},function(err){
				console.log(err.status);
				$('#trabSpinner').css("display", "none");
				$('#errortrab').css("display","block");
				setTimeout(function(){
					$('#errortrab').css("display","none");
				},3000);
			});
		}
	}]);
	//Read all && Del One
	app.controller('getAll', ['$scope','Resource','$location','$http', function(s,r,l,h){
		//s.busquedaCriteria = "";
		s.sorting = "nombre";
		s.filtrar = "todos";
		s.trabajadores = r.query();

		s.titulo = "Ingreso de trabajadores nuevos";
		s.boton = "Guardar";
		s.sendData = {};
		s.save = function(){
			$('#save-trab').attr("disabled","disabled");
			$('#trabSpinner').css("display", "inline-block");
			r.save({data:s.sendData},function(data){
					$('#trabSpinner').css("display", "none");
					$('#exitotrab').css("display","inline");
					setTimeout(function(){
						$('#exitotrab').css("display","none");
						$("#trabForm")[0].reset();
						$('#save-trab').removeAttr("disabled");
					},3000);
					s.trabajadores.push(data);
				},function(err){
					console.log(err.status);
					$('#trabSpinner').css("display", "none");
					$('#errortrab').css("display","block");
					setTimeout(function(){
						$('#errortrab').css("display","none");
						$('#save-trab').removeAttr("disabled");
					},3000);
			});
		}
		/*s.del = function(id){
			r.delete({id:id}, function(datos){
				console.log(datos);
				l.path('/trabajadores');
			});
		}
		s.trabRespFinc = {};
		s.trabListero = {};
		s.trabCampo = {};
						h.get('resp_finca').success(function(data){
							s.trabRespFinc = data;
						});
						h.get('listero').success(function(data){
							s.trabListero = data;
						});
						h.get('campo').success(function(data){
							s.trabCampo = data;
						});

		s.verinactivos = function(){
			console.log("otro");
		}*/
	}]);
	/*PREPLANILLA CONTROLLERS*/
	app.controller('preplanilla',['$scope','prepResource','$http','fincaResource','loteResource', function(s,pr,h,fr,lr){
		s.prepSendData = {
			otros:0,
			feriado:0,
			hora_trab: 8,
			hora_ext:0,
			prestamos:0,
			labName: "",
			safa_ext: 0,
			cuje_ext: 0,
			septimo: 0,
			centro_costo: 0
		};
		s.ordenar = 'cant_horas_ext';
		s.preplanillas = pr.query();
		s.lasfincas = fr.query();

		s.labValue = 0;

		s.selectLab = function(){
			var labSelected = $('#laborSelect option:selected').text();
			//s.labValue = labSelected;
			if (labSelected == "safadura" || labSelected == "Safadura" || labSelected == "Safa" || labSelected == "safa") {
				s.labValue = 1;
				s.prepSendData.labName = "safadura";
				console.log(s.prepSendData.labName);
			} else if (labSelected == "ensarte" || labSelected == "Ensarte") {
				s.labValue = 2;
				s.prepSendData.labName = "cuje";
				console.log(s.prepSendData.labName);
			} else {
				s.labValue = 0;
				s.prepSendData.labName = "";
			}
			console.log(s.labValue);
		}
		s.getActividades = function(){
			h.post('actividad_finca',{id_finca:s.prepSendData.id_finca})
			.success(function(data){
				s.lasactividades = data;
			})
			.error(function(err){
				console.log(err);
			});
			/*lr.get({id:s.prepSendData.id_finca}, function(data){
				s.loslotes = data;
				console.log(s.loslotes);
			})*/
			h.get('lotes/' + s.prepSendData.id_finca)
			.success(function(data){
				s.loslotes = data;
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
		/*$('#chkSub').change(function(){
					var cb;
		     cb = $(this);
		     cb.val(cb.prop('checked'));
				 s.prepSendData.subsidio = cb.val();
				 console.log(s.prepSendData.subsidio);
		 });*/

		$("#trabajadorSelect").blur(function(){
			document.getElementById("save-preplanilla").focus();
		});
		s.prepTrab = function() {
			s.prepSendData.subsidio = $('#chkSub').prop('checked');
			$('#save-preplanilla').attr("disabled", "disabled");
			$('#prepSpinner').css("display", "inline-block");
			console.log(s.prepSendData);
			//$('#chkSub').prop('checked',false);
			pr.save({data:s.prepSendData}, function(){

							$('#prepSpinner').css("display", "none");
							$('#exitoprep').css("display","inline");
							setTimeout(function(){
								$('#exitoprep').css("display","none");
								$("#clean")[0].reset();
								s.prepSendData.hora_ext = 0;
								s.prepSendData.otros = 0;
								s.prepSendData.prestamos = 0;
								s.prepSendData.septimo = 0;
								s.prepSendData.safa_ext = 0;
								s.prepSendData.cuje_ext = 0;
								$('#chkSub').prop('checked',false);
								//s.prepSendData.feriado = "";
								$("input:radio").removeAttr("checked");
								s.prepSendData.feriado = 0
								$('#save-preplanilla').removeAttr("disabled");
								document.getElementById("trabajadorSelect").focus();
								//s.prepSendData.subsidio = false;
							},1500);
						},function(err){
							console.log(err.status);
							$('#prepSpinner').css("display", "none");
							$('#errorprep').css("display","block");
							setTimeout(function(){
								$('#errorprep').css("display","none");
								$('#save-preplanilla').removeAttr("disabled");
								$("input:radio").removeAttr("checked");
								s.prepSendData.feriado = 0;
							},3000);


			});
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

		s.trabRespFinc = {};
		s.trabListero = {};
		s.trabCampo = {};
		h.get('resp_finca').success(function(data){
			s.trabRespFinc = data;
		});
		h.get('listero').success(function(data){
			s.trabListero = data;
		});
		h.get('campo').success(function(data){
			s.trabCampo = data;
		});
	}]);

	app.controller('prepxfinc',['$scope','$http','fincaResource', function(s,h,fr){
		s.title = "Planilla por Fincas";
		s.fincs = fr.query();
		s.reporfinca = {};
		s.ordeReal = 'nombre';
		s.getPrepxfinc = function(){
			$('#ccreportpin').css("display", "inline-block");
			h.post('planilla_finca',s.reporfinca)
			.success(function(data){
				s.reporfincTot = [];
				for (var i = 0; i < data.length - 1; i++) {
					s.reporfincTot.push(data[i]);
				}
				s.totales = data[data.length - 1];

				/*s.reporfincTot = data;
				s.totales = data[data.length-1];
				console.log(data);*/
				$('#ccreportpin').css("display", "none");
				$('#ccexitopin').css("display","inline");
				setTimeout(function(){
					$('#ccexitopin').css("display","none");
				},3500);
			})
			.error(function(err){
				$('#ccreportpin').css("display", "none");
				$('#ccerrorpin').css("display","inline");
				setTimeout(function(){
					$('#ccerrorpin').css("display","none");
				},3500);
			});
		}
		s.getActividad = function(){
			h.post('actividad_finca',{id_finca:s.reporfinca.id_finca})
			.success(function(data){
				s.lasactividades = data;
			})
			.error(function(err){
				console.log(err);
			});
		}

				s.revision = function(id, index, fechaini, fechafin) {
					s.reporTrab = {
						id_trab: id,
						fecha_ini: fechaini,
						fecha_fin: fechafin
					}
					s.nombre14 = "";
					console.log(id, index, fechaini, fechafin);
					h.post('prep_trab',s.reporTrab)
					.success(function(data){
						s.trab14data = data;
						s.trab14 = [];
						for (var i = 0; i < s.trab14data.length - 1; i++) {
							s.trab14.push(s.trab14data[i]);
						}
						s.nombre14 = data[data.length-1].nombre;
					})
					.error(function(err){
						console.log(err);
					});
				}
				s.delCatorce = function (id, index, fecha){
					var decision = prompt("¿esta seguro que desea eliminar este registro?", fecha);
					//console.log(decision);
					if (decision || decision == "") {
						h.delete('preplanilla/'+id)
						.success(function(data){
							console.log(data);
							s.getPlanilla();
						})
						.error(function(err){
							console.log(err);
						})
					} else {
						console.log("cancelado");
					}
				}

				s.updCatorce = function(idcatreg) {
					h.get('/preplanilla/'+idcatreg+'/edit');
				}


	}]);


	app.controller('valoresController',['$scope','variablesResource', function(s, vr){
		s.valoresSaveData;
		vr.query(function(data){
			s.valoresSaveData = data[0];
		});
		s.valorSave = function(){
			console.log(s.valoresSaveData);
			vr.save({data:s.valoresSaveData},function(data){
				console.log(data);
			})
		}
		s.valorUpdate = function(){
			console.log("funciona");
			$('#variableSpinner').css("display", "inline-block");
			vr.update({id:s.valoresSaveData.id},{data:s.valoresSaveData},function(data){

						$('#variableSpinner').css("display", "none");
						$('#exitovariable').css("display","inline");
						setTimeout(function(){
							$('#exitovariable').css("display","none");
						},3000);
					},function(err){
						console.log(err.status);
						$('#variableSpinner').css("display", "none");
						$('#errorvariable').css("display","block");
						setTimeout(function(){
							$('#errorvariable').css("display","none");
						},3000);
			});
		};
	}]);
	app.controller('planillaController',['$scope','$http','planillaResource', function(s,h,plr){
		s.plillaSendData = {};
		s.getPlanilla = function() {
			$('#14nalpanepin').css("display", "inline-block");
			//console.log(s.plillaSendData);
			//plr.query();
			h.post('/planilla',s.plillaSendData)
			.success(function(data) {
				s.reporfincTot = [];
				for (var i = 0; i < data.length - 1; i++) {

					let finUnicas = _.xor(data[i].fincas);
					let labUnicas = _.xor(data[i].labores);
					let cantLabs = _.countBy(data[i].labores, 'length');

					data[i].finUnicas = finUnicas;
					data[i].labUnicas = labUnicas;
					data[i].cantLabs = cantLabs;

					s.reporfincTot.push(data[i]);
				}
			  s.totales = data[data.length - 1];
				$('#14nalpanepin').css("display", "none");
				$('#14nalexitopin').css("display","inline");
				setTimeout(function(){
					$('#14nalexitopin').css("display","none");
				},3500);
			}).error(function(err){
				$('#14nalpanepin').css("display", "none");
				$('#14nalerrorpin').css("display","inline");
				setTimeout(function(){
					$('#14nalerrorpin').css("display","none");
				},3500);
			});
		}

		s.revision = function(id, index, fechaini, fechafin) {
			s.reporTrab = {
				id_trab: id,
				fecha_ini: fechaini,
				fecha_fin: fechafin
			}
			s.nombre14 = "";
			//console.log(id, index, fechaini, fechafin);
			h.post('prep_trab',s.reporTrab)
			.success(function(data){
				s.trab14data = data;
				s.trab14 = [];
				for (var i = 0; i < s.trab14data.length - 1; i++) {
					s.trab14.push(s.trab14data[i]);
				}
				s.nombre14 = data[data.length-1].nombre;
			})
			.error(function(err){
				console.log(err);
			});
		}
		s.delCatorce = function (id, index, fecha){
			var decision = prompt("¿esta seguro que desea eliminar este registro?", fecha);
			//console.log(decision);
			if (decision || decision == "") {
				h.delete('preplanilla/'+id)
				.success(function(data){
					console.log(data);
					s.getPlanilla();
				})
				.error(function(err){
					console.log(err);
				})
			} else {
				console.log("cancelado");
			}
		}

		s.updCatorce = function(idcatreg) {
			h.get('/preplanilla/'+idcatreg+'/edit');
		}
	}]);
	app.controller('RplanillaQController',['$scope','$http','planillaResource', function(s,h,plr){
		s.RplillaQSendData = {};
		s.getPlanillaRQ = function() {
			$('#15nalpanepin').css("display", "inline-block");
			//console.log(s.plillaSendData.fecha_ini.getDate()+15);
			//plr.query();
			h.post('/planilla_quincenal',s.RplillaQSendData)
			.success(function(data) {
				s.reporQuinc = [];
				for (var i = 0; i < data.length - 1; i++) {
					s.reporQuinc.push(data[i]);
				}
				s.totalesQ = data[data.length - 1];
				$('#15nalpanepin').css("display", "none");
				$('#15nalexitopin').css("display","inline");
				setTimeout(function(){
					$('#15nalexitopin').css("display","none");
				},3500);
			}).error(function(err){
				$('#15nalpanepin').css("display", "none");
				$('#15nalerrorpin').css("display","inline");
				setTimeout(function(){
					$('#15nalerrorpin').css("display","none");
				},3500);
			});
		}
		s.delQuince = function(id, index, reporteQ){
			//console.log(id, index);
			//s.reporQuinc.splice(index, 1);
			h.post('/eliminar_quincenal',{id:id} )
			.success(function(data) {
				console.log(data);
				s.reporQuinc = s.reporQuinc.filter(function(element){
					return element.id !== reporteQ.id;
				});
			})
			.error(function(err){
				console.log(err);
			})
		}
	}]);
	app.controller('planillaQController',['$scope','$http','fincaResource', function(s,h,fr){
		s.qButton = "Guardar";
		s.pqSendData = {};

		s.pqFincas = fr.query();
		h.get('trab_quinc').success(function(data){
			s.trabQ = data;
			//console.log(data);
		}).error(function(err){
			console.log(err);
		});

		s.pqSave = function(){
			$('#save-planilla').attr("disabled", "disabled");
			$('#PlaQSpinner').css("display", "inline-block");
			h.post('guardar_quincenal',s.pqSendData)
			.success(function(data){
				$('#PlaQSpinner').css("display", "none");
				$('#exitoPlaQ').css("display","inline");
				setTimeout(function(){
					$('#exitoPlaQ').css("display","none");
					$('#save-planilla').removeAttr("disabled");
				},3000);
				$('#formQuince')[0].reset();
			})
			.error(function(err){
				console.log(err.status);
				$('#PlaQSpinner').css("display", "none");
				$('#errorPlaQ').css("display","block");
				setTimeout(function(){
					$('#errorPlaQ').css("display","none");
					$('#save-planilla').removeAttr("disabled");
				},3000);
			});
		}
	}]);
	app.controller('quincenalEditar',['$scope','$http', function(s,h){
		s.qButton = "editar";

		h.post('editar_quince/:id',{id:sp.id})
		.success(function(data){
			s.regQince = data;
		})
		.error(function(err){
			console.log(err);
		});

		s.pqSave = function() {
			console.log(s.regQince);
		}
	}]);
	app.controller('catorcenalEditar', ['$scope', '$http', '$stateParams','prepResource', function(s,h,sp,pr) {
		s.updateModel = {
			//id_finca: ""
		};

		/*h.get('/fincas')
		.success(function(data){
			s.lasfincas = data;
		});*/

		/*s.getA = function(){
			console.log(s.updateModel);
			h.post('/actividad_finca',{id_finca:s.updateModel.id_finca})
			.success(function(data){
				s.lasactividades = data;
			})
			.error(function(err){
				console.log(err);
			});
			h.get('/lotes/' + s.updateModel.id_finca)
			.success(function(data){
				s.loslotes = data;
			});
		}*/
	}]);

	app.controller('centrosCostos', ['$scope', '$http', '$stateParams','prepResource', function(s,h,sp,pr){
		s.sendDataCC = {};
	  s.costosTotales = function(){
			$('#ccnalpanepin').css("display", "inline-block");

			//console.log("totales-centros-ostos");
			h.post('/planilla_fincas', s.sendDataCC)
			.success(function(data){

				s.totcc = [];
				for (var i = 0; i < data.length - 1; i++) {
					s.totcc.push(data[i]);
				}
				s.sumTotCC = data[data.length - 1];
				$('#ccnalpanepin').css("display", "none");
				$('#ccnalexitopin').css("display","inline");
				setTimeout(function(){
					$('#ccnalexitopin').css("display","none");
				},3500);
			}).error(function(err){
				$('#ccnalpanepin').css("display", "none");
				$('#ccnalerrorpin').css("display","inline");
				setTimeout(function(){
					$('#ccnalerrorpin').css("display","none");
				},3500);
			});
		}
	}])
	app.controller('preplanillaLab',['$scope','$http','fincaResource', function(s,h,fr){
		s.title = "Planilla por Actividades";
		s.fincs = fr.query();

		s.getPrepxfinc = function(){
				var activData = {
					id_finca: s.reporfinca.id_finca,
					fecha_ini: s.reporfinca.fecha_ini,
					fecha_fin: s.reporfinca.fecha_fin,
					centro_costo: s.reporfinca.centro_costo,
					nombre_cc: $('[name=centro_costo] :selected').text()
				}
			console.log(activData)
			h.post('/reporteActiv',activData)
			.success(function(data){
				console.log(data);
			})
		}
	}]);
}());
