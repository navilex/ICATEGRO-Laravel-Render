<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plantel;

class ReporteController extends Controller
{
    public function alumnosGrupos()
    {
        $planteles = Plantel::all();
        return view('reportes.alumnos-grupos', compact('planteles'));
    }
}
