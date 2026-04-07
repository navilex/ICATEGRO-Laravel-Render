<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;

class StudentController extends Controller
{
    public function create()
    {
        return view('students.create');
    }

    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function checkCurp($curp)
    {
        // Check if student already exists
        $student = Student::where('curp', $curp)->first();
        if ($student) {
            return response()->json(['exists' => true, 'type' => 'student', 'data' => $student]);
        }

        // Check if user/instructor exists (assuming username stores CURP)
        $user = \App\Models\User::where('username', $curp)->first();
        if ($user) {
            return response()->json([
                'exists' => true,
                'type' => 'user',
                'data' => [
                    'name' => $user->name,
                    'lastname1' => $user->lastname, // Assuming lastname field stores first lastname or full lastname
                    'lastname2' => '', // Users table only has 'lastname'
                    // Add logic to split lastname if needed, but for now return as is
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'curp' => 'required|unique:students|max:255',
            'name' => 'required|max:255',
            'lastname1' => 'required|max:255',
            'lastname2' => 'nullable|max:255',
            'blood_type' => 'nullable|max:255',
            'civil_status' => 'nullable|max:255',
            'state' => 'required|max:255',
            'municipality' => 'required|max:255',
            'locality' => 'required|max:255',
            'colony' => 'required|max:255',
            'street' => 'required|max:255',
            'exterior_number' => 'required|max:255',
            'interior_number' => 'nullable|max:255',
            'zip_code' => 'required|max:255',
            'phone1' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        // Set default values for nullable fields
        $validatedData['lastname2'] = $validatedData['lastname2'] ?? 'N';
        $validatedData['blood_type'] = $validatedData['blood_type'] ?? 'N';
        $validatedData['civil_status'] = $validatedData['civil_status'] ?? 'N';
        $validatedData['interior_number'] = $validatedData['interior_number'] ?? 'N';
        $validatedData['phone2'] = $validatedData['phone2'] ?? '0';

        $validatedData['user_id'] = auth()->id() ?? 1; // Fallback to 1 if no auth for safe seeding

        Student::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Alumno registrado correctamente.');
    }

    public function show(Student $student)
    {
        $student->load(['cursos.grupo.plantel', 'cursos.curso', 'creator']);
        return view('students.show', compact('student'));
    }
}
