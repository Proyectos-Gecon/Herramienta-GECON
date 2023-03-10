<?php

use App\Http\Controllers\AvanceProyectoSemanalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\NovedadesController;
use App\Http\Controllers\ParteController;
use App\Http\Controllers\security\RolesController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\security\PermisosController;
use App\Http\Controllers\security\UserController;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'userLogin' => auth()->user()->id ?? null,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dashboard/personal', [DashboardController::class, 'personal'])->name('personal.dashboard');

    Route::get('personal/novedades', [NovedadesController::class, 'index'])->name('novedades.index');

    
    Route::resource('parte', ParteController::class);
    Route::resource('divisiones', DivisionController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permisos', PermisosController::class);
    Route::resource('users', UserController::class);

    
    Route::post('removeRolUser/{rol}/{user}', [UserController::class, 'removeRol'])->name('removeRolUser');
    Route::post('quitarRol/{permiso}/{rol}', [PermisosController::class, 'quitarRol'])->name('quitarRol');

   
});
