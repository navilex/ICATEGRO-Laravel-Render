<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Plantel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $planteles = Plantel::all();
        return view('users.create', compact('planteles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curp' => ['required', 'string', 'max:18', 'unique:users,curp'],
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'lastname2' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'colony' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'exterior_number' => 'required|string|max:255',
            'interior_number' => 'nullable|string|max:255',
            'zip_code' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'adscription' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'role' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'plantel_id' => 'nullable|exists:planteles,id'
        ]);

        $user = User::create([
            'curp' => strtoupper($validated['curp']),
            'name' => strtoupper($validated['name']),
            'lastname' => strtoupper($validated['lastname']),
            'lastname2' => strtoupper($validated['lastname2'] ?? ''),
            'state' => strtoupper($validated['state']),
            'municipality' => strtoupper($validated['municipality']),
            'locality' => strtoupper($validated['locality']),
            'colony' => strtoupper($validated['colony']),
            'street' => strtoupper($validated['street']),
            'exterior_number' => strtoupper($validated['exterior_number']),
            'interior_number' => isset($validated['interior_number']) ? strtoupper($validated['interior_number']) : null,
            'zip_code' => $validated['zip_code'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'adscription' => strtoupper($validated['adscription']),
            'username' => strtolower($validated['username']),
            'password' => Hash::make($validated['password']),
            'role' => strtoupper($validated['role']),
            'permissions' => $validated['permissions'] ?? [],
            'plantel_id' => $validated['plantel_id'] ?? null
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Search for a CURP in students and instructors
     */
    public function searchCurp($curp)
    {
        $curp = strtoupper($curp);

        // check if curp is already registered as a User
        $user = User::where('curp', $curp)->first();
        if ($user) {
            return response()->json([
                'success' => false,
                'message' => 'Esta CURP ya está registrada en el sistema de usuarios.'
            ], 422);
        }

        // search in Instructors
        $instructor = Instructor::where('curp', $curp)->first();
        if ($instructor) {
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $instructor->nombre,
                    'lastname' => $instructor->apellido_1,
                    'lastname2' => $instructor->apellido_2 ?: 'X',
                    'source' => 'instructor'
                ]
            ]);
        }

        // search in Students
        $student = Student::where('curp', $curp)->first();
        if ($student) {
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $student->name,
                    'lastname' => $student->lastname1,
                    'lastname2' => $student->lastname2 ?: 'X',
                    'source' => 'student'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontraron registros previos para esta CURP.'
        ], 404);
    }
}
