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

        $validated['user_id'] = auth()->id();

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
    public function show(Grupo $grupo)
    {
        $grupo->load(['creador', 'plantel.usuarioEncargado', 'calendarios', 'convenios', 'instructores', 'revisiones.user', 'plantel.user', 'curso', 'cursoIcategro', 'ofertaEducativa', 'campoFormacion', 'especialidadOcupacional']);

        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $ofertas = OfertaEducativa::all();
        $sedes = Plantel::all();
        $grupo->load(['creador', 'calendarios', 'plantel.user', 'curso', 'cursoIcategro', 'ofertaEducativa', 'campoFormacion', 'especialidadOcupacional', 'convenios', 'instructores', 'revisiones.user']);

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

        // Lógica de revisiones y estatus
        $nuevoEstatus = $request->input('nuevo_estatus');
        $observaciones = $request->input('observaciones_estatus');

        $estatusCambiado = $nuevoEstatus && $nuevoEstatus !== $grupo->estatus;

        if ($estatusCambiado || !empty($observaciones)) {
            $grupo->revisiones()->create([
                'estatus' => $nuevoEstatus ?? $grupo->estatus,
                'observaciones' => $observaciones,
                'user_id' => auth()->id()
            ]);
        }

        if ($estatusCambiado) {
            $validated['estatus'] = $nuevoEstatus;
            if ($nuevoEstatus === 'AUTORIZADO') {
                //$user = auth()->user();
                $validated['autorizado_por'] = auth()->id();
                $validated['fecha_autorizacion'] = now();
            }
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

    public function autorizar(Grupo $grupo)
    {
        $grupo->load(['calendarios', 'convenios', 'instructores', 'revisiones.user', 'plantel.user', 'curso', 'cursoIcategro', 'ofertaEducativa', 'campoFormacion', 'especialidadOcupacional']);
        return view('grupos.autorizar', compact('grupo'));
    }

    public function autorizarSubmit(Request $request, Grupo $grupo)
    {
        $request->validate([
            'estatus' => 'required|in:PENDIENTE,PROCESO,AUTORIZADO,RECHAZADO,CANCELADO,CONCLUIDO',
            'observaciones' => 'nullable|string|max:200'
        ]);

        $nuevoEstatus = $request->estatus;

        $grupo->revisiones()->create([
            'estatus' => $nuevoEstatus,
            'observaciones' => $request->observaciones,
            'user_id' => auth()->id()
        ]);

        $grupo->estatus = $nuevoEstatus;
        if ($nuevoEstatus === 'AUTORIZADO') {
            //$user = auth()->user();
            $grupo->autorizado_por = auth()->id();
            //$grupo->autorizado_por = trim($user->name . ' ' . $user->lastname . ' ' . $user->lastname2);
            $grupo->fecha_autorizacion = now();
        } else {
            $grupo->autorizado_por = null;
            $grupo->fecha_autorizacion = null;
        }

        $grupo->save();

        return redirect()->route('grupos.index')->with('success', 'El estatus del grupo ha sido actualizado exitosamente.');
    }

    public function agregarAlumnos(Grupo $grupo)
    {
        $grupo->load(['plantel.user', 'curso', 'cursoIcategro', 'ofertaEducativa', 'campoFormacion', 'especialidadOcupacional', 'listaAlumnos.student']);
        return view('grupos.agregar_alumnos', compact('grupo'));
    }

    public function storeAlumnos(Request $request, Grupo $grupo)
    {
        $request->validate([
            'alumno_id' => 'required|exists:students,id',
            'vulnerables' => 'nullable|array',
            'discapacidades' => 'nullable|array',
            'escolaridad' => 'required|string',
        ]);

        $alumno = \App\Models\Student::find($request->alumno_id);

        // Verifica que no sea instructor del grupo
        $instructoresCurps = $grupo->instructores()->pluck('curp')->toArray();
        if (in_array($alumno->curp, $instructoresCurps)) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'El instructor no puede ser ingresado como alumno en el grupo']);
            return redirect()->back()->with('error', 'El instructor no puede ser ingresado como alumno en el grupo');
        }

        // Evita duplicados
        if ($grupo->listaAlumnos()->where('student_id', $alumno->id)->exists()) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'El alumno ya está inscripto en este grupo']);
            return redirect()->back()->with('error', 'El alumno ya está inscripto en este grupo');
        }

        // Crear registro en lista_cursos_alumnos
        $registro = new \App\Models\ListaCursoAlumno();
        $registro->student_id = $alumno->id;
        $registro->group_id = $grupo->id;
        $registro->plantel = $grupo->plantel->name ?? null;

        // Nombre del curso (CAE vs Extension)
        if ($grupo->tipo_servicio === 'CAE' && $grupo->curso) {
            $registro->name = $grupo->curso->name;
        } elseif ($grupo->tipo_servicio === 'Extensión' && $grupo->cursoIcategro) {
            $registro->name = $grupo->cursoIcategro->name;
        } else {
            $registro->name = 'CURSO NO ASIGNADO';
        }

        $registro->start_date = $grupo->fecha_inicio;
        $registro->end_date = $grupo->fecha_termino;

        // Guardar arrays como JSON gracias a los Casts en el Modelo
        $registro->grupos_vulnerables = $request->vulnerables ?? [];
        $registro->discapacidades = $request->discapacidades ?? [];
        $registro->escolaridad = $request->escolaridad;

        $registro->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Alumno agregado correctamente al grupo',
                'id' => $registro->id
            ]);
        }

        return redirect()->route('grupos.alumnos.create', $grupo->id)->with('success', 'Alumno agregado correctamente');
    }

    public function searchAlumnos(Request $request)
    {
        $query = \App\Models\Student::query();

        if ($request->filled('id_alumno')) {
            $query->where('id', $request->input('id_alumno'));
        }
        if ($request->filled('curp')) {
            $query->where('curp', 'like', '%' . $request->input('curp') . '%');
        }
        if ($request->filled('nombre')) {
            $query->where('name', 'like', '%' . $request->input('nombre') . '%');
        }
        if ($request->filled('apellido_1')) {
            $query->where('lastname1', 'like', '%' . $request->input('apellido_1') . '%');
        }
        if ($request->filled('apellido_2')) {
            $query->where('lastname2', 'like', '%' . $request->input('apellido_2') . '%');
        }

        // Si no se envió ningún parámetro, podríamos retornar vacío
        if (!$request->filled('id_alumno') && !$request->filled('curp') && !$request->filled('nombre') && !$request->filled('apellido_1') && !$request->filled('apellido_2')) {
            return response()->json([]);
        }

        $alumnos = $query->limit(20)->get();

        return response()->json($alumnos);
    }

    public function validarSeleccionAlumno(Request $request, Grupo $grupo)
    {
        $request->validate([
            'alumno_id' => 'required|exists:students,id'
        ]);

        $alumno = \App\Models\Student::find($request->alumno_id);

        // Validar que el alumno no sea instructor de este grupo
        // Asumiendo que el instructor tiene CURP
        $instructoresCurps = $grupo->instructores()->pluck('curp')->toArray();

        if (in_array($alumno->curp, $instructoresCurps)) {
            return response()->json(['valid' => false, 'message' => 'No se puede registrar el instructor como alumno en el grupo']);
        }

        return response()->json(['valid' => true, 'student' => $alumno]);
    }

    public function completarAlumno(Grupo $grupo, \App\Models\Student $alumno)
    {
        return view('grupos.completar_alumno', compact('grupo', 'alumno'));
    }

    public function calificarAlumnos(Grupo $grupo)
    {
        $grupo->load(['plantel.user', 'curso', 'cursoIcategro', 'ofertaEducativa', 'campoFormacion', 'especialidadOcupacional', 'listaAlumnos.student']);
        return view('grupos.calificar_alumnos', compact('grupo'));
    }

    public function storeCalificaciones(Request $request, Grupo $grupo)
    {
        $request->validate([
            'alumnos' => 'required|array',
            'alumnos.*.student_id' => 'required|exists:lista_cursos_alumnos,student_id',
            'alumnos.*.estatus' => 'required|in:APROBADO,NO APROBADO,BAJA,DESERCION',
            'alumnos.*.calificacion' => 'required|numeric|min:5|max:10'
        ]);

        foreach ($request->alumnos as $alumnoData) {
            $estatus = $alumnoData['estatus'];
            $calificacion = (int) $alumnoData['calificacion'];

            if ($estatus === 'APROBADO' && $calificacion < 6) {
                return response()->json(['success' => false, 'message' => "Un alumno tiene estatus APROBADO pero calificación reprobatoria ($calificacion)"]);
            }
            if ($estatus !== 'APROBADO' && $calificacion >= 6) {
                return response()->json(['success' => false, 'message' => "Un alumno tiene estatus reprobatorio/baja ($estatus) pero calificación aprobatoria. Debe ser 5."]);
            }
        }

        // Validar que se reciba calificación de todos
        $totalAlumnos = $grupo->listaAlumnos()->count();
        if (count($request->alumnos) !== $totalAlumnos) {
            return response()->json(['success' => false, 'message' => "Se deben calificar a todos los alumnos inscritos para poder guardar."]);
        }

        foreach ($request->alumnos as $alumnoData) {
            $grupo->listaAlumnos()->where('student_id', $alumnoData['student_id'])->update([
                'student_status' => $alumnoData['estatus'],
                'calificacion' => $alumnoData['calificacion']
            ]);
        }

        $grupo->update(['estatus' => 'CALIFICADO']);

        return response()->json([
            'success' => true,
            'message' => 'Todas las calificaciones han sido guardadas. Grupo CALIFICADO.'
        ]);
    }

    public function asignarFolios(Grupo $grupo)
    {
        $grupo->load(['plantel.user', 'curso', 'cursoIcategro', 'ofertaEducativa', 'campoFormacion', 'especialidadOcupacional', 'listaAlumnos.student']);
        return view('grupos.asignar_folios', compact('grupo'));
    }

    public function storeFolios(Request $request, Grupo $grupo)
    {
        $request->validate([
            'doc_type' => 'required|in:CONSTANCIA,DIPLOMA,RECONOCIMIENTO',
            'folio_inicial' => 'required',
            'folio_final' => 'required'
        ]);

        $alumnosAprobados = $grupo->listaAlumnos()->where('student_status', 'APROBADO')->get();
        $totalNecesarios = $alumnosAprobados->count();

        if ($totalNecesarios === 0) {
            return response()->json(['success' => false, 'message' => 'Debe haber al menos un alumno APROBADO para asignar folios.']);
        }

        if (!preg_match('/^(.*?)(\d+)$/', $request->folio_inicial, $mInit)) {
            return response()->json(['success' => false, 'message' => 'Folio inicial inválido. Debe terminar con un número (Ej. GR-001).']);
        }
        if (!preg_match('/^(.*?)(\d+)$/', $request->folio_final, $mFin)) {
            return response()->json(['success' => false, 'message' => 'Folio final inválido. Debe terminar con un número.']);
        }

        $prefijo = $mInit[1];
        $numInicial = (int) $mInit[2];
        $padLength = strlen($mInit[2]);

        if ($prefijo !== $mFin[1]) {
            return response()->json(['success' => false, 'message' => 'El prefijo del folio inicial y final no coincide.']);
        }

        $numFinal = (int) $mFin[2];
        $rangoDisponible = $numFinal - $numInicial + 1;

        if ($numInicial > $numFinal) {
            return response()->json(['success' => false, 'message' => 'El folio inicial no puede ser mayor al final.']);
        }

        if ($rangoDisponible < $totalNecesarios) {
            return response()->json(['success' => false, 'message' => "El rango proporciona $rangoDisponible folios, pero se necesitan $totalNecesarios para los aprobados."]);
        }

        $foliosRequeridos = [];
        for ($i = 0; $i < $totalNecesarios; $i++) {
            $num = $numInicial + $i;
            $foliosRequeridos[] = $prefijo . str_pad($num, $padLength, '0', STR_PAD_LEFT);
        }

        $ocupados = \App\Models\ListaCursoAlumno::with('student')
            ->whereIn('folio', $foliosRequeridos)
            ->get();

        if ($ocupados->count() > 0) {
            $errores = [];
            foreach ($ocupados as $occ) {
                $nombreCompleto = trim(($occ->student->name ?? 'Usuario') . ' ' . ($occ->student->lastname1 ?? '') . ' ' . ($occ->student->lastname2 ?? ''));
                $errores[] = "EI FOLIO <b>{$occ->folio}</b> ya se encuentra ocupado por <b class='uppercase'>{$nombreCompleto}</b> en el grupo con ID <b>{$occ->group_id}</b>";
            }
            return response()->json([
                'success' => false,
                'errors_list' => $errores
            ], 422);
        }

        // Asignación Aprobados
        $idx = 0;
        foreach ($alumnosAprobados as $aprobado) {
            $aprobado->update([
                'doc_type' => $request->doc_type,
                'folio' => $foliosRequeridos[$idx]
            ]);
            $idx++;
        }

        // Asignación No Aprobados (Bajas, etc)
        $grupo->listaAlumnos()->where('student_status', '!=', 'APROBADO')->update([
            'doc_type' => 'NO APLICA',
            'folio' => null
        ]);

        return response()->json(['success' => true, 'message' => 'Se han asignado los folios correctamente a los alumnos aprobados.']);
    }

    public function cambiarFolio(Request $request, Grupo $grupo)
    {
        $request->validate([
            'id_lista' => 'required|exists:lista_cursos_alumnos,id',
            'folio_nuevo' => 'required|string',
            'motivo_cambio' => 'required|string|max:500'
        ]);

        // Asegurarnos que el nuevo folio tenga la parte alfanumérica y numérica correcta.
        // Aunque la vista mande los dos campos separados, es más seguro que lo manden interpolado y aquí validemos que sea distinto.
        $nuevoFolio = $request->folio_nuevo;

        $item = \App\Models\ListaCursoAlumno::with('student')->findOrFail($request->id_lista);

        // Validar que el folio pertenezca al grupo que estamos procesando
        if ($item->group_id != $grupo->id) {
            return response()->json(['success' => false, 'message' => 'El registro no pertenece a este grupo.'], 403);
        }

        if ($item->folio === $nuevoFolio) {
            return response()->json(['success' => false, 'message' => 'El nuevo folio no puede ser idéntico al folio actual.']);
        }

        // Buscar duplicados globales
        $ocupado = \App\Models\ListaCursoAlumno::with('student')
            ->where('folio', $nuevoFolio)
            ->first();

        if ($ocupado) {
            $nombre = trim(($ocupado->student->name ?? 'Usuario') . ' ' . ($ocupado->student->lastname1 ?? '') . ' ' . ($ocupado->student->lastname2 ?? ''));
            return response()->json([
                'success' => false,
                'message' => "El FOLIO <b>$nuevoFolio</b> ya se encuentra ocupado por <strong class='uppercase'>$nombre</strong> en el grupo con ID <b>$ocupado->group_id</b>."
            ], 422); // Note this uses "message" not "errors_list" so we must handle it in the JS sweetalert
        }

        // Save
        $item->update([
            'folio' => $nuevoFolio,
            'folio_motivo_cambio' => $request->motivo_cambio
        ]);

        return response()->json(['success' => true, 'message' => 'El folio ha sido actualizado correctamente.']);
    }

    public function cancelarFolio(Request $request, Grupo $grupo)
    {
        $request->validate([
            'id_lista' => 'required|exists:lista_cursos_alumnos,id',
            'estatus_nuevo' => 'required|string|in:NO APROBADO,BAJA,DESERCION',
            'motivo_cancelacion' => 'required|string|max:200'
        ]);

        $item = \App\Models\ListaCursoAlumno::with('student')->findOrFail($request->id_lista);

        if ($item->group_id != $grupo->id) {
            return response()->json(['success' => false, 'message' => 'El registro no pertenece a este grupo.'], 403);
        }

        $item->update([
            'student_status' => $request->estatus_nuevo,
            'folio' => null,
            'doc_type' => 'NO APLICA',
            'calificacion' => 5,
            'folio_motivo_cambio' => 'CANCELACIÓN: ' . $request->motivo_cancelacion
        ]);

        return response()->json(['success' => true, 'message' => 'El folio del alumno ha sido cancelado con éxito.']);
    }
}
