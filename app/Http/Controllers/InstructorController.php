<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructores = \App\Models\Instructor::with('plantel')->get();
        return view('instructores.index', compact('instructores'));
    }

    public function create()
    {
        $planteles = \App\Models\Plantel::all();
        return view('instructores.create', compact('planteles'));
    }

    public function checkCurp($curp)
    {
        // Check if instructor already exists
        $instructor = \App\Models\Instructor::where('curp', $curp)->first();
        if ($instructor) {
            return response()->json([
                'exists' => true,
                'type' => 'instructor',
                'message' => 'La CURP ya se encuentra guardada con el registro No.' . $instructor->id . ' de ' . trim($instructor->nombre . ' ' . $instructor->apellido_1 . ' ' . $instructor->apellido_2)
            ]);
        }

        // Check if student exists
        $student = \App\Models\Student::where('curp', $curp)->first();
        if ($student) {
            return response()->json([
                'exists' => true,
                'type' => 'student',
                'data' => [
                    'nombre' => $student->name,
                    'apellido_1' => $student->lastname1,
                    'apellido_2' => $student->lastname2,
                ]
            ]);
        }

        // Check if user exists
        $user = \App\Models\User::where('username', $curp)->first();
        if ($user) {
            return response()->json([
                'exists' => true,
                'type' => 'user',
                'data' => [
                    'nombre' => $user->name,
                    'apellido_1' => $user->lastname,
                    'apellido_2' => '',
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'curp' => 'required|string|unique:instructors,curp',
            'nombre' => 'required|string',
            'apellido_1' => 'required|string',
            'tipo_sangre' => 'required|string',
            'estado_civil' => 'required|string',
            'estado' => 'required|string',
            'municipio' => 'required|string',
            'localidad' => 'required|string',
            'colonia' => 'required|string',
            'calle' => 'required|string',
            'numero_exterior' => 'required|string',
            'numero_interior' => 'nullable|string',
            'codigo_postal' => 'required|string',
            'telefono_1' => 'required|string',
            'telefono_2' => 'nullable|string',
            'email' => 'required|email',
            'email_trabajo' => 'nullable|email',
            'nombre_servicio_medico' => 'nullable|string',
            'escolaridad' => 'required|string',
            'condicion_escolar' => 'required|string',
            'nombre_escuela' => 'nullable|string',
            'cedula_profesional' => 'nullable|string',
            'registro_stps' => 'nullable|string',
            'tipo_instructor' => 'required|string',
            'experiencia_laboral' => 'required|numeric|min:0',
            'experiencia_docente' => 'required|numeric|min:0',
            'experiencia_sector_productivo' => 'required|numeric|min:0',
            'rfc' => ['required', 'string', 'regex:/^[A-ZÑ&]{4}\d{6}[A-Z0-9]{3}$/i'],
            // Files must be pdf and max 8MB (8192 KB)
            'archivo_identificacion' => 'required|file|mimes:pdf|max:8192',
            'archivo_curp' => 'required|file|mimes:pdf|max:8192',
            'archivo_acta_nacimiento' => 'required|file|mimes:pdf|max:8192',
            'archivo_comprobante_domicilio' => 'required|file|mimes:pdf|max:8192',
            'archivo_comprobante_estudios' => 'required|file|mimes:pdf|max:8192',
            'archivo_rfc' => 'required|file|mimes:pdf|max:8192',
            'archivo_constancias_cursos' => 'required|file|mimes:pdf|max:8192',
            'idiomas' => 'nullable|string', // JSON string from hidden input
            'habilidades' => 'nullable|string', // JSON string from hidden input
            'cursos' => 'nullable|string', // JSON string from hidden input
            'banco_tipo' => 'required|string',
            'banco_nombre' => 'required|string',
            'clabe' => 'nullable|string',
            'numero_cuenta' => 'nullable|string',
            'numero_tarjeta' => 'nullable|string',
            'archivo_estado_cuenta' => 'required|file|mimes:pdf|max:8192',
            'archivo_cv' => 'required|file|mimes:pdf|max:8192',
            'archivo_solicitud_empleo' => 'required|file|mimes:pdf|max:8192',
            'observaciones' => 'nullable|string|max:200',
            'plantel_id' => 'required|exists:planteles,id',
        ]);

        $data = $request->except([
            'archivo_identificacion',
            'archivo_curp',
            'archivo_acta_nacimiento',
            'archivo_comprobante_domicilio',
            'archivo_comprobante_estudios',
            'archivo_rfc',
            'archivo_constancias_cursos',
            'archivo_estado_cuenta',
            'archivo_cv',
            'archivo_solicitud_empleo',
            'idiomas',
            'habilidades',
            'cursos'
        ]);

        // Handle empty apellido_2 -> 'X'
        if (empty($data['apellido_2'])) {
            $data['apellido_2'] = 'X';
        }
        if (empty($data['apellido_1'])) {
            $data['apellido_1'] = 'X';
        }

        $data['cuenta_servicio_medico'] = $request->has('cuenta_servicio_medico');
        $data['tiene_registro_stps'] = $request->has('tiene_registro_stps');

        if ($request->hasFile('archivo_identificacion')) {
            $data['archivo_identificacion'] = $request->file('archivo_identificacion')->store('instructores/identificaciones', 'public');
        }
        if ($request->hasFile('archivo_curp')) {
            $data['archivo_curp'] = $request->file('archivo_curp')->store('instructores/curps', 'public');
        }
        if ($request->hasFile('archivo_acta_nacimiento')) {
            $data['archivo_acta_nacimiento'] = $request->file('archivo_acta_nacimiento')->store('instructores/actas', 'public');
        }
        if ($request->hasFile('archivo_comprobante_domicilio')) {
            $data['archivo_comprobante_domicilio'] = $request->file('archivo_comprobante_domicilio')->store('instructores/comprobantes', 'public');
        }
        if ($request->hasFile('archivo_comprobante_estudios')) {
            $data['archivo_comprobante_estudios'] = $request->file('archivo_comprobante_estudios')->store('instructores/estudios', 'public');
        }
        if ($request->hasFile('archivo_rfc')) {
            $data['archivo_rfc'] = $request->file('archivo_rfc')->store('instructores/rfcs', 'public');
        }

        if ($request->hasFile('archivo_constancias_cursos')) {
            $data['archivo_constancias_cursos'] = $request->file('archivo_constancias_cursos')->store('instructores/cursos_constancias', 'public');
        }

        if ($request->hasFile('archivo_estado_cuenta')) {
            $data['archivo_estado_cuenta'] = $request->file('archivo_estado_cuenta')->store('instructores/estados_cuenta', 'public');
        }

        if ($request->hasFile('archivo_cv')) {
            $data['archivo_cv'] = $request->file('archivo_cv')->store('instructores/cvs', 'public');
        }

        if ($request->hasFile('archivo_solicitud_empleo')) {
            $data['archivo_solicitud_empleo'] = $request->file('archivo_solicitud_empleo')->store('instructores/solicitudes_empleo', 'public');
        }

        $instructor = \App\Models\Instructor::create($data);

        // Process idiomas from JSON string
        if ($request->filled('idiomas')) {
            $idiomasData = json_decode($request->idiomas, true);
            if (is_array($idiomasData)) {
                foreach ($idiomasData as $idiomaData) {
                    $instructor->idiomas()->create([
                        'idioma' => $idiomaData['idioma'],
                        'estudio_extranjero' => filter_var($idiomaData['estudio_extranjero'], FILTER_VALIDATE_BOOLEAN),
                        'estado' => $idiomaData['estado'] ?? null,
                        'municipio' => $idiomaData['municipio'] ?? null,
                        'institucion' => $idiomaData['institucion'],
                        'porcentaje_conocimiento' => $idiomaData['porcentaje_conocimiento'],
                        'estatus_estudios' => $idiomaData['estatus_estudios'],
                    ]);
                }
            }
        }

        // Process habilidades from JSON string
        if ($request->filled('habilidades')) {
            $habilidadesData = json_decode($request->habilidades, true);
            if (is_array($habilidadesData)) {
                foreach ($habilidadesData as $habilidadData) {
                    $instructor->habilidades()->create([
                        'habilidad' => $habilidadData['habilidad'],
                    ]);
                }
            }
        }

        // Process cursos from JSON string
        if ($request->filled('cursos')) {
            $cursosData = json_decode($request->cursos, true);
            if (is_array($cursosData)) {
                foreach ($cursosData as $cursoData) {
                    $instructor->cursos()->create([
                        'curso' => $cursoData['curso'],
                    ]);
                }
            }
        }

        return redirect()->route('instructores.index')->with('success', 'Instructor registrado correctamente.');
    }
    public function show(\App\Models\Instructor $instructor)
    {
        return view('instructores.show', compact('instructor'));
    }

    public function download(\App\Models\Instructor $instructor, $type)
    {
        $fileFieldMap = [
            'identificacion' => 'archivo_identificacion',
            'curp' => 'archivo_curp',
            'acta_nacimiento' => 'archivo_acta_nacimiento',
            'comprobante_domicilio' => 'archivo_comprobante_domicilio',
            'comprobante_estudios' => 'archivo_comprobante_estudios',
            'rfc' => 'archivo_rfc',
            'constancias_cursos' => 'archivo_constancias_cursos',
            'estado_cuenta' => 'archivo_estado_cuenta',
            'cv' => 'archivo_cv',
            'solicitud_empleo' => 'archivo_solicitud_empleo',
        ];

        if (!array_key_exists($type, $fileFieldMap)) {
            abort(404);
        }

        $field = $fileFieldMap[$type];
        if (!$instructor->$field) {
            abort(404, 'File not found');
        }
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = \Illuminate\Support\Facades\Storage::disk('public');

        return $disk->download($instructor->$field);
    }

    public function search(Request $request)
    {
        $query = \App\Models\Instructor::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('curp')) {
            $query->where('curp', 'like', '%' . $request->curp . '%');
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('apellido_1')) {
            $query->where('apellido_1', 'like', '%' . $request->apellido_1 . '%');
        }

        if ($request->filled('apellido_2')) {
            $query->where('apellido_2', 'like', '%' . $request->apellido_2 . '%');
        }

        $instructores = $query->limit(50)->get([
            'id',
            'nombre',
            'apellido_1',
            'apellido_2',
            'curp'
        ]);

        return response()->json($instructores);
    }
}
