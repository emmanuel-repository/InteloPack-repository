<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Auth::routes();
// Route::get('/', function () {return view('welcome');});
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'InicioController@index')->name('inicio');
Route::get('/login_empleados', 'Auth\LoginEmpleadoController@index')->name('login_empleados');
Route::post('/login_empleados', 'Auth\LoginEmpleadoController@login')->name('login_empleado.submit');
Route::post('/logout', 'Auth\LoginEmpleadoController@logout')->name('empleado.logout');
Route::resource('rastreo_paquete', 'RastreoController');
Route::resource('politicas_privacidad', 'PoliticasPrivacidadController');

Route::prefix('empleado')->group(function () {
    Route::resource('bienvenida', 'BienvenidaController');
    Route::resource('gestion_empleados', 'EmpleadoController');
    Route::resource('paquete', 'PaqueteController');
    Route::resource('cliente', 'ClienteController');
    Route::resource('socursal', 'SocursalController');
    Route::resource('gestion_paqueteria', 'GestionPaqueteriaController');
    Route::resource('folios_recoleccion', 'FoliosRecoleccionController');
    Route::resource('transportes', 'TransporteController');
    Route::resource('transporte_empleado', 'TransposteEmpleadoController');
    Route::resource('cargar_paquetes', 'CargarPaqueteController');
    Route::resource('descarga_paquetes', 'DescargaPaqueteController');
    Route::resource('entrega_paquete', 'EntregaPaqueteController');
    Route::resource('paquete_repartidor', 'PaqueteRepartidorController');
    Route::post('paquete/create_eventual', 'PaqueteController@create_paquete_eventual')
        ->name('paquete.create_eventual');
    Route::resource('soporte', 'SoporteController');
    Route::resource('prueba', 'PruebaController');
});
