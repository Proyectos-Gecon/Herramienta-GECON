<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class PresupuestosController extends Controller
{
    //

    public function index(Request $request){

        $proyectos = Proyecto::construccion()->get();
        return inertia('presupuestos/index', ['proyectos' => $proyectos]);
    }
}
