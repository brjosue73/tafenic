<?php


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');
});

// Route::get('profile', ['middleware' => 'auth', function() {
    // Route::get('/', function () {
    //     return view('auth.login');
    // });
    // Only authenticated users may enter...
    Route::resource('trabajadores','TrabajadoresController');
    Route::resource('fincas','FincasController');
    Route::resource('actividad','ActividadesController');
    Route::resource('labor','LaboresController');
    Route::resource("preplanilla",'PreplanillasController');
    Route::resource("lotes",'LotesController');

    Route::get('/constantes','PreplanillasController@constantes');
    Route::post('/prep_fecha', 'PreplanillasController@preplanilla_fecha');

    Route::post('/actualizar_prep','PreplanillasController@actualizar');

    Route::post('labor_act','LaboresController@labor_por_actividad');
    Route::post('lotes_finca','LotesController@lotes_por_finca');
    Route::post('actividad_finca', 'ActividadesController@actividad_por_finca');

    Route::post('prep_trab','TrabajadoresController@prep_trab');
    Route::post('planilla_finca','FincasController@planilla_finca');

    Route::resource("variables",'VariablesController');

    Route::post('planilla','PlanillasController@planilla_general');
    Route::post('reporte_catorcenal','PlanillasController@reporte_planilla');
    Route::post('sobres_catorcenal','PlanillasController@sobres_catorcenal');

    Route::get('reporte_catorcenal','PlanillasController@inss_catorcenal');
    Route::get('erpote_quincenal','PlanillasController@inss_catorcenal');


    Route::get('listero',"TrabajadoresController@listero");
    Route::get('resp_finca',"TrabajadoresController@resp_finca");
    Route::get('campo',"TrabajadoresController@campo");
    Route::get('trab_quinc',"TrabajadoresController@quincenal");
    Route::post('eliminar_catorcenal','PlanillasController@eliminar');

    Route::resource('acumulados','AcumuladosController');

    Route::post('quincenales','quincenalesController@quincenales');
    Route::post('planilla_quincenal','quincenalesController@quincenal_fecha');
    Route::post('guardar_quincenal','quincenalesController@g_quincenal');
    Route::get('actualizar_quincenal','quincenalesController@a_quincenal');
    Route::get('quincen_edit','quincenalesController@edit');
    Route::post('quincen_update','quincenalesController@update');

    Route::post('sobres_quincenal','quincenalesController@sobres_quincenal');
    Route::post('reporte_quincenal','quincenalesController@reporte_quincenal');
    Route::post('eliminar_quincenal','quincenalesController@eliminar');

    Route::post('billetes_quince','quincenalesController@billetes');
    Route::post('editar_quince','quincenalesController@editar_quince');
    Route::get('datos_fincas',"FincasController@datos_fincas");
    // Route::get('pdf2', function(){
    //   $a[]='hola';
    //   $pdf = PDF::loadView('pdf',['user'=>$a]);
    //   $pdf->setPaper('legal', 'landscape');
    //   //return $pdf->download('planilla_quincenal.pdf');
    //   // $pdf = App::make('dompdf.wrapper');
    //   // $pdf->loadHTML('<h1>Test</h1>');
    //   return $pdf->stream();
    // });
