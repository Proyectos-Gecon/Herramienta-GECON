<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class PresupuestosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('upload');
        $this->middleware('permission:USER DEPPC|ADMIN')->only('index');
    }

    public function index(Request $request){

        $proyectos = Proyecto::construccion()->get();
        return inertia('presupuestos/index', ['proyectos' => $proyectos]);
    }

    public function upload(Request $request){

    }
}
