<?php

use App\Http\Controllers\Almacens\AlmacenController;
use App\Http\Controllers\Almacens\CategoriaController;
use App\Http\Controllers\Almacens\EquipoController;
use App\Http\Controllers\PresupuestosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function (){
    
    Route::get('presupuestos', [PresupuestosController::class, 'index'])->name('presupuestos.index');
    
});
