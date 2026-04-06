@extends('layouts.app')

@section('title', 'Edición de Grupo - ICATEGRO')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            padding: 0.25rem 2rem 0.25rem 0.5rem;
            background-color: white;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
            margin-left: 0.5rem;
            background-color: white;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #e5e7eb !important;
            padding: 10px 18px;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid #e5e7eb !important;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden min-h-[500px] max-w-5xl mx-auto mt-8 relative">
        <!-- Header -->
        <div class="bg-[#d4b996] p-4 text-center">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <i class="fas fa-edit mr-3 text-gray-800"></i>
                EDICIÓN DE GRUPO
            </h1>
        </div>

        <div class="p-8">
            <!-- Section 1: Registro -->
            <div class="relative mb-8 text-center mt-2">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span
                        class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Registro</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-end">
                <div class="col-span-1 border-b border-gray-300 pb-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Registrado por</div>
                    <div
                        class="bg-white border-2 border-gray-400 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
                        @if($grupo->creador)
                            {{ $grupo->creador->name }} {{ $grupo->creador->lastname }} {{ $grupo->creador->lastname2 }}
                        @else
                            ADMINISTRADOR / SISTEMA
                        @endif
                    </div>
                </div>
                <div class="col-span-1 border-b border-gray-300 pb-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Fecha captura</div>
                    <div class="bg-white border-2 border-gray-400 rounded-full px-4 py-2 text-sm font-bold text-gray-800">
                        {{ $grupo->created_at->format('d/m/Y \a \l\a\s H:i:s') }}
                    </div>
                </div>
                <div class="col-span-1 border-b border-gray-300 pb-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Estatus</div>
                    <div
                        class="bg-gray-50 border-2 border-gray-300 rounded-full px-4 py-2 text-sm font-bold text-gray-800 flex items-center shadow-inner">
                        <span
                            class="w-4 h-4 rounded-full mr-3 shadow-sm 
                                                                                                                                                                        @if($grupo->estatus == 'PENDIENTE') bg-yellow-500 
                                                                                                                                                                        @elseif($grupo->estatus == 'AUTORIZADO') bg-green-600 
                                                                                                                                                                        @elseif($grupo->estatus == 'PROCESO') bg-blue-500 
                                                                                                                                                                        @elseif($grupo->estatus == 'CONCLUIDO') bg-purple-700 
                                                                                                                                                                        @elseif($grupo->estatus == 'RECHAZADO') bg-red-600 
                                                                                                                                                                        @elseif($grupo->estatus == 'CALIFICADO') bg-pink-500
                                                                                                                                                                        @else bg-gray-500 @endif
                                                                                                                                                                    "></span>
                        {{ strtoupper($grupo->estatus) }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="col-span-3 border-b border-gray-300 pb-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Plantel</div>
                    <div
                        class="bg-white border-2 border-gray-400 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
                        {{ $grupo->plantel->name ?? 'NO ASIGNADO' }}
                    </div>
                </div>
                <div class="col-span-1 border-b border-gray-300 pb-2 mt-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Estatus Director/encargado</div>
                    <div
                        class="bg-white border-2 border-gray-400 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
                        @if($grupo->plantel && $grupo->plantel->tipo_asignacion)
                            {{ $grupo->plantel->tipo_asignacion }}
                        @else
                            TIPO NO DEFINIDO
                        @endif
                    </div>
                </div>
                <div class="col-span-2 border-b border-gray-300 pb-2 mt-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Director/encargado</div>
                    <div
                        class="bg-white border-2 border-gray-400 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
                        @if($grupo->plantel && $grupo->plantel->usuarioEncargado)
                            {{ $grupo->plantel->usuarioEncargado->name }}
                            {{ $grupo->plantel->usuarioEncargado->lastname }}
                            {{ $grupo->plantel->usuarioEncargado->lastname2 }}
                        @else
                            DIRECTOR NO ASIGNADO
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form starts -->
            <form method="POST" action="{{ route('grupos.update', $grupo->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Section 2: Datos generales -->
                <div class="relative mb-8 text-center mt-12">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Datos
                            generales</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1">ID del grupo</label>
                        <input type="text"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-gray-100 font-bold text-gray-700 cursor-not-allowed"
                            value="{{ $grupo->id }}" disabled>
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1">Número de grupo</label>
                        <input type="text"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-gray-100 font-bold text-gray-700 cursor-not-allowed"
                            value="NO ASIGNADO" disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="tipo_servicio" class="block text-[#a02142] font-bold mb-1">* Tipo de servicio</label>
                        <select name="tipo_servicio" id="tipo_servicio"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="">» SELECCIONE</option>
                            <option value="Extensión" {{ old('tipo_servicio', $grupo->tipo_servicio) == 'Extensión' ? 'selected' : '' }}>Extensión</option>
                            <option value="CAE" {{ old('tipo_servicio', $grupo->tipo_servicio) == 'CAE' ? 'selected' : '' }}>
                                CAE</option>
                        </select>
                    </div>

                    <div>
                        <label for="modalidad_ce" class="block text-[#a02142] font-bold mb-1">* Modalidad C.E.</label>
                        <select name="modalidad_ce" id="modalidad_ce"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white disabled:bg-gray-200"
                            {{ old('tipo_servicio', $grupo->tipo_servicio) == 'CAE' ? '' : 'disabled' }}>
                            <option value="">» SELECCIONE</option>
                            <option value="Regular" {{ old('modalidad_ce', $grupo->modalidad_ce) == 'Regular' ? 'selected' : '' }}>Regular</option>
                            <option value="Asesoría" {{ old('modalidad_ce', $grupo->modalidad_ce) == 'Asesoría' ? 'selected' : '' }}>Asesoría</option>
                        </select>
                    </div>

                    <div>
                        <label for="modalidad" class="block text-[#a02142] font-bold mb-1">* Modalidad</label>
                        <select name="modalidad" id="modalidad"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="">» SELECCIONE</option>
                            <option value="Curso" {{ old('modalidad', $grupo->modalidad) == 'Curso' ? 'selected' : '' }}>Curso
                            </option>
                            <option value="Curso en línea" {{ old('modalidad', $grupo->modalidad) == 'Curso en línea' ? 'selected' : '' }}>Curso en línea</option>
                            <option value="Taller" {{ old('modalidad', $grupo->modalidad) == 'Taller' ? 'selected' : '' }}>
                                Taller</option>
                            <option value="Seminario" {{ old('modalidad', $grupo->modalidad) == 'Seminario' ? 'selected' : '' }}>Seminario</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="oferta_educativa_id" class="block text-[#a02142] font-bold mb-1">* Oferta Educativa</label>
                    <select name="oferta_educativa_id" id="oferta_educativa_id"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="">» SELECCIONA LA OFERTA EDUCATIVA</option>
                        @foreach($ofertas as $oferta)
                            <option value="{{ $oferta->id }}" {{ old('oferta_educativa_id', $grupo->oferta_educativa_id) == $oferta->id ? 'selected' : '' }}>
                                {{ $oferta->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="campo_formacion_id" class="block text-[#a02142] font-bold mb-1">* Campo de Formación
                        Profesional</label>
                    <select name="campo_formacion_id" id="campo_formacion_id"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        @if($grupo->campoFormacion)
                            <option value="{{ $grupo->campoFormacion->id }}" selected>{{ $grupo->campoFormacion->name }}
                            </option>
                        @else
                            <option value="">» SELECCIONA EL CAMPO DE FORMACION PROFESIONAL</option>
                        @endif
                    </select>
                    <p id="campo-loading" class="text-xs text-gray-500 mt-1 hidden">Cargando campos...</p>
                </div>

                <div class="mb-6">
                    <label for="especialidad_ocupacional_id" class="block text-[#a02142] font-bold mb-1">* Especialidad
                        Ocupacional</label>
                    <select name="especialidad_ocupacional_id" id="especialidad_ocupacional_id"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        @if($grupo->especialidadOcupacional)
                            <option value="{{ $grupo->especialidadOcupacional->id }}" selected>
                                {{ $grupo->especialidadOcupacional->name }}
                            </option>
                        @else
                            <option value="">» SELECCIONA LA ESPECIALIDAD OCUPACIONAL</option>
                        @endif
                    </select>
                    <p id="especialidad-loading" class="text-xs text-gray-500 mt-1 hidden">Cargando especialidades...</p>
                </div>

                <div class="mb-6">
                    <label for="curso_select" class="block text-[#a02142] font-bold mb-1">* Curso</label>
                    <select id="curso_select"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        @if($grupo->curso)
                            <option value="{{ $grupo->curso->id }}" selected>{{ $grupo->curso->name }}</option>
                        @elseif($grupo->cursoIcategro)
                            <option value="{{ $grupo->cursoIcategro->id }}" selected>{{ $grupo->cursoIcategro->name }}</option>
                        @else
                            <option value="">» SELECCIONA EL CURSO</option>
                        @endif
                    </select>
                    <p id="curso-loading" class="text-xs text-gray-500 mt-1 hidden">Cargando cursos...</p>
                    <input type="hidden" name="curso_id" id="curso_id" value="{{ $grupo->curso_id }}">
                    <input type="hidden" name="curso_icategro_id" id="curso_icategro_id"
                        value="{{ $grupo->curso_icategro_id }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="alumnos_inician" class="block text-[#a02142] font-bold mb-1">* Alumnos inician</label>
                        <input type="number" name="alumnos_inician" id="alumnos_inician" min="0"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('alumnos_inician', $grupo->alumnos_inician) }}">
                    </div>
                    <div>
                        <label for="capacidad_maxima" class="block text-[#a02142] font-bold mb-1">* Capacidad máxima</label>
                        <input type="number" name="capacidad_maxima" id="capacidad_maxima" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('capacidad_maxima', $grupo->capacidad_maxima) }}">
                    </div>
                </div>

                <!-- Section 3: Fechas, horario y duración del grupo -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Fechas,
                            horario y duración del grupo</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div>
                        <label for="fecha_inicio" class="block text-[#a02142] font-bold mb-1">* Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required value="{{ old('fecha_inicio', $grupo->fecha_inicio) }}">
                    </div>
                    <div>
                        <label for="fecha_termino" class="block text-[#a02142] font-bold mb-1">* Fecha de término</label>
                        <input type="date" name="fecha_termino" id="fecha_termino"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required value="{{ old('fecha_termino', $grupo->fecha_termino) }}">
                    </div>
                    <div>
                        <label for="duracion_dias" class="block text-[#a02142] font-bold mb-1">* Duración días</label>
                        <input type="number" name="duracion_dias" id="duracion_dias" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('duracion_dias', $grupo->duracion_dias) }}">
                    </div>
                    <div>
                        <label for="duracion_horas" class="block text-[#a02142] font-bold mb-1">* Duración horas</label>
                        <input type="number" name="duracion_horas" id="duracion_horas" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('duracion_horas', $grupo->duracion_horas) }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="flex flex-col gap-6">
                        <div>
                            <label for="numero_semanas" class="block text-[#a02142] font-bold mb-1">* Número de semanas del
                                curso</label>
                            <input type="number" name="numero_semanas" id="numero_semanas" min="1"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="0" required value="{{ old('numero_semanas', $grupo->numero_semanas) }}">
                        </div>
                        <div>
                            <label for="numero_horas_semana" class="block text-[#a02142] font-bold mb-1">* Número de horas
                                por semana</label>
                            <input type="number" name="numero_horas_semana" id="numero_horas_semana" min="0" step="0.1"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="0" required
                                value="{{ old('numero_horas_semana', $grupo->numero_horas_semana) }}">
                        </div>
                    </div>
                    <div>
                        <label for="horario" class="block text-[#a02142] font-bold mb-1">* Horario</label>
                        <textarea name="horario" id="horario" rows="4"
                            class="w-full border-2 border-gray-400 rounded-lg p-2 px-4 focus:outline-none focus:border-red-500 bg-white resize-none"
                            required>{{ old('horario', $grupo->horario) }}</textarea>
                    </div>
                </div>

                <!-- Section 4: Calendario -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Calendario</span>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-[#a02142] font-bold mb-4">* La información se deberá especificar por semana.</p>
                    <button type="button" id="btn_abrir_modal"
                        class="bg-[#1b6b47] hover:bg-[#155a3a] text-white font-bold py-2 px-6 rounded shadow transition flex items-center">
                        <i class="fas fa-plus mr-2 text-sm"></i> Agregar
                    </button>
                </div>

                <input type="hidden" name="calendario_data" id="calendario_data" value="[]">

                <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                    <table class="w-full text-sm text-center">
                        <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                            <tr>
                                <th class="py-2 px-2">Tipo</th>
                                <th class="py-2 px-2">Fecha inicial</th>
                                <th class="py-2 px-2">Fecha final</th>
                                <th class="py-2 px-2">Hora inicial</th>
                                <th class="py-2 px-2">Hora final</th>
                                <th class="py-2 px-2">Total días</th>
                                <th class="py-2 px-2">Total horas</th>
                                <th class="py-2 px-2 text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="calendario_tbody">
                            <tr id="empty_row">
                                <td colspan="8" class="py-4 text-gray-500 bg-gray-50 border-b">No hay datos disponibles en
                                    la tabla</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Section 5: Ubicacion del grupo -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Ubicación
                            del grupo</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="plantel_id" class="block text-[#a02142] font-bold mb-1">* Sede del grupo</label>
                        <select name="plantel_id" id="plantel_id"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="">» SELECCIONE LA SEDE</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}" {{ old('plantel_id', $grupo->plantel_id) == $sede->id ? 'selected' : '' }}>
                                    {{ $sede->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="estado" class="block text-[#a02142] font-bold mb-1">* Estado</label>
                        <select name="estado" id="estado"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="{{ $grupo->estado }}" selected>{{ $grupo->estado }}</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="municipio" class="block text-[#a02142] font-bold mb-1">* Municipio</label>
                    <select name="municipio" id="municipio"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="{{ $grupo->municipio }}" selected>{{ $grupo->municipio }}</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="localidad" class="block text-[#a02142] font-bold mb-1">* Localidad</label>
                    <select name="localidad" id="localidad"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="">» SELECCIONA LA LOCALIDAD</option>
                        <option value="CHILPANCINGO" {{ old('localidad', $grupo->localidad) == 'CHILPANCINGO' ? 'selected' : '' }}>CHILPANCINGO</option>
                        <option value="PETAQUILLAS" {{ old('localidad', $grupo->localidad) == 'PETAQUILLAS' ? 'selected' : '' }}>PETAQUILLAS</option>
                        <option value="MAZATLAN" {{ old('localidad', $grupo->localidad) == 'MAZATLAN' ? 'selected' : '' }}>
                            MAZATLAN</option>
                        <option value="AMOJILECA" {{ old('localidad', $grupo->localidad) == 'AMOJILECA' ? 'selected' : '' }}>
                            AMOJILECA</option>
                    </select>
                </div>

                <div class="mb-10">
                    <label for="nombre_espacio" class="block text-[#a02142] font-bold mb-1">* Nombre del espacio</label>
                    <input type="text" name="nombre_espacio" id="nombre_espacio"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white uppercase"
                        placeholder="Nombre del espacio" required
                        value="{{ old('nombre_espacio', $grupo->nombre_espacio) }}">
                </div>


                <!-- Section 6: Convenio -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Convenio</span>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="button" id="btn_abrir_modal_convenio"
                        class="bg-[#1b6b47] hover:bg-[#155a3a] text-white font-bold py-2 px-6 rounded shadow border-b-4 border-green-900 flex items-center">
                        <i class="fas fa-plus mr-2"></i> Agregar
                    </button>
                </div>

                <input type="hidden" name="convenios_data" id="convenios_data" value="[]">

                <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                    <table class="w-full text-sm text-center">
                        <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                            <tr>
                                <th class="py-2 px-2">Opción</th>
                                <th class="py-2 px-2">Tipo</th>
                                <th class="py-2 px-2">Número</th>
                                <th class="py-2 px-2 text-left">Nombre</th>
                                <th class="py-2 px-2 text-left">Objeto</th>
                            </tr>
                        </thead>
                        <tbody id="convenios_tbody">
                            <tr id="empty_row_convenios">
                                <td colspan="5" class="py-4 text-gray-500 bg-gray-50 border-b">No hay datos disponibles en
                                    la tabla</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Section 7: Instructores -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Instructor(es)</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mb-4">
                    <div>
                        <button type="button" id="btn_abrir_modal_instructor1"
                            class="bg-[#1b6b47] hover:bg-[#155a3a] text-white font-bold py-2 px-6 rounded shadow border-b-4 border-green-900 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Agregar
                        </button>
                    </div>
                    <div class="flex space-x-8 text-sm font-bold text-gray-700">
                        <div>
                            <p class="mb-1 text-black">Tipo de instructor</p>
                            <p class="text-green-800"><i class="fas fa-file-invoice-dollar mr-1"></i> HONORARIOS</p>
                            <p class="text-red-800"><i class="fas fa-handshake mr-1"></i> SIN PAGO AL INSTRUCTOR</p>
                        </div>
                        <div>
                            <p class="mb-1 text-black">Tipo de pago</p>
                            <p class="text-blue-600"><i class="fas fa-credit-card mr-1"></i> TRANSFERENCIA BANCARIA</p>
                            <p class="text-green-600"><i class="fas fa-money-check-alt mr-1"></i> CHEQUE</p>
                            <p class="text-red-500"><i class="fas fa-ban mr-1"></i> NO APLICA</p>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="instructores_data" id="instructores_data" value="[]">

                <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-0 mb-8 border-b-2">
                    <table class="w-full text-sm text-center">
                        <thead class="bg-gray-100 text-gray-700 font-bold border-b-2 border-gray-300">
                            <tr>
                                <th class="py-2 px-1"></th>
                                <th class="py-2 px-1">ID</th>
                                <th class="py-2 px-1">Nombre</th>
                                <th class="py-2 px-1">Apellido 1</th>
                                <th class="py-2 px-1">Apellido 2</th>
                                <th class="py-2 px-1">Tipo</th>
                                <th class="py-2 px-1">Pago<br>instructor</th>
                                <th class="py-2 px-1">Fecha<br>inicia</th>
                                <th class="py-2 px-1">Fecha<br>termina</th>
                                <th class="py-2 px-1">Horas</th>
                                <th class="py-2 px-1">Días</th>
                                <th class="py-2 px-1">Horario</th>
                                <th class="py-2 px-1">Fecha<br>pago</th>
                                <th class="py-2 px-1">Tipo<br>pago</th>
                            </tr>
                        </thead>
                        <tbody id="instructores_tbody">
                            <tr id="empty_row_instructores">
                                <td colspan="14" class="py-4 text-gray-500 bg-gray-50 border-b">No hay instructores
                                    asignados a este grupo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- Section 8: Finanzas -->
                <div class="relative mb-8 mt-12 text-center" id="seccion_finanzas">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Finanzas</span>
                    </div>
                </div>

                <div class="mb-8 p-6">
                    <!-- Row 1: Tipo de pago -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="text-left">
                            <label for="tipo_pago_grupo" class="block text-[#a02142] font-bold mb-1">* Tipo de pago</label>
                            <select id="tipo_pago_grupo" name="tipo_pago_grupo"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white text-gray-700 font-bold"
                                required>
                                <option value="" class="font-normal text-gray-500">» SELECCIONE EL TIPO DE PAGO</option>
                                <option value="PAGO POR GRUPO" {{ old('tipo_pago_grupo', $grupo->tipo_pago_grupo) == 'PAGO POR GRUPO' ? 'selected' : '' }}>PAGO POR GRUPO</option>
                                <option value="PAGO POR PERSONA" {{ old('tipo_pago_grupo', $grupo->tipo_pago_grupo) == 'PAGO POR PERSONA' ? 'selected' : '' }}>PAGO POR PERSONA</option>
                                <option value="CONDONACION" {{ old('tipo_pago_grupo', $grupo->tipo_pago_grupo) == 'CONDONACION' ? 'selected' : '' }}>CONDONACIÓN</option>
                                <option value="BECA GRUPAL" {{ old('tipo_pago_grupo', $grupo->tipo_pago_grupo) == 'BECA GRUPAL' ? 'selected' : '' }}>BECA GRUPAL</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Costos -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-left">
                            <label for="costo_por_persona" class="block text-[#a02142] font-bold mb-1">* Costo por
                                persona</label>
                            <input type="number" id="costo_por_persona" name="costo_por_persona" step="0.01" min="0"
                                value="{{ old('costo_por_persona', $grupo->costo_por_persona ?? '0.0') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white disabled:bg-gray-200 calculate-finanzas font-bold text-gray-700">
                        </div>
                        <div class="text-left">
                            <label for="costo_por_grupo" class="block text-[#a02142] font-bold mb-1">* Costo por
                                grupo</label>
                            <input type="number" id="costo_por_grupo" name="costo_por_grupo" step="0.01" min="0"
                                value="{{ old('costo_por_grupo', $grupo->costo_por_grupo ?? '0.0') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white disabled:bg-gray-200 calculate-finanzas font-bold text-gray-700">
                        </div>
                        <div class="text-left">
                            <label for="costo_coffee_break" class="block text-[#a02142] font-bold mb-1">* Costo del
                                coffee-break</label>
                            <input type="number" id="costo_coffee_break" name="costo_coffee_break" step="0.01" min="0"
                                value="{{ old('costo_coffee_break', $grupo->costo_coffee_break ?? '0.0') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white calculate-finanzas font-bold text-gray-700">
                        </div>
                    </div>

                    <!-- Row 3: Totales -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-left">
                            <label for="ingreso_total" class="block text-[#a02142] font-bold mb-1">* Ingreso total del
                                grupo</label>
                            <input type="number" id="ingreso_total" name="ingreso_total" step="0.01"
                                value="{{ old('ingreso_total', $grupo->ingreso_total ?? '0.0') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none bg-white font-bold cursor-not-allowed text-gray-700"
                                readonly>
                        </div>
                        <div class="text-left">
                            <label for="utilidad_grupo" class="block text-[#a02142] font-bold mb-1">* Utilidad calculada del
                                grupo</label>
                            <input type="number" id="utilidad_grupo" name="utilidad_grupo" step="0.01"
                                value="{{ old('utilidad_grupo', $grupo->utilidad_grupo ?? '0.0') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none bg-white font-bold cursor-not-allowed text-gray-700"
                                readonly>
                        </div>
                    </div>
                </div>

                <!-- Section 9: Archivos -->
                <div class="relative mb-8 mt-12 text-center" id="seccion_archivos">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Archivos</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 p-6">
                    <!-- Plan de Estudios -->
                    <div class="text-center">
                        <label class="block text-[#a02142] font-bold mb-4 text-left">* Archivo de plan de estudios</label>

                        @if($grupo->archivo_plan_estudios)
                            <div class="mb-4 text-left flex items-center">
                                <a href="{{ Storage::url($grupo->archivo_plan_estudios) }}" target="_blank"
                                    class="inline-flex flex-col items-center justify-center text-white bg-gray-800 hover:bg-gray-700 font-bold py-3 px-8 rounded-2xl shadow-lg border-2 border-gray-400 transition">
                                    <i class="fas fa-file-download text-[#d4b996] text-4xl mb-2"></i>
                                    <span class="text-lg">Descargar</span>
                                </a>
                            </div>
                        @endif

                        <div class="text-left">
                            <div
                                class="bg-[#ba905e] rounded p-2 inline-flex items-center text-left relative overflow-hidden cursor-pointer hover:bg-[#a67d4e] transition shadow w-40">
                                <i class="fas fa-file-plus text-black mr-2 text-lg"></i>
                                <span class="text-black font-bold text-sm">Agrega archivo</span>
                                <input type="file" name="archivo_plan_estudios" id="archivo_plan_estudios"
                                    accept=".xls,.xlsx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                            <p id="nombre_archivo_plan" class="text-sm text-gray-600 mt-2 font-bold"></p>
                        </div>
                    </div>

                    <!-- Archivo de Becas -->
                    <div class="text-center">
                        <label class="block text-[#a02142] font-bold mb-4 text-left">Archivo de becas del grupo</label>

                        @if($grupo->archivo_becas)
                            <div class="mb-4 text-left flex items-center">
                                <a href="{{ Storage::url($grupo->archivo_becas) }}" target="_blank"
                                    class="inline-flex flex-col items-center justify-center text-white bg-gray-800 hover:bg-gray-700 font-bold py-3 px-8 rounded-2xl shadow-lg border-2 border-gray-400 transition">
                                    <i class="fas fa-file-download text-[#d4b996] text-4xl mb-2"></i>
                                    <span class="text-lg">Descargar</span>
                                </a>
                            </div>
                        @else
                            <div class="mb-4 h-[92px]"></div>
                        @endif

                        <div class="text-left">
                            <div
                                class="bg-[#ba905e] rounded p-2 inline-flex items-center text-left relative overflow-hidden cursor-pointer hover:bg-[#a67d4e] transition shadow w-40">
                                <i class="fas fa-file-plus text-black mr-2 text-lg"></i>
                                <span class="text-black font-bold text-sm">Agrega archivo</span>
                                <input type="file" name="archivo_becas" id="archivo_becas" accept=".pdf"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                            <p id="nombre_archivo_becas" class="text-sm text-gray-600 mt-2 font-bold"></p>
                        </div>
                    </div>
                </div>


                <!-- Section 10: Comentarios -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Comentarios</span>
                    </div>
                </div>

                <div class="mb-8 p-6">
                    <label for="comentarios" class="block text-[#a02142] font-bold mb-2">Comentarios</label>
                    <textarea name="comentarios" id="comentarios" rows="4" maxlength="200"
                        class="w-full border-2 border-gray-400 rounded-lg p-3 focus:outline-none focus:border-red-500 bg-white font-bold text-gray-800 uppercase"
                        placeholder="Escribe un comentario...">{{ old('comentarios', $grupo->comentarios) }}</textarea>
                    <div class="text-right text-sm text-gray-500 mt-1 font-bold">
                        <span id="char_count">0</span> / <span class="text-red-800">200</span>
                    </div>
                </div>

                <!-- Section 11: Autorización -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center items-center gap-3">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Autorización</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 p-6">
                    <div>
                        <label class="block text-[#a02142] font-bold mb-2 text-lg">Autorizado por</label>
                        <input type="text"
                            value="{{ $grupo->autorizador ? "{$grupo->autorizador->name} {$grupo->autorizador->lastname} {$grupo->autorizador->lastname2}" : 'Sin autorización' }}"
                            class="w-full border-2 border-gray-400 rounded-full p-3 focus:outline-none bg-white font-bold text-gray-800 uppercase cursor-not-allowed"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-2 text-lg">Fecha autorización</label>
                        <input type="text"
                            value="{{ $grupo->fecha_autorizacion ? \Carbon\Carbon::parse($grupo->fecha_autorizacion)->format('d/m/Y \a \l\a\s H:i:s') : '' }}"
                            class="w-full border-2 border-gray-400 rounded-full p-3 focus:outline-none bg-white font-bold text-gray-800 cursor-not-allowed text-center mx-auto"
                            style="max-width:320px;" readonly>
                    </div>
                </div>

                <!-- Section 12: Modificaciones de estatus y revisiones -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center items-center gap-3">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Modificaciones
                            de estatus y revisiones</span>
                    </div>
                </div>

                <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                    <table id="revisiones_table"
                        class="w-full text-sm text-left align-middle border-collapse dt-responsive nowrap stripe hover bg-white"
                        style="width:100%">
                        <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                            <tr>
                                <th class="py-3 px-4 border-b border-gray-200">Estatus</th>
                                <th class="py-3 px-4 border-b border-gray-200">Observaciones</th>
                                <th class="py-3 px-4 border-b border-gray-200">Fecha revisión</th>
                                <th class="py-3 px-4 border-b border-gray-200">Revisado por</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupo->revisiones->sortByDesc('created_at') as $revision)
                                @php
                                    $revColorClass = 'bg-gray-500';
                                    if (strtoupper($revision->estatus) == 'PENDIENTE')
                                        $revColorClass = 'bg-yellow-500';
                                    elseif (strtoupper($revision->estatus) == 'AUTORIZADO')
                                        $revColorClass = 'bg-green-600';
                                    elseif (strtoupper($revision->estatus) == 'PROCESO' || strtoupper($revision->estatus) == 'PROCESS')
                                        $revColorClass = 'bg-blue-500';
                                    elseif (strtoupper($revision->estatus) == 'CONCLUIDO')
                                        $revColorClass = 'bg-purple-700';
                                    elseif (strtoupper($revision->estatus) == 'RECHAZADO')
                                        $revColorClass = 'bg-red-600';
                                    elseif (strtoupper($revision->estatus) == 'CALIFICADO')
                                        $revColorClass = 'bg-pink-500';
                                @endphp
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <div class="flex items-center justify-start gap-2">
                                            <span class="w-3 h-3 rounded-full {{ $revColorClass }}"></span>
                                            <span class="font-bold text-gray-700 uppercase">{{ $revision->estatus }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">{{ $revision->observaciones }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $revision->created_at->format('d/m/Y \a \l\a\s H:i:s') }}
                                    </td>
                                    <td class="py-3 px-4 uppercase">
                                        {{ $revision->user ? trim($revision->user->name . ' ' . $revision->user->lastname . ' ' . $revision->user->lastname2) : 'SISTEMA' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Section 13: Cambio de estatus -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                    </div>
                    <div class="relative flex justify-center items-center gap-3">
                        <span
                            class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Cambio
                            de estatus</span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6 items-end">
                        <div class="flex items-center text-lg h-full pb-2">
                            <span class="text-[#a02142] font-bold mr-2">Estatus actual del grupo:</span>
                            @php
                                $colorClase = 'bg-gray-500';
                                if ($grupo->estatus == 'PENDIENTE')
                                    $colorClase = 'bg-yellow-500';
                                elseif ($grupo->estatus == 'AUTORIZADO')
                                    $colorClase = 'bg-green-600';
                                elseif ($grupo->estatus == 'PROCESS' || $grupo->estatus == 'PROCESO')
                                    $colorClase = 'bg-blue-500';
                                elseif ($grupo->estatus == 'CONCLUIDO')
                                    $colorClase = 'bg-purple-700';
                                elseif ($grupo->estatus == 'RECHAZADO')
                                    $colorClase = 'bg-red-600';
                                elseif (strtoupper($grupo->estatus == 'CALIFICADO'))
                                    $colorClase = 'bg-pink-500';
                            @endphp
                            <span
                                class="w-6 h-6 rounded-full inline-block {{ $colorClase }} shadow-sm mr-2 flex-shrink-0"></span>
                            <span class="font-bold text-gray-800 uppercase">{{ $grupo->estatus }}</span>
                        </div>

                        <div>
                            @php
                                $puedeModificarTodo = auth()->user()->role === 'ADMINISTRADOR';
                                $puedeModificarLimitado = !$puedeModificarTodo && $grupo->estatus !== 'AUTORIZADO';
                                $deshabilitarEstatus = !($puedeModificarTodo || $puedeModificarLimitado);
                            @endphp

                            <label for="nuevo_estatus" class="block text-[#a02142] font-bold mb-2">* Estatus</label>
                            <select name="nuevo_estatus" id="nuevo_estatus"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                {{ $deshabilitarEstatus ? 'disabled' : '' }}>
                                <option value="{{ $grupo->estatus }}" selected>{{ strtoupper($grupo->estatus) }}</option>
                                @if($puedeModificarTodo)
                                    @foreach(['PENDIENTE', 'PROCESO', 'AUTORIZADO', 'RECHAZADO', 'CALIFICADO', 'CONCLUIDO', 'CANCELADO'] as $opt)
                                        @if($opt !== strtoupper($grupo->estatus))
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endif
                                    @endforeach
                                @elseif($puedeModificarLimitado)
                                    @foreach(['PENDIENTE', 'PROCESO', 'CONCLUIDO', 'CANCELADO'] as $opt)
                                        @if($opt !== strtoupper($grupo->estatus))
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>

                            @if($deshabilitarEstatus)
                                <input type="hidden" name="nuevo_estatus" value="{{ $grupo->estatus }}">
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="observaciones_estatus" class="block text-[#a02142] font-bold mb-2">Observaciones</label>
                        <textarea name="observaciones_estatus" id="observaciones_estatus" rows="4"
                            class="w-full border-2 border-gray-400 rounded-lg p-3 focus:outline-none focus:border-red-500 bg-white"
                            placeholder=""></textarea>
                    </div>
                </div>

                <!-- Modales and forms -->
                <div
                    class="flex justify-between py-4 border-t border-gray-300 mt-2 bg-[#f2fafc] px-8 -mx-8 -mb-8 rounded-b-lg">
                    <a href="{{ route('grupos.index') }}"
                        class="bg-[#dc3545] hover:bg-[#c82333] text-white font-bold py-2 px-6 rounded shadow flex items-center transition">
                        Salir <i class="fas fa-sign-out-alt mx-1"></i>
                    </a>
                    <button type="submit"
                        class="bg-[#1f2937] hover:bg-[#111827] text-white font-bold py-2 px-6 rounded shadow flex items-center transition">
                        Guardar <i class="fas fa-save mx-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal for Convenios -->
    <div id="convenio_modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-file-contract text-[#a02142] mr-2 text-2xl"></i>
                    CONVENIO
                </div>
                <button type="button" id="btn_cerrar_modal_convenio_x"
                    class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <div class="mb-4 text-center">
                    <label for="buscar_tipo" class="block text-[#a02142] font-bold mb-1">* Tipo</label>
                    <select id="buscar_tipo"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="">» VER TODO</option>
                        <option value="MARCO">MARCO</option>
                        <option value="ESPECIFICO">ESPECIFICO</option>
                    </select>
                </div>

                <div class="mb-4 text-center">
                    <label for="buscar_numero" class="block text-[#a02142] font-bold mb-1">* Número del convenio</label>
                    <input type="text" id="buscar_numero"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                </div>

                <div class="mb-4 text-center">
                    <label for="buscar_nombre" class="block text-[#a02142] font-bold mb-1">* Nombre del convenio</label>
                    <input type="text" id="buscar_nombre"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                </div>

                <div class="text-center mb-6">
                    <button type="button" id="btn_buscar_convenios"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow flex items-center mx-auto">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                </div>

                <div class="mb-6 text-center">
                    <label for="resultado_convenio" class="block text-[#a02142] font-bold mb-1">* Convenio</label>
                    <select id="resultado_convenio"
                        class="w-full border-2 border-yellow-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white shadow-[0_0_10px_rgba(250,204,21,0.5)]">
                        <option value="">» SELECCIONA EL CONVENIO</option>
                    </select>
                </div>

                <div class="flex justify-between items-center bg-gray-50 -m-6 p-4 border-t border-gray-200 mt-6">
                    <button type="button" id="btn_cerrar_modal_convenio"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-times-circle mr-2"></i> Cerrar
                    </button>
                    <button type="button" id="btn_agregar_convenio"
                        class="bg-[#1b6b47] hover:bg-[#155a3a] text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-plus mr-2"></i> Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 1 for Instructores -->
    <div id="instructor_modal_1"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-chalkboard-teacher text-[#a02142] mr-2 text-2xl"></i>
                    INSTRUCTORES
                </div>
                <button type="button" id="btn_cerrar_modal_instructor1_x"
                    class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <div class="mb-4 text-center">
                    <label for="buscar_curp_inst" class="block text-[#a02142] font-bold mb-1">* CURP</label>
                    <input type="text" id="buscar_curp_inst"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                </div>

                <div class="mb-4 text-center">
                    <label for="buscar_nombre_inst" class="block text-[#a02142] font-bold mb-1">* Nombre del
                        instructor</label>
                    <input type="text" id="buscar_nombre_inst"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                </div>

                <div class="text-center mb-6">
                    <button type="button" id="btn_buscar_instructores"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow flex items-center mx-auto">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                </div>

                <div class="mb-6 text-center">
                    <label for="resultado_instructor" class="block text-[#a02142] font-bold mb-1">* Instructores</label>
                    <select id="resultado_instructor"
                        class="w-full border-2 border-yellow-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white shadow-[0_0_10px_rgba(250,204,21,0.5)]">
                        <option value="">» SELECCIONE UN INSTRUCTOR</option>
                    </select>
                </div>

                <div class="flex justify-between items-center bg-gray-50 -m-6 p-4 border-t border-gray-200 mt-6">
                    <button type="button" id="btn_cerrar_modal_instructor1"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-times-circle mr-2"></i> Cerrar
                    </button>
                    <button type="button" id="btn_avanzar_instructor"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        Siguiente <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 for Instructores -->
    <div id="instructor_modal_2"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-chalkboard-teacher text-[#a02142] mr-2 text-2xl"></i>
                    INSTRUCTORES
                </div>
                <button type="button" id="btn_cerrar_modal_instructor2_x"
                    class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <!-- Info -->
                <div
                    class="bg-gray-100 p-4 rounded-lg mb-6 flex flex-wrap gap-4 font-bold text-gray-800 text-sm border-2 border-gray-300">
                    <div class="flex-1 min-w-[150px]">
                        <span class="text-[#a02142] text-xs block mb-1">Nombre:</span>
                        <span id="lbl_inst_nombre"></span>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <span class="text-[#a02142] text-xs block mb-1">Especialidad:</span>
                        <span id="lbl_inst_especialidad"></span>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <span class="text-[#a02142] text-xs block mb-1">Clave de elector:</span>
                        <span id="lbl_inst_clave"></span>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <span class="text-[#a02142] text-xs block mb-1">Estudios:</span>
                        <span id="lbl_inst_estudios"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Tipo</label>
                        <select id="inst_tipo_pago"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required>
                            <option value="">» SELECCIONE</option>
                            <option value="HONORARIOS">HONORARIOS</option>
                            <option value="SIN PAGO AL INSTRUCTOR">SIN PAGO AL INSTRUCTOR</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Fecha inicial</label>
                        <input type="date" id="inst_fecha_inicial"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Fecha final</label>
                        <input type="date" id="inst_fecha_final"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Total días</label>
                        <input type="number" id="inst_total_dias"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required min="1">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Total horas</label>
                        <input type="number" id="inst_total_horas"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required min="1">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Horario de trabajo</label>
                        <input type="text" id="inst_horario"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm uppercase"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Pago a instructor</label>
                        <input type="number" id="inst_pago_instructor" step="0.01"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required min="0">
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Fecha de pago</label>
                        <input type="date" id="inst_fecha_pago"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1 text-xs">* Tipo de pago</label>
                        <select id="inst_forma_pago"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-3 focus:outline-none focus:border-red-500 bg-white text-sm"
                            required>
                            <option value="">» SELECCIONE</option>
                            <option value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option>
                            <option value="CHEQUE">CHEQUE</option>
                            <option value="NO APLICA">NO APLICA</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center bg-gray-50 -m-6 p-4 border-t border-gray-200 mt-6">
                    <button type="button" id="btn_volver_instructor1"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </button>
                    <button type="button" id="btn_agregar_instructor_final"
                        class="bg-[#1b6b47] hover:bg-[#155a3a] text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-plus mr-2"></i> Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Calendar -->
    <div id="calendario_modal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-calendar-alt text-[#a02142] mr-2 text-2xl"></i>
                    CALENDARIO
                </div>
                <button type="button" id="btn_cerrar_modal_x" class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <!-- Select for TIPO -->
                <div class="mb-4 text-center">
                    <label for="modal_tipo_fecha" class="block text-[#a02142] font-bold mb-1">* Tipo</label>
                    <select id="modal_tipo_fecha"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="DÍA" selected>DÍA</option>
                        <option value="SEMANA">SEMANA</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center">
                        <label for="modal_fecha_inicial" class="block text-[#a02142] font-bold mb-1">* Fecha inicial</label>
                        <input type="date" id="modal_fecha_inicial"
                            class="w-full border-2 border-yellow-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white shadow-[0_0_10px_rgba(250,204,21,0.5)]">
                    </div>
                    <div class="text-center">
                        <label for="modal_fecha_final" class="block text-[#a02142] font-bold mb-1">* Fecha final</label>
                        <input type="date" id="modal_fecha_final" disabled
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none bg-gray-300 cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center">
                        <label for="modal_hora_inicial" class="block text-[#a02142] font-bold mb-1">* Hora inicial</label>
                        <input type="time" id="modal_hora_inicial"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white text-center">
                    </div>
                    <div class="text-center">
                        <label for="modal_hora_final" class="block text-[#a02142] font-bold mb-1">* Hora final</label>
                        <input type="time" id="modal_hora_final"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white text-center">
                    </div>
                </div>

                <div class="text-center mb-6">
                    <button type="button" id="btn_resetear_relojes"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                        <i class="fas fa-history mr-1"></i> Resetear relojes
                    </button>
                </div>

                <div class="flex justify-between items-center bg-gray-50 -m-6 p-4 mt-6 border-t border-gray-200">
                    <button type="button" id="btn_cerrar_modal"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-times-circle mr-2"></i> Cerrar
                    </button>
                    <button type="button" id="btn_agregar_fecha"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-plus mr-2"></i> Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CDN -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function () {
            const tipoServicio = document.getElementById('tipo_servicio');
            const modalidadCe = document.getElementById('modalidad_ce');
            const cursoSelect = document.getElementById('curso_select');
            const cursoIdInput = document.getElementById('curso_id');
            const cursoIcategroIdInput = document.getElementById('curso_icategro_id');

            // Toggle Modalidad C.E. disable state
            $(tipoServicio).on('change', function () {
                if ($(this).val() === 'CAE') {
                    $(modalidadCe).prop('disabled', false).removeClass('bg-gray-200 cursor-not-allowed');
                } else {
                    $(modalidadCe).prop('disabled', true).addClass('bg-gray-200 cursor-not-allowed').val('');
                }
            });

            // AJAX for dependent dropdown (Oferta -> Campo Formacion)
            $('#oferta_educativa_id').on('change', function () {
                var ofertaId = $(this).val();
                var campoDropdown = $('#campo_formacion_id');
                var especialidadDropdown = $('#especialidad_ocupacional_id');
                var cursoDropdown = $('#curso_select');
                var loadingText = $('#campo-loading');

                campoDropdown.empty().append('<option value="">» SELECCIONA EL CAMPO DE FORMACION PROFESIONAL</option>');
                especialidadDropdown.empty().append('<option value="">» SELECCIONA LA ESPECIALIDAD OCUPACIONAL</option>');
                cursoDropdown.empty().append('<option value="">» SELECCIONA EL CURSO</option>');

                if (ofertaId) {
                    loadingText.removeClass('hidden');
                    $.ajax({
                        url: '/api/campos-by-oferta/' + ofertaId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            loadingText.addClass('hidden');
                            if (data.length > 0) {
                                $.each(data, function (key, value) {
                                    campoDropdown.append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            } else {
                                campoDropdown.append('<option value="" disabled>No hay campos disponibles</option>');
                            }
                        },
                        error: function () {
                            loadingText.addClass('hidden');
                            console.error('Error al cargar campos.');
                        }
                    });
                }
            });

            // AJAX for dependent dropdown (Campo Formacion -> Especialidad Ocupacional)
            $('#campo_formacion_id').on('change', function () {
                var campoId = $(this).val();
                var especialidadDropdown = $('#especialidad_ocupacional_id');
                var cursoDropdown = $('#curso_select');
                var loadingText = $('#especialidad-loading');

                especialidadDropdown.empty().append('<option value="">» SELECCIONA LA ESPECIALIDAD OCUPACIONAL</option>');
                cursoDropdown.empty().append('<option value="">» SELECCIONA EL CURSO</option>');

                if (campoId) {
                    loadingText.removeClass('hidden');
                    $.ajax({
                        url: '/api/especialidades-by-campo/' + campoId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            loadingText.addClass('hidden');
                            if (data.length > 0) {
                                $.each(data, function (key, value) {
                                    especialidadDropdown.append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            } else {
                                especialidadDropdown.append('<option value="" disabled>No hay especialidades disponibles</option>');
                            }
                        },
                        error: function () {
                            loadingText.addClass('hidden');
                            console.error('Error al cargar especialidades.');
                        }
                    });
                }
            });

            // Populate Cursos based on Especialidad and Tipo de Servicio
            $('#especialidad_ocupacional_id').on('change', function () {
                var especialidadId = $(this).val();
                var tipoDesc = $('#tipo_servicio').val();
                loadCursos(especialidadId, tipoDesc);
            });

            function loadCursos(especialidadId, tipoDesc) {
                var cursoDropdown = $('#curso_select');
                var loadingText = $('#curso-loading');

                cursoDropdown.empty().append('<option value="">» SELECCIONA EL CURSO</option>');

                if (!especialidadId || !tipoDesc) return;

                const tipo = tipoDesc === 'CAE' ? 'cae' : 'icategro';
                loadingText.removeClass('hidden');

                $.ajax({
                    url: '/api/grupos/cursos/' + especialidadId + '/' + tipo,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        loadingText.addClass('hidden');
                        if (data.length > 0) {
                            $.each(data, function (key, value) {
                                cursoDropdown.append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        } else {
                            cursoDropdown.append('<option value="" disabled>No hay cursos disponibles</option>');
                        }
                    },
                    error: function () {
                        loadingText.addClass('hidden');
                        console.error('Error al cargar cursos.');
                    }
                });
            }

            // Handles which hidden input gets the value
            cursoSelect.addEventListener('change', function () {
                const id = this.value;
                const tipoDesc = tipoServicio.value;
                if (tipoDesc === 'CAE') {
                    cursoIdInput.value = id;
                    cursoIcategroIdInput.value = '';
                } else if (tipoDesc === 'Extensión') {
                    cursoIcategroIdInput.value = id;
                    cursoIdInput.value = '';
                }
            });

            // Calendario Logic
            let calendarioData = @json($grupo->calendarios);


            // Fix formatting of time from DB (it appends :00) and keys depending on existing structure
            calendarioData = calendarioData.map(item => {
                return {
                    tipo_fecha: item.tipo_fecha || item.tipo || "DÍA",
                    fecha_inicial: item.fecha_inicial,
                    fecha_final: item.fecha_final || '',
                    hora_inicial: item.hora_inicial.substring(0, 5),
                    hora_final: item.hora_final.substring(0, 5),
                    total_dias: item.total_dias || 1,
                    total_horas: item.total_horas
                };
            });

            const btnAbrirModal = document.getElementById('btn_abrir_modal');
            const modal = document.getElementById('calendario_modal');
            const btnCerrarModal = document.getElementById('btn_cerrar_modal');
            const btnCerrarModalX = document.getElementById('btn_cerrar_modal_x');
            const btnAgregarFecha = document.getElementById('btn_agregar_fecha');
            const btnResetearRelojes = document.getElementById('btn_resetear_relojes');

            const tipoFecha = document.getElementById('modal_tipo_fecha');
            const modFechaInicial = document.getElementById('modal_fecha_inicial');
            const modFechaFinal = document.getElementById('modal_fecha_final');
            const modHoraInicial = document.getElementById('modal_hora_inicial');
            const modHoraFinal = document.getElementById('modal_hora_final');

            const tbody = document.getElementById('calendario_tbody');
            const inputData = document.getElementById('calendario_data');

            function openModal() { modal.classList.remove('hidden'); }
            function closeModal() {
                modal.classList.add('hidden');
                tipoFecha.value = 'DÍA';
                tipoFecha.dispatchEvent(new Event('change'));
                modFechaInicial.value = '';
                modFechaFinal.value = '';
                resetRelojes();
            }
            function resetRelojes() {
                modHoraInicial.value = '';
                modHoraFinal.value = '';
            }

            btnAbrirModal.addEventListener('click', openModal);
            btnCerrarModal.addEventListener('click', closeModal);
            btnCerrarModalX.addEventListener('click', closeModal);
            btnResetearRelojes.addEventListener('click', resetRelojes);

            tipoFecha.addEventListener('change', function () {
                if (this.value === 'DÍA') {
                    modFechaFinal.disabled = true; modFechaFinal.value = '';
                    modFechaFinal.classList.add('bg-gray-300', 'cursor-not-allowed');
                    modFechaFinal.classList.remove('border-yellow-400', 'shadow-[0_0_10px_rgba(250,204,21,0.5)]');
                    modFechaInicial.classList.add('border-yellow-400', 'shadow-[0_0_10px_rgba(250,204,21,0.5)]');
                } else {
                    modFechaFinal.disabled = false;
                    modFechaFinal.classList.remove('bg-gray-300', 'cursor-not-allowed');
                    modFechaFinal.classList.add('border-yellow-400', 'shadow-[0_0_10px_rgba(250,204,21,0.5)]');
                }
            });

            modFechaInicial.addEventListener('change', function () {
                if (tipoFecha.value === 'SEMANA' && this.value) {
                    modFechaFinal.min = this.value;
                    if (modFechaFinal.value && modFechaFinal.value < this.value) {
                        modFechaFinal.value = this.value;
                    }
                }
            });

            modHoraFinal.addEventListener('change', function () {
                if (modHoraInicial.value && this.value <= modHoraInicial.value) {
                    alert('La hora final debe ser mayor que la hora inicial.');
                    this.value = '';
                }
            });

            function formatearFecha(fechaStr) {
                if (!fechaStr) return '';
                const parts = fechaStr.split('-');
                return `${parts[2]}/${parts[1]}/${parts[0]}`;
            }

            function calcularDiferenciaHoras(hInit, hEnd) {
                const init = new Date(`2000-01-01T${hInit}:00`);
                const end = new Date(`2000-01-01T${hEnd}:00`);
                return (end - init) / (1000 * 60 * 60);
            }

            function renderTable() {
                tbody.innerHTML = '';
                if (calendarioData.length === 0) {
                    tbody.innerHTML = '<tr id="empty_row"><td colspan="8" class="py-4 text-gray-500 bg-gray-50 border-b">No hay datos disponibles en la tabla</td></tr>';
                    inputData.value = '[]';
                    return;
                }

                calendarioData.forEach((item, index) => {
                    const tr = document.createElement('tr');
                    tr.className = index % 2 === 0 ? 'bg-white border-b' : 'bg-gray-50 border-b';

                    const actionTd = document.createElement('td');
                    actionTd.className = 'py-3 px-2 flex justify-center items-center h-full';
                    actionTd.innerHTML = `
                                                                                                                                                            <button type="button" class="text-red-500 hover:text-red-700 mx-1 btn_eliminar_cal" data-index="${index}" title="Eliminar">
                                                                                                                                                                <i class="fas fa-trash-alt"></i>
                                                                                                                                                            </button>
                                                                                                                                                            <i class="fas fa-calendar-alt text-blue-500 mx-1"></i>
                                                                                                                                                        `;

                    tr.appendChild(actionTd);
                    tr.innerHTML += `<td class="py-3 px-2">${item.tipo_fecha || item.tipo}</td>`;
                    tr.innerHTML += `<td class="py-3 px-2">${formatearFecha(item.fecha_inicial)}</td>`;
                    tr.innerHTML += `<td class="py-3 px-2">${formatearFecha(item.fecha_final) || '-'}</td>`;
                    tr.innerHTML += `<td class="py-3 px-2 text-red-600 font-bold">${item.hora_inicial}</td>`;
                    tr.innerHTML += `<td class="py-3 px-2 text-red-600 font-bold">${item.hora_final}</td>`;
                    tr.innerHTML += `<td class="py-3 px-2">${item.total_dias}</td>`;
                    tr.innerHTML += `<td class="py-3 px-2">${item.total_horas}</td>`;

                    tbody.appendChild(tr);
                });

                inputData.value = JSON.stringify(calendarioData);
            }

            // Bind delete globally for dynamic elements
            $(document).on('click', '.btn_eliminar_cal', function () {
                const index = $(this).data('index');
                calendarioData.splice(index, 1);
                renderTable();
            });

            btnAgregarFecha.addEventListener('click', function () {
                const tipo = tipoFecha.value;
                const fInit = modFechaInicial.value;
                const fEnd = modFechaFinal.value;
                const hInit = modHoraInicial.value;
                const hEnd = modHoraFinal.value;

                if (!fInit || !hInit || !hEnd) {
                    alert('Debe completar la fecha inicial, hora inicial y hora final.');
                    return;
                }
                if (tipo === 'SEMANA' && !fEnd) {
                    alert('En tipo SEMANA debe capturar fecha final.');
                    return;
                }

                if (hEnd <= hInit) {
                    alert('La hora final debe ser mayor que la hora inicial.');
                    return;
                }

                let totalDias = 1;
                if (tipo === 'SEMANA') {
                    const diffTime = Math.abs(new Date(fEnd) - new Date(fInit));
                    totalDias = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                }

                const horasPorDia = calcularDiferenciaHoras(hInit, hEnd);
                const totalHoras = totalDias * Math.ceil(horasPorDia);

                calendarioData.push({
                    tipo_fecha: tipo,
                    fecha_inicial: fInit,
                    fecha_final: tipo === 'SEMANA' ? fEnd : '',
                    hora_inicial: hInit,
                    hora_final: hEnd,
                    total_dias: totalDias,
                    total_horas: totalHoras
                });

                renderTable();
                closeModal();
            });

            // Re-render initial table data
            renderTable();

            // --- CONVENIOS Y INSTRUCTORES (VANILLA JS) ---
            let conveniosData = @json($grupo->convenios);
            console.log("Datos originales de Laravel:", conveniosData);

            conveniosData = conveniosData.map(item => {
                return {
                    id: item.id,
                    tipo: item.type,
                    numero: item.number,
                    nombre: item.name,
                    objeto: item.object
                };
            });

            const btnAbrirModalConvenio = document.getElementById('btn_abrir_modal_convenio');
            const modalConvenio = document.getElementById('convenio_modal');
            const selectResultadoConvenio = document.getElementById('resultado_convenio');
            const tbodyConvenios = document.getElementById('convenios_tbody');
            const inputConveniosData = document.getElementById('convenios_data');

            let conveniosEncontrados = [];

            if (btnAbrirModalConvenio) btnAbrirModalConvenio.addEventListener('click', () => modalConvenio.classList.remove('hidden'));

            document.querySelectorAll('#btn_cerrar_modal_convenio, #btn_cerrar_modal_convenio_x').forEach(btn => {
                btn.addEventListener('click', () => {
                    modalConvenio.classList.add('hidden');
                    document.getElementById('buscar_tipo').value = '';
                    document.getElementById('buscar_numero').value = '';
                    document.getElementById('buscar_nombre').value = '';
                    selectResultadoConvenio.innerHTML = '<option value="">» SELECCIONA EL CONVENIO</option>';
                });
            });

            document.getElementById('btn_buscar_convenios').addEventListener('click', async function () {
                const tipo = document.getElementById('buscar_tipo').value;
                const numero = document.getElementById('buscar_numero').value;
                const nombre = document.getElementById('buscar_nombre').value;

                let url = '/api/convenios/search?';
                if (tipo) url += `tipo=${encodeURIComponent(tipo)}&`;
                if (numero) url += `numero=${encodeURIComponent(numero)}&`;
                if (nombre) url += `nombre=${encodeURIComponent(nombre)}`;

                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    selectResultadoConvenio.innerHTML = '<option value="">» SELECCIONA EL CONVENIO</option>';
                    conveniosEncontrados = data;

                    if (data.length > 0) {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = `${item.no_convenio} - ${item.institucion}`;
                            selectResultadoConvenio.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = "";
                        option.textContent = "No se encontraron convenios";
                        option.disabled = true;
                        selectResultadoConvenio.appendChild(option);
                    }
                } catch (error) {
                    console.error('Error buscar_convenios', error);
                }
            });

            function renderTableConvenios() {
                tbodyConvenios.innerHTML = '';
                if (conveniosData.length === 0) {
                    tbodyConvenios.innerHTML = '<tr id="empty_row_convenios"><td colspan="5" class="py-4 text-gray-500 bg-gray-50 border-b">No hay datos disponibles en la tabla</td></tr>';
                    inputConveniosData.value = '[]';
                    return;
                }

                conveniosData.forEach((item, index) => {
                    const tr = document.createElement('tr');
                    tr.className = index % 2 === 0 ? 'bg-white border-b' : 'bg-gray-50 border-b';

                    tr.innerHTML = `
                                                                                                                                                            <td class="py-2 px-2 text-center">
                                                                                                                                                                <button type="button" class="text-red-500 hover:text-red-700 btn_eliminar_convenio" data-index="${index}" title="Eliminar">
                                                                                                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                                                                                                </button>
                                                                                                                                                            </td>
                                                                                                                                                            <td class="py-2 px-2 text-gray-700">${item.tipo}</td>
                                                                                                                                                            <td class="py-2 px-2 text-gray-700">${item.numero}</td>
                                                                                                                                                            <td class="py-2 px-2 text-gray-700 uppercase text-left">${item.nombre}</td>
                                                                                                                                                            <td class="py-2 px-2 text-gray-700 text-xs text-left">${item.objeto ? item.objeto : '-'}</td>
                                                                                                                                                        `;
                    tbodyConvenios.appendChild(tr);
                });

                inputConveniosData.value = JSON.stringify(conveniosData.map(c => c.id));
            }

            tbodyConvenios.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn_eliminar_convenio');
                if (btn) {
                    const index = btn.getAttribute('data-index');
                    if (index !== null) {
                        conveniosData.splice(index, 1);
                        renderTableConvenios();
                    }
                }
            });

            document.getElementById('btn_agregar_convenio').addEventListener('click', function () {
                const selectedId = selectResultadoConvenio.value;
                if (!selectedId) {
                    alert('Seleccione un convenio de la lista.');
                    return;
                }
                if (conveniosData.some(c => c.id == selectedId)) {
                    alert('Este convenio ya fue agregado.');
                    return;
                }
                const cv = conveniosEncontrados.find(c => c.id == selectedId);
                if (cv) {
                    conveniosData.push({
                        id: cv.id,
                        tipo: cv.clasificacion_convenio,
                        numero: cv.no_convenio,
                        nombre: cv.institucion,
                        objeto: cv.objeto_convenio
                    });
                    renderTableConvenios();
                    document.getElementById('btn_cerrar_modal_convenio').click();
                }
            });
            renderTableConvenios();

            // INSTRUCTORES
            let instructoresData = @json($grupo->instructores);


            instructoresData = instructoresData.map(item => {
                return {
                    instructor_id: item.id,
                    nombre: item.nombre,
                    apellido_paterno: item.apellido_1,
                    apellido_materno: item.apellido_2,
                    tipo: item.pivot ? item.pivot.tipo : '',
                    pago_instructor: item.pivot ? item.pivot.pago_instructor : '',
                    fecha_inicio: item.pivot ? item.pivot.fecha_inicio : '',
                    fecha_termino: item.pivot ? item.pivot.fecha_termino : '',
                    duracion_dias: item.pivot ? item.pivot.duracion_dias : '',
                    duracion_horas: item.pivot ? item.pivot.duracion_horas : '',
                    horario: item.pivot ? item.pivot.horario : '',
                    fecha_pago: item.pivot ? item.pivot.fecha_pago : '',
                    tipo_pago: item.pivot ? item.pivot.tipo_pago : ''
                };
            });

            const modalInstructor1 = document.getElementById('instructor_modal_1');
            const modalInstructor2 = document.getElementById('instructor_modal_2');
            const selectResultadoInstructor = document.getElementById('resultado_instructor');
            const tbodyInstructores = document.getElementById('instructores_tbody');
            const inputInstructoresData = document.getElementById('instructores_data');

            let instructoresEncontrados = [];
            let instructorSeleccionado = null;

            document.getElementById('btn_abrir_modal_instructor1').addEventListener('click', () => modalInstructor1.classList.remove('hidden'));

            function closeInstructoresModales() {
                modalInstructor1.classList.add('hidden');
                modalInstructor2.classList.add('hidden');
            }

            document.querySelectorAll('#btn_cerrar_modal_instructor1, #btn_cerrar_modal_instructor1_x, #btn_cerrar_modal_instructor2_x').forEach(btn => {
                btn.addEventListener('click', closeInstructoresModales);
            });

            document.getElementById('btn_volver_instructor1').addEventListener('click', function () {
                modalInstructor2.classList.add('hidden');
                modalInstructor1.classList.remove('hidden');
            });

            document.getElementById('btn_buscar_instructores').addEventListener('click', async function () {
                const curp = document.getElementById('buscar_curp_inst').value;
                const nombre = document.getElementById('buscar_nombre_inst').value;

                let url = '/api/instructores/search?';
                if (curp) url += `curp=${encodeURIComponent(curp)}&`;
                if (nombre) url += `nombre=${encodeURIComponent(nombre)}`;

                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    selectResultadoInstructor.innerHTML = '<option value="">» SELECCIONE UN INSTRUCTOR</option>';
                    instructoresEncontrados = data;

                    if (data.length > 0) {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = `${item.curp} - ${item.nombre} ${item.apellido_paterno} ${item.apellido_materno}`;
                            selectResultadoInstructor.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = "";
                        option.textContent = "No se encontraron instructores";
                        option.disabled = true;
                        selectResultadoInstructor.appendChild(option);
                    }
                } catch (error) {
                    console.error('Error buscar instructores', error);
                }
            });

            document.getElementById('btn_avanzar_instructor').addEventListener('click', function () {
                const selectedId = selectResultadoInstructor.value;
                if (!selectedId) {
                    alert('Seleccione un instructor.');
                    return;
                }
                if (instructoresData.some(i => i.instructor_id == selectedId)) {
                    alert('Este instructor ya ha sido asignado al grupo.');
                    return;
                }

                instructorSeleccionado = instructoresEncontrados.find(i => i.id == selectedId);
                if (instructorSeleccionado) {
                    document.getElementById('lbl_inst_nombre').textContent = `${instructorSeleccionado.nombre} ${instructorSeleccionado.apellido_paterno} ${instructorSeleccionado.apellido_materno}`;
                    document.getElementById('lbl_inst_especialidad').textContent = instructorSeleccionado.especialidad_ocupacional_id || 'N/A';
                    document.getElementById('lbl_inst_clave').textContent = instructorSeleccionado.clave_elector || 'N/A';
                    document.getElementById('lbl_inst_estudios').textContent = instructorSeleccionado.grado_estudio || 'N/A';

                    modalInstructor1.classList.add('hidden');
                    modalInstructor2.classList.remove('hidden');
                }
            });

            document.getElementById('btn_agregar_instructor_final').addEventListener('click', function () {
                const tipo = document.getElementById('inst_tipo_pago').value;
                const fInit = document.getElementById('inst_fecha_inicial').value;
                const fEnd = document.getElementById('inst_fecha_final').value;
                const tDias = document.getElementById('inst_total_dias').value;
                const tHoras = document.getElementById('inst_total_horas').value;
                const horario = document.getElementById('inst_horario').value;
                const pago = document.getElementById('inst_pago_instructor').value;
                const fPago = document.getElementById('inst_fecha_pago').value;
                const tPago = document.getElementById('inst_forma_pago').value;

                if (!tipo || !fInit || !fEnd || !tDias || !tHoras || !horario || !pago || !fPago || !tPago) {
                    alert('Debe completar todos los campos obligatorios (*).');
                    return;
                }

                instructoresData.push({
                    instructor_id: instructorSeleccionado.id,
                    nombre: instructorSeleccionado.nombre,
                    apellido_paterno: instructorSeleccionado.apellido_paterno,
                    apellido_materno: instructorSeleccionado.apellido_materno,
                    tipo: tipo,
                    fecha_inicio: fInit,
                    fecha_termino: fEnd,
                    duracion_dias: tDias,
                    duracion_horas: tHoras,
                    horario: horario,
                    pago_instructor: pago,
                    fecha_pago: fPago,
                    tipo_pago: tPago
                });

                renderTableInstructores();
                closeInstructoresModales();
            });

            function renderTableInstructores() {
                tbodyInstructores.innerHTML = '';
                if (instructoresData.length === 0) {
                    tbodyInstructores.innerHTML = '<tr id="empty_row_instructores"><td colspan="14" class="py-4 text-gray-500 bg-gray-50 border-b">No hay instructores asignados a este grupo</td></tr>';
                    inputInstructoresData.value = '[]';
                    return;
                }

                instructoresData.forEach((item, index) => {
                    const tr = document.createElement('tr');
                    tr.className = index % 2 === 0 ? 'bg-white border-b hover:bg-gray-100' : 'bg-gray-50 border-b hover:bg-gray-100';

                    let iconTipo = '';
                    if (item.tipo === 'HONORARIOS') iconTipo = '<i class="fas fa-file-invoice-dollar text-green-800 text-lg" title="HONORARIOS"></i>';
                    else if (item.tipo === 'SIN PAGO AL INSTRUCTOR') iconTipo = '<i class="fas fa-handshake text-red-800 text-lg" title="SIN PAGO"></i>';

                    let iconPago = '';
                    if (item.tipo_pago === 'TRANSFERENCIA BANCARIA') iconPago = '<i class="fas fa-credit-card text-blue-600 text-lg" title="TRANSFERENCIA"></i>';
                    else if (item.tipo_pago === 'CHEQUE') iconPago = '<i class="fas fa-money-check-alt text-green-600 text-lg" title="CHEQUE"></i>';
                    else if (item.tipo_pago === 'NO APLICA') iconPago = '<i class="fas fa-ban text-red-500 text-lg" title="NO APLICA"></i>';

                    tr.innerHTML = `
                                                                                                                                                            <td class="py-2 px-1 text-center">
                                                                                                                                                                <div class="flex flex-col items-center justify-center space-y-1">
                                                                                                                                                                    <button type="button" class="text-red-500 hover:text-red-700 btn_eliminar_instructor focus:outline-none" data-index="${index}" title="Eliminar">
                                                                                                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                                                                                                    </button>
                                                                                                                                                                    <a href="/instructores/${item.instructor_id}" target="_blank" class="text-blue-500 hover:text-blue-700 focus:outline-none mt-1" title="Ver instructor">
                                                                                                                                                                        <i class="fas fa-eye"></i>
                                                                                                                                                                    </a>
                                                                                                                                                                </div>
                                                                                                                                                            </td>
                                                                                                                                                            <td class="py-2 px-1 font-bold">${item.instructor_id}</td>
                                                                                                                                                            <td class="py-2 px-1 uppercase">${item.nombre}</td>
                                                                                                                                                            <td class="py-2 px-1 uppercase">${item.apellido_paterno}</td>
                                                                                                                                                            <td class="py-2 px-1 uppercase">${item.apellido_materno}</td>
                                                                                                                                                            <td class="py-2 px-1 text-center">${iconTipo}</td>
                                                                                                                                                            <td class="py-2 px-1">${item.pago_instructor}</td>
                                                                                                                                                            <td class="py-2 px-1 text-xs">${formatearFecha(item.fecha_inicio)}</td>
                                                                                                                                                            <td class="py-2 px-1 text-xs">${formatearFecha(item.fecha_termino)}</td>
                                                                                                                                                            <td class="py-2 px-1">${item.duracion_horas}</td>
                                                                                                                                                            <td class="py-2 px-1">${item.duracion_dias}</td>
                                                                                                                                                            <td class="py-2 px-1 text-xs uppercase max-w-[120px] truncate" title="${item.horario}">${item.horario}</td>
                                                                                                                                                            <td class="py-2 px-1 text-xs">${formatearFecha(item.fecha_pago)}</td>
                                                                                                                                                            <td class="py-2 px-1 text-center">${iconPago}</td>
                                                                                                                                                        `;
                    tbodyInstructores.appendChild(tr);
                });

                inputInstructoresData.value = JSON.stringify(instructoresData);
            }

            tbodyInstructores.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn_eliminar_instructor');
                if (btn) {
                    const index = btn.getAttribute('data-index');
                    if (index !== null) {
                        instructoresData.splice(index, 1);
                        renderTableInstructores();
                    }
                }
            });

            renderTableInstructores();

            // --- FINANZAS (VANILLA JS) ---
            const tipoPagoGrupoSelect = document.getElementById('tipo_pago_grupo');
            const costoPersonaInput = document.getElementById('costo_por_persona');
            const costoGrupoInput = document.getElementById('costo_por_grupo');
            const costoCoffeeInput = document.getElementById('costo_coffee_break');
            const ingresoTotalInput = document.getElementById('ingreso_total');
            const utilidadGrupoInput = document.getElementById('utilidad_grupo');
            const alumnosInicianInput = document.getElementById('alumnos_inician');

            function evaluarTipoPagoGrupo() {
                const tipo = tipoPagoGrupoSelect.value;
                if (tipo === 'PAGO POR PERSONA') {
                    costoPersonaInput.disabled = false;
                    costoPersonaInput.classList.remove('bg-gray-200');
                    costoGrupoInput.disabled = true;
                    costoGrupoInput.classList.add('bg-gray-200');
                    costoGrupoInput.value = '0.0';
                } else if (tipo === 'PAGO POR GRUPO') {
                    costoPersonaInput.disabled = true;
                    costoPersonaInput.classList.add('bg-gray-200');
                    costoPersonaInput.value = '0.0';
                    costoGrupoInput.disabled = false;
                    costoGrupoInput.classList.remove('bg-gray-200');
                } else if (tipo === 'CONDONACION' || tipo === 'BECA GRUPAL') {
                    costoPersonaInput.disabled = true;
                    costoPersonaInput.classList.add('bg-gray-200');
                    costoPersonaInput.value = '0.0';
                    costoGrupoInput.disabled = true;
                    costoGrupoInput.classList.add('bg-gray-200');
                    costoGrupoInput.value = '0.0';
                } else {
                    costoPersonaInput.disabled = true;
                    costoPersonaInput.classList.add('bg-gray-200');
                    costoGrupoInput.disabled = true;
                    costoGrupoInput.classList.add('bg-gray-200');
                }
                calcularFinanzas();
            }

            function calcularFinanzas() {
                const tipo = tipoPagoGrupoSelect.value;
                const costoPersona = parseFloat(costoPersonaInput.value) || 0;
                const costoGrupo = parseFloat(costoGrupoInput.value) || 0;
                const costoCoffee = parseFloat(costoCoffeeInput.value) || 0;
                const alumnos = parseInt(alumnosInicianInput.value) || 0;

                let ingreso = 0;
                if (tipo === 'PAGO POR PERSONA') {
                    ingreso = costoPersona * alumnos;
                } else if (tipo === 'PAGO POR GRUPO') {
                    ingreso = costoGrupo;
                }

                ingresoTotalInput.value = ingreso.toFixed(2);

                let totalHonorarios = 0;
                instructoresData.forEach(inst => {
                    if (inst.tipo === 'HONORARIOS') {
                        totalHonorarios += parseFloat(inst.pago_instructor) || 0;
                    }
                });

                const utilidad = ingreso - totalHonorarios - costoCoffee;
                utilidadGrupoInput.value = utilidad.toFixed(2);
            }

            tipoPagoGrupoSelect.addEventListener('change', evaluarTipoPagoGrupo);

            [costoPersonaInput, costoGrupoInput, costoCoffeeInput, alumnosInicianInput].forEach(input => {
                if (input) input.addEventListener('input', calcularFinanzas);
            });

            // Re-render table de instructores para re-calcular finanzas si se agrega/quita instructor honorario
            const _oldRenderTableInstructores = renderTableInstructores;
            renderTableInstructores = function () {
                _oldRenderTableInstructores();
                calcularFinanzas();
            };

            evaluarTipoPagoGrupo();


            // --- ARCHIVOS ---
            const archivoPlanInput = document.getElementById('archivo_plan_estudios');
            const archivoBecasInput = document.getElementById('archivo_becas');
            const nombreArchivoPlan = document.getElementById('nombre_archivo_plan');
            const nombreArchivoBecas = document.getElementById('nombre_archivo_becas');

            if (archivoPlanInput) {
                archivoPlanInput.addEventListener('change', function (e) {
                    if (this.files && this.files.length > 0) {
                        nombreArchivoPlan.textContent = 'Seleccionado: ' + this.files[0].name;
                    } else {
                        nombreArchivoPlan.textContent = '';
                    }
                });
            }

            if (archivoBecasInput) {
                archivoBecasInput.addEventListener('change', function (e) {
                    if (this.files && this.files.length > 0) {
                        nombreArchivoBecas.textContent = 'Seleccionado: ' + this.files[0].name;
                    } else {
                        nombreArchivoBecas.textContent = '';
                    }
                });
            }

            // --- COMENTARIOS JS ---
            const textareaComentarios = document.getElementById('comentarios');
            const charCount = document.getElementById('char_count');

            if (textareaComentarios && charCount) {
                charCount.textContent = textareaComentarios.value.length;
                textareaComentarios.addEventListener('input', function () {
                    charCount.textContent = this.value.length;
                });
            }

            // --- REVISIONES DATATABLE ---
            if ($.fn.DataTable) {
                $('#revisiones_table').DataTable({
                    language: {
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "zeroRecords": "No se encontraron resultados",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                        "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                        "search": "Buscar:",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    responsive: true,
                    ordering: false,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
                    pageLength: 25
                });
            }

        });
    </script>
@endpush