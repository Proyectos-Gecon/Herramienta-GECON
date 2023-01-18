<?php

use App\Http\Controllers\ClaseController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/* Route not need Login*/



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('proyectos/duplicate/{proyecto}', [ProyectoController::class, 'duplicate'])->name('proyectos.duplicate');

    Route::resource('clases', ClaseController::class);
    Route::resource('contratos', ContratoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('proyectos', ProyectoController::class);
});