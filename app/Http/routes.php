<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

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
    
    Route::get('listero',"TrabajadoresController@listero");
    Route::get('resp_finca',"TrabajadoresController@resp_finca");
    Route::get('campo',"TrabajadoresController@campo");
