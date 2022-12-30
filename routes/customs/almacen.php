<?php

use App\Http\Controllers\Almacens\AlmacenController;
use App\Http\Controllers\Almacens\CategoriaController;
use App\Http\Controllers\Almacens\EquipoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function (){
    
    Route::resource('categorias', CategoriaController::class);
    Route::resource('almacens', AlmacenController::class);
    Route::resource('equipos', EquipoController::class);
});
