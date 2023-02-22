<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonalController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function (){
    Route::get('activos', [PersonalController::class, 'personalActivos'])->name('personal.activos');

    Route::get('dashboard', [DashboardController::class, 'personal'])->name('personal.dashboard');

    Route::get('traerPersonal', [PersonalController::class , 'traerPersonal'])->name('traerPersonal');

    Route::get('getFinContratos/{dias}', [PersonalController::class , 'getFinContratos'])->name('getFinContratos');
    
    Route::get('getResumen/{fecha}', [PersonalController::class, 'getResumenPersonal'])->name('personal.getResumen');

    Route::resource('personal', PersonalController::class);
});

