<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresupuestosController extends Controller
{
    //

    public function index(Request $request){
        return inertia('presupuestos/index');
    }
}
