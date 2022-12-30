<?php

use App\Http\Controllers\ClaseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    
    Route::resource('clases', ClaseController::class);
    Route::get('clases.upload', [ClaseController::class, 'upload'])->name('clases.upload');
    
});