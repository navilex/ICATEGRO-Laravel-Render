<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plantel;
use App\Models\User;

class PlantelController extends Controller
{
    public function index()
    {
        $planteles = Plantel::all();
        $usuarios = User::all();

        return view('planteles.index', compact('planteles', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'clasificacion' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'clave_cct' => 'required|string|max:255|unique:planteles,clave_cct',
            'estado' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'colonia' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'numero_exterior' => 'required|string|max:255',
            'numero_interior' => 'nullable|string|max:255',
            'codigo_postal' => 'required|string|max:10',
            'tipo_asignacion' => 'required|string|max:255'
        ]);

        Plantel::create($request->all());

        return redirect()->route('planteles.index')->with('success', 'Plantel registrado correctamente.');
    }
}
