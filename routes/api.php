<?php

use App\Exports\PersonalExport;
use App\Http\Controllers\AvanceProyectoSemanalController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ProyectoController;
use App\Imports\Proyectos\ProyectosImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('clases/upload', [ClaseController::class, 'upload'])->name('clases.upload');
Route::post('contratos/upload', [ContratoController::class, 'upload'])->name('contratos.upload');
Route::post('proyectos/upload', [ProyectoController::class, 'upload'])->name('proyectos.upload');
Route::post('personal/upload', [PersonalController::class, 'upload'])->name('personal.upload');

Route::post('avance/upload/{proyecto}', [AvanceProyectoSemanalController::class, 'store'])->name('avance.upload');
Route::post('estructura/upload/{proyecto}', [AvanceProyectoSemanalController::class, 'store'])->name('estructura.upload');

Route::get('descargarParte', function (){
    Excel::download(new PersonalExport, 'personal.xlsx');
});