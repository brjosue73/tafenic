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

    Route::post('labor_act','LaboresController@labor_por_actividad');
    Route::post('lotes_finca','LotesController@lotes_por_finca');
    Route::post('actividad_finca', 'ActividadesController@actividad_por_finca');

    Route::post('prep_trab','TrabajadoresController@prep_trab');
    Route::post('planilla_finca','FincasController@planilla_finca');

    Route::resource("variables",'VariablesController');

    Route::post('planilla','PlanillasController@planilla_general');
    Route::post('reporte_catorcenal','PlanillasController@reporte_planilla');


    Route::get('listero',"TrabajadoresController@listero");
    Route::get('resp_finca',"TrabajadoresController@resp_finca");
    Route::get('campo',"TrabajadoresController@campo");
    Route::get('trab_quinc',"TrabajadoresController@quincenal");

    Route::resource('acumulados','AcumuladosController');

    Route::post('quincenales','QuincenalesController@quincenales');
    Route::get('planilla_quincenal','QuincenalesController@quincenal_fecha');
    Route::post('guardar_quincenal','QuincenalesController@g_quincenal');
    Route::get('actualizar_quincenal','QuincenalesController@a_quincenal');

    Route::get('reporte_quincenal','QuincenalesController@reporte_quincenal');

    // Route::get('pdf2', function(){
    //   $a[]='hola';
    //   $pdf = PDF::loadView('pdf',['user'=>$a]);
    //   $pdf->setPaper('legal', 'landscape');
    //   //return $pdf->download('planilla_quincenal.pdf');
    //   // $pdf = App::make('dompdf.wrapper');
    //   // $pdf->loadHTML('<h1>Test</h1>');
    //   return $pdf->stream();
    // });
