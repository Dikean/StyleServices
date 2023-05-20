<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
   // Rutas Servicios
Route::get('/services', [App\Http\Controllers\admin\ServicesController::class, 'index']);
Route::get('/services/create', [App\Http\Controllers\admin\ServicesController::class, 'create']);
Route::get('/services/{services}/edit', [App\Http\Controllers\admin\ServicesController::class, 'edit']);
Route::post('/services', [App\Http\Controllers\admin\ServicesController::class, 'sendData']);
Route::put('/services/{services}', [App\Http\Controllers\admin\ServicesController::class, 'update']);
Route::delete('/services/{services}', [App\Http\Controllers\admin\ServicesController::class, 'destroy']);

// Rutas Estilistas
Route::resource('estilistas', 'App\Http\Controllers\admin\EstilistaController');

// Rutas Clientes
Route::resource('clientes', 'App\Http\Controllers\admin\ClienteController');

// Rutas Reportes
    Route::get('/reportes/citas/line', [App\Http\Controllers\admin\ChartController::class, 'appointments']);
Route::get('/reportes/estilistas/column', [App\Http\Controllers\admin\ChartController::class, 'estilistas']);

Route::get('/reportes/estilistas/column/data', [App\Http\Controllers\admin\ChartController::class, 'estilistasJson']);
}); 

Route::middleware(['auth', 'estilista'])->group(function () {

    Route::get('/horario', [App\Http\Controllers\estilista\HorarioController::class, 'edit']);
    Route::post('/horario', [App\Http\Controllers\estilista\HorarioController::class, 'store']);


});

Route::middleware('auth')->group(function(){
    Route::get('/reservarcitas/create', [App\Http\Controllers\AppointmentController::class, 'create']);
    Route::post('/reservarcitas', [App\Http\Controllers\AppointmentController::class, 'store']);
    Route::get('/miscitas', [App\Http\Controllers\AppointmentController::class, 'index']);
    Route::get('/miscitas/{appointment}', [App\Http\Controllers\AppointmentController::class, 'show']);
    Route::post('/miscitas/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel']);
    Route::post('/miscitas/{appointment}/confirm', [App\Http\Controllers\AppointmentController::class, 'confirm']);
    Route::get('/miscitas/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'formCancel']);
    



  
});



