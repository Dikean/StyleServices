<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

Route::get('/services', [App\Http\Controllers\Api\ServiceController::class, 'index']);
Route::get('/services/{services}/estilistas', [App\Http\Controllers\Api\ServiceController::class, 'estilistas']);
Route::get('/horario/horas', [App\Http\Controllers\Api\HorarioController::class, 'hours']);


Route::middleware('auth:api')->group(function(){    
     Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
     Route::get('/appointments', [App\Http\Controllers\Api\AppointmentController::class, 'index']);

     Route::post('/appointments', [App\Http\Controllers\Api\AppointmentController::class, 'store']);
});
