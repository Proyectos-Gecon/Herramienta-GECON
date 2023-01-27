<?php

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
    Route::get('personal/activos', [PersonalController::class, 'personalActivos'])->name('personal.activos');

    Route::resource('personal', PersonalController::class);
    Route::resource('parte', ParteController::class);
    Route::resource('divisiones', DivisionController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permisos', PermisosController::class);
    Route::resource('users', UserController::class);

    
    Route::post('removeRolUser/{rol}/{user}', [UserController::class, 'removeRol'])->name('removeRolUser');
    Route::post('quitarRol/{permiso}/{rol}', [PermisosController::class, 'quitarRol'])->name('quitarRol');


    // Route::get('actualizarPersonal', function (){
    //     $id = PersonalCorporativo::where('IDENTIFICACION' , '1143333192')->first()->ID;
    //     $persona = Personal::where('user_id', $id)->update([
    //         'division_id' => null
    //     ]);
    // //         $personas =  PersonalCorporativo::where('GERENCIA', 'LIKE', 'CONS')->leftJoin('BI_T503T_TIPOCONTRATO_View AS B', 'B.PERSK', 'LISTADO_PERSONAL_SAP_ACTIVOS_View2.TIPO_NOMINA')
    // //         ->leftJoin('FECHA_CONTRATO_PA0016_TYPE_View AS F', 'F.PERNR', 'NUM_SAP')
    // //         ->leftJoin('SALARIO_VIew AS S', 'S.PERNR', 'NUM_SAP')
    // //         ->orderBy('F.CTEDT', 'desc')->get()
    // //         ;

    // //         foreach ($personas as $key => $p) {
    // //             Personal::where('user_id', $p->ID)->
    // //             update([
    // //                 'costo_h' => (($p->BET01*1.6)/30)/8,
    // //                 'costo_d' => (($p->BET01*1.6)/30),
    // //                 'costo_m' => (($p->BET01*1.6)),
    // //             ]);
    // //         }
    // //     return back();
    // });
});
