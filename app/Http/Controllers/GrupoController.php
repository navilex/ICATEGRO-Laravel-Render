<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\OfertaEducativa;
use App\Models\CampoFormacion;
use App\Models\EspecialidadOcupacional;
use App\Models\Curso;
use App\Models\CursoIcategro;
use App\Models\Plantel;

class GrupoController extends Controller
{
    public function index()
    {
        $query = Grupo::with(['plantel', 'curso', 'cursoIcategro', 'instructores']);

        if (auth()->user()->role !== 'ADMINISTRADOR') {
            $query->whereHas('plantel', function ($q) {
                $q->where('name', auth()->user()->adscription);
            });
        }

        $grupos = $query->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $ofertas = OfertaEducativa::all();
        $sedes = Plantel::all();
        return view('grupos.create', compact('ofertas', 'sedes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_servicio' => 'required|string',
            'modalidad_ce' => 'nullable|string',
            'modalidad' => 'required|string',
            'oferta_educativa_id' => 'required|exists:oferta_educativas,id',
            'campo_formacion_id' => 'required|exists:campo_formacions,id',
            'especialidad_ocupacional_id' => 'required|exists:especialidad_ocupacionals,id',
            'curso_id' => 'nullable|exists:cursos,id',
            'curso_icategro_id' => 'nullable|exists:curso_icategros,id',
            'alumnos_inician' => 'required|integer|min:0',
            'capacidad_maxima' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after_or_equal:fecha_inicio',
            'duracion_dias' => 'required|integer|min:1',
            'duracion_horas' => 'required|integer|min:1',
            'numero_semanas' => 'required|integer|min:1',
            'numero_horas_semana' => 'required|integer|min:1',
            'horario' => 'required|string',
            'plantel_id' => 'required|exists:planteles,id',
            'estado' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'nombre_espacio' => 'required|string|max:255',
            'calendario_data' => 'required|string',
            'convenios_data' => 'nullable|string',
            'instructores_data' => 'nullable|string',
            'tipo_pago_grupo' => 'required|string',
            'costo_por_persona' => 'nullable|numeric|min:0',
            'costo_por_grupo' => 'nullable|numeric|min:0',
            'costo_coffee_break' => 'nullable|numeric|min:0',
            'ingreso_total' => 'nullable|numeric',
            'utilidad_grupo' => 'nullable|numeric',
            'archivo_plan_estudios' => 'required|file|mimes:xls,xlsx|max:8192',
            'archivo_becas' => 'required_if:tipo_pago_grupo,BECA GRUPAL|file|mimes:pdf|max:8192',
            'comentarios' => 'nullable|string|max:200'
        ]);

        $calendarios = json_decode($request->calendario_data, true);
        if (!$calendarios || count($calendarios) === 0) {
            return back()->withInput()->withErrors(['calendario_data' => 'El grupo no puede guardarse sin fechas del calendario.']);
        }

        if ($request->hasFile('archivo_plan_estudios')) {
            $validated['archivo_plan_estudios'] = $request->file('archivo_plan_estudios')->store('grupos/archivos', 'public');
        }

        if ($request->hasFile('archivo_becas')) {
            $validated['archivo_becas'] = $request->file('archivo_becas')->store('grupos/archivos', 'public');
        }

        $grupo = Grupo::create($validated);

        foreach ($calendarios as $cal) {
            $grupo->calendarios()->create([
                'tipo_fecha' => $cal['tipo_fecha'],
                'fecha_inicial' => $cal['fecha_inicial'],
                'fecha_final' => !empty($cal['fecha_final']) ? $cal['fecha_final'] : null,
                'hora_inicial' => $cal['hora_inicial'],
                'hora_final' => $cal['hora_final'],
                'total_dias' => $cal['total_dias'],
                'total_horas' => $cal['total_horas'],
            ]);
        }

        if ($request->filled('convenios_data')) {
            $convenios = json_decode($request->convenios_data, true);
            if (is_array($convenios) && count($convenios) > 0) {
                $grupo->convenios()->sync($convenios);
            }
        }

        if ($request->filled('instructores_data')) {
            $instructores = json_decode($request->instructores_data, true);
            if (is_array($instructores) && count($instructores) > 0) {
                $syncData = [];
                foreach ($instructores as $inst) {
                    $syncData[$inst['instructor_id']] = [
                        'tipo' => $inst['tipo'],
                        'fecha_inicio' => $inst['fecha_inicio'],
                        'fecha_termino' => $inst['fecha_termino'],
                        'duracion_dias' => $inst['duracion_dias'],
                        'duracion_horas' => $inst['duracion_horas'],
                        'horario' => $inst['horario'],
                        'pago_instructor' => !empty($inst['pago_instructor']) ? $inst['pago_instructor'] : null,
                        'fecha_pago' => !empty($inst['fecha_pago']) ? $inst['fecha_pago'] : null,
                        'tipo_pago' => !empty($inst['tipo_pago']) ? $inst['tipo_pago'] : null,
                    ];
                }
                $grupo->instructores()->sync($syncData);
            }
        }

        return redirect()->route('grupos.create')->with('success', 'Grupo registrado exitosamente.');
    }

    public function getCamposFormacion($ofertaId)
    {
        $campos = CampoFormacion::where('oferta_educativa_id', $ofertaId)
            ->where('status', true)
            ->get();
        return response()->json($campos);
    }

    public function getEspecialidades($campoId)
    {
        $especialidades = EspecialidadOcupacional::where('campo_formacion_id', $campoId)
            ->where('status', true)
            ->get();
        return response()->json($especialidades);
    }

    public function getCursos($especialidadId, $tipo)
    {
        if ($tipo === 'cae') {
            $cursos = Curso::where('especialidad_ocupacional_id', $especialidadId)
                ->where('status', true)
                ->get();
        } else {
            $cursos = CursoIcategro::where('especialidad_ocupacional_id', $especialidadId)
                ->where('status', true)
                ->get();
        }
        return response()->json($cursos);
    }
    public function edit(Grupo $grupo)
    {
        $ofertas = OfertaEducativa::all();
        $sedes = Plantel::all();
        $grupo->load(['calendarios', 'plantel.user', 'curso', 'cursoIcategro', 'ofertaEducativa', 'campoFormacion', 'especialidadOcupacional', 'convenios', 'instructores']);

        return view('grupos.edit', compact('grupo', 'ofertas', 'sedes'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $validated = $request->validate([
            'tipo_servicio' => 'required|string',
            'modalidad_ce' => 'nullable|string',
            'modalidad' => 'required|string',
            'oferta_educativa_id' => 'required|exists:oferta_educativas,id',
            'campo_formacion_id' => 'required|exists:campo_formacions,id',
            'especialidad_ocupacional_id' => 'required|exists:especialidad_ocupacionals,id',
            'curso_id' => 'nullable|exists:cursos,id',
            'curso_icategro_id' => 'nullable|exists:curso_icategros,id',
            'alumnos_inician' => 'required|integer|min:0',
            'capacidad_maxima' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after_or_equal:fecha_inicio',
            'duracion_dias' => 'required|integer|min:1',
            'duracion_horas' => 'required|integer|min:1',
            'numero_semanas' => 'required|integer|min:1',
            'numero_horas_semana' => 'required|numeric|min:0',
            'horario' => 'required|string',
            'plantel_id' => 'required|exists:planteles,id',
            'estado' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'nombre_espacio' => 'required|string|max:255',
            'calendario_data' => 'required|string',
            'convenios_data' => 'nullable|string',
            'instructores_data' => 'nullable|string',
            'tipo_pago_grupo' => 'required|string',
            'costo_por_persona' => 'nullable|numeric|min:0',
            'costo_por_grupo' => 'nullable|numeric|min:0',
            'costo_coffee_break' => 'nullable|numeric|min:0',
            'ingreso_total' => 'nullable|numeric',
            'utilidad_grupo' => 'nullable|numeric',
            'archivo_plan_estudios' => 'nullable|file|mimes:xls,xlsx|max:8192',
            'archivo_becas' => 'nullable|file|mimes:pdf|max:8192',
            'comentarios' => 'nullable|string|max:200'
        ]);

        if ($request->hasFile('archivo_plan_estudios')) {
            if ($grupo->archivo_plan_estudios) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($grupo->archivo_plan_estudios);
            }
            $validated['archivo_plan_estudios'] = $request->file('archivo_plan_estudios')->store('grupos/archivos', 'public');
        }

        if ($request->hasFile('archivo_becas')) {
            if ($grupo->archivo_becas) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($grupo->archivo_becas);
            }
            $validated['archivo_becas'] = $request->file('archivo_becas')->store('grupos/archivos', 'public');
        }

        $calendarios = json_decode($request->calendario_data, true);
        if (!$calendarios || count($calendarios) === 0) {
            return back()->withInput()->withErrors(['calendario_data' => 'El grupo no puede guardarse sin fechas del calendario.']);
        }

        $grupo->update($validated);

        // Reconstruir calendarios
        $grupo->calendarios()->delete();
        foreach ($calendarios as $cal) {
            $grupo->calendarios()->create([
                'tipo_fecha' => $cal['tipo_fecha'],
                'fecha_inicial' => $cal['fecha_inicial'],
                'fecha_final' => !empty($cal['fecha_final']) ? $cal['fecha_final'] : null,
                'hora_inicial' => $cal['hora_inicial'],
                'hora_final' => $cal['hora_final'],
                'total_dias' => $cal['total_dias'],
                'total_horas' => $cal['total_horas'],
            ]);
        }

        if ($request->filled('convenios_data')) {
            $convenios = json_decode($request->convenios_data, true);
            if (is_array($convenios)) {
                $grupo->convenios()->sync($convenios);
            }
        } else {
            $grupo->convenios()->sync([]);
        }

        if ($request->filled('instructores_data')) {
            $instructores = json_decode($request->instructores_data, true);
            if (is_array($instructores)) {
                $syncData = [];
                foreach ($instructores as $inst) {
                    $id = $inst['instructor_id'] ?? $inst['id'];
                    $syncData[$id] = [
                        'tipo' => $inst['tipo'],
                        'fecha_inicio' => $inst['fecha_inicio'],
                        'fecha_termino' => $inst['fecha_termino'],
                        'duracion_dias' => $inst['duracion_dias'],
                        'duracion_horas' => $inst['duracion_horas'],
                        'horario' => $inst['horario'],
                        'pago_instructor' => !empty($inst['pago_instructor']) ? $inst['pago_instructor'] : null,
                        'fecha_pago' => !empty($inst['fecha_pago']) ? $inst['fecha_pago'] : null,
                        'tipo_pago' => !empty($inst['tipo_pago']) ? $inst['tipo_pago'] : null,
                    ];
                }
                $grupo->instructores()->sync($syncData);
            }
        } else {
            $grupo->instructores()->sync([]);
        }

        return redirect()->route('grupos.index')->with('success', 'Grupo modificado exitosamente.');
    }
}
