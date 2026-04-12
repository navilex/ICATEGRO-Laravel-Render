@extends('layouts.app')

@section('title', 'Alta de Grupo - ICATEGRO')

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden min-h-[500px] max-w-5xl mx-auto mt-8">
        <!-- Header -->
        <div class="bg-[#d4b996] p-4 text-center">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <span class="bg-gray-800 text-white rounded w-8 h-8 flex items-center justify-center text-xl mr-2">+</span>
                ALTA DE GRUPO
            </h1>
        </div>

        <!-- Form -->
        <div class="p-8">
            <!-- Section Title -->
            <div class="relative mb-8 text-center">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Datos generales</span>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('grupos.store') }}" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Row 1: Tipo servicio, Modalidad CE, Modalidad -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="tipo_servicio" class="block text-red-800 font-bold mb-1">* Tipo de servicio</label>
                        <select name="tipo_servicio" id="tipo_servicio"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="">» SELECCIONE</option>
                            <option value="Extensión" {{ old('tipo_servicio') == 'Extensión' ? 'selected' : '' }}>Extensión
                            </option>
                            <option value="CAE" {{ old('tipo_servicio') == 'CAE' ? 'selected' : '' }}>CAE</option>
                        </select>
                    </div>

                    <div>
                        <label for="modalidad_ce" class="block text-red-800 font-bold mb-1">* Modalidad C.E.</label>
                        <select name="modalidad_ce" id="modalidad_ce"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white disabled:bg-gray-200"
                            disabled>
                            <option value="">» SELECCIONE</option>
                            <option value="Regular" {{ old('modalidad_ce') == 'Regular' ? 'selected' : '' }}>Regular</option>
                            <option value="Asesoría" {{ old('modalidad_ce') == 'Asesoría' ? 'selected' : '' }}>Asesoría
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="modalidad" class="block text-red-800 font-bold mb-1">* Modalidad</label>
                        <select name="modalidad" id="modalidad"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="">» SELECCIONE</option>
                            <option value="Curso" {{ old('modalidad') == 'Curso' ? 'selected' : '' }}>Curso</option>
                            <option value="Curso en línea" {{ old('modalidad') == 'Curso en línea' ? 'selected' : '' }}>Curso
                                en línea</option>
                            <option value="Taller" {{ old('modalidad') == 'Taller' ? 'selected' : '' }}>Taller</option>
                            <option value="Seminario" {{ old('modalidad') == 'Seminario' ? 'selected' : '' }}>Seminario
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Oferta Educativa -->
                <div class="mb-6">
                    <label for="oferta_educativa_id" class="block text-red-800 font-bold mb-1">* Oferta Educativa</label>
                    <select name="oferta_educativa_id" id="oferta_educativa_id"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="">» SELECCIONA LA OFERTA EDUCATIVA</option>
                        @foreach($ofertas as $oferta)
                            <option value="{{ $oferta->id }}" {{ old('oferta_educativa_id') == $oferta->id ? 'selected' : '' }}>
                                {{ $oferta->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Row 3: Campo Formacion -->
                <div class="mb-6">
                    <label for="campo_formacion_id" class="block text-red-800 font-bold mb-1">* Campo de Formación
                        Profesional</label>
                    <select name="campo_formacion_id" id="campo_formacion_id"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required disabled>
                        <option value="">» SELECCIONA EL CAMPO DE FORMACION PROFESIONAL</option>
                    </select>
                    <p id="campo-loading" class="text-xs text-gray-500 mt-1 hidden">Cargando campos...</p>
                </div>

                <!-- Row 4: Especialidad -->
                <div class="mb-6">
                    <label for="especialidad_ocupacional_id" class="block text-red-800 font-bold mb-1">* Especialidad
                        Ocupacional</label>
                    <select name="especialidad_ocupacional_id" id="especialidad_ocupacional_id"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required disabled>
                        <option value="">» SELECCIONA LA ESPECIALIDAD OCUPACIONAL</option>
                    </select>
                    <p id="especialidad-loading" class="text-xs text-gray-500 mt-1 hidden">Cargando especialidades...</p>
                </div>

                <!-- Row 5: Curso -->
                <div class="mb-6">
                    <label for="curso_select" class="block text-red-800 font-bold mb-1">* Curso</label>
                    <select id="curso_select"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required disabled>
                        <option value="">» SELECCIONA EL CURSO</option>
                    </select>
                    <p id="curso-loading" class="text-xs text-gray-500 mt-1 hidden">Cargando cursos...</p>
                    <input type="hidden" name="curso_id" id="curso_id" value="">
                    <input type="hidden" name="curso_icategro_id" id="curso_icategro_id" value="">
                </div>

                <!-- Row 6: Alumnos y Capacidad -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="alumnos_inician" class="block text-red-800 font-bold mb-1">* Alumnos inician</label>
                        <input type="number" name="alumnos_inician" id="alumnos_inician" min="0"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('alumnos_inician', 0) }}">
                    </div>
                    <div>
                        <label for="capacidad_maxima" class="block text-red-800 font-bold mb-1">* Capacidad máxima</label>
                        <input type="number" name="capacidad_maxima" id="capacidad_maxima" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('capacidad_maxima', 0) }}">
                    </div>
                </div>

                <!-- Section Title 2: Fechas, horario y duración del grupo -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Fechas, horario y duración
                            del grupo</span>
                    </div>
                </div>

                <!-- New Rows for Dates & Hours -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div>
                        <label for="fecha_inicio" class="block text-red-800 font-bold mb-1">* Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required value="{{ old('fecha_inicio') }}">
                    </div>
                    <div>
                        <label for="fecha_termino" class="block text-red-800 font-bold mb-1">* Fecha de término</label>
                        <input type="date" name="fecha_termino" id="fecha_termino"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required value="{{ old('fecha_termino') }}">
                    </div>
                    <div>
                        <label for="duracion_dias" class="block text-red-800 font-bold mb-1">* Duración días</label>
                        <input type="number" name="duracion_dias" id="duracion_dias" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('duracion_dias') }}">
                    </div>
                    <div>
                        <label for="duracion_horas" class="block text-red-800 font-bold mb-1">* Duración horas</label>
                        <input type="number" name="duracion_horas" id="duracion_horas" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="0" required value="{{ old('duracion_horas') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="flex flex-col gap-6">
                        <div>
                            <label for="numero_semanas" class="block text-red-800 font-bold mb-1">* Número de semanas del
                                curso</label>
                            <input type="number" name="numero_semanas" id="numero_semanas" min="1"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="0" required value="{{ old('numero_semanas') }}">
                        </div>
                        <div>
                            <label for="numero_horas_semana" class="block text-red-800 font-bold mb-1">* Número de horas por
                                semana</label>
                            <input type="number" name="numero_horas_semana" id="numero_horas_semana" min="1"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="0" required value="{{ old('numero_horas_semana') }}">
                        </div>
                    </div>
                    <div>
                        <label for="horario" class="block text-red-800 font-bold mb-1">* Horario</label>
                        <textarea name="horario" id="horario" rows="4"
                            class="w-full border-2 border-gray-400 rounded-lg p-2 px-4 focus:outline-none focus:border-red-500 bg-white resize-none"
                            required>{{ old('horario') }}</textarea>
                    </div>
                </div>

                <!-- Section Title: Ubicacion del grupo -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Ubicación del grupo</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="plantel_id" class="block text-red-800 font-bold mb-1">* Sede del grupo</label>
                        <select name="plantel_id" id="plantel_id"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="">» SELECCIONE LA SEDE</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}" {{ old('plantel_id') == $sede->id ? 'selected' : '' }}>
                                    {{ $sede->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="estado" class="block text-red-800 font-bold mb-1">* Estado</label>
                        <select name="estado" id="estado"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="{{ Auth::user()->state ?? 'GUERRERO' }}" selected>
                                {{ Auth::user()->state ?? 'GUERRERO' }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="municipio" class="block text-red-800 font-bold mb-1">* Municipio</label>
                    <select name="municipio" id="municipio"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="{{ Auth::user()->municipality ?? 'CHILPANCINGO DE LOS BRAVO' }}" selected>
                            {{ Auth::user()->municipality ?? 'CHILPANCINGO DE LOS BRAVO' }}
                        </option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="localidad" class="block text-red-800 font-bold mb-1">* Localidad</label>
                    <select name="localidad" id="localidad"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="">» SELECCIONA LA LOCALIDAD</option>
                        <option value="CHILPANCINGO" {{ old('localidad') == 'CHILPANCINGO' ? 'selected' : '' }}>CHILPANCINGO
                        </option>
                        <option value="PETAQUILLAS" {{ old('localidad') == 'PETAQUILLAS' ? 'selected' : '' }}>PETAQUILLAS
                        </option>
                        <option value="MAZATLAN" {{ old('localidad') == 'MAZATLAN' ? 'selected' : '' }}>MAZATLAN</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="nombre_espacio" class="block text-red-800 font-bold mb-1">* Nombre del espacio</label>
                    <input type="text" name="nombre_espacio" id="nombre_espacio"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        placeholder="Nombre del espacio" required value="{{ old('nombre_espacio') }}">
                </div>
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Calendario</span>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-red-800 font-bold mb-4">* La información se deberá especificar por semana.</p>
                    <button type="button" id="btn_abrir_modal"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow transition flex items-center">
                        <span class="mr-2">+</span> Agregar
                    </button>
                </div>

                <input type="hidden" name="calendario_data" id="calendario_data" value="[]">

                <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                    <table class="w-full text-sm text-center">
                        <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                            <tr>
                                <th class="py-2 px-2">Opciones</th>
                                <th class="py-2 px-2">Tipo</th>
                                <th class="py-2 px-2">Fecha inicial</th>
                                <th class="py-2 px-2">Fecha final</th>
                                <th class="py-2 px-2">Hora inicial</th>
                                <th class="py-2 px-2">Hora final</th>
                                <th class="py-2 px-2">Total días</th>
                                <th class="py-2 px-2 text-center">Total horas</th>
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

                <!-- Section Title 4: Convenio -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Convenio</span>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="button" id="btn_abrir_modal_convenio"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md border-b-4 border-green-900 flex items-center">
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
                                <th class="py-2 px-2">Nombre</th>
                                <th class="py-2 px-2">Objeto</th>
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
                <!-- Section Title 5: Instructores -->
                <div class="relative mb-8 mt-12 text-center">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md px-8">Instructor(es)</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mb-4">
                    <div>
                        <button type="button" id="btn_abrir_modal_instructor1"
                            class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md border-b-4 border-green-900 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Agregar
                        </button>
                    </div>
                    <div class="flex space-x-8 text-sm font-bold text-gray-700">
                        <div>
                            <p class="mb-1 text-black">Tipo de instructor</p>
                            <p class="text-green-800"><i class="fas fa-file-invoice-dollar mr-1"></i> HONORARIOS</p>
                            <p class="text-red-600"><i class="fas fa-handshake mr-1"></i> SIN PAGO AL INSTRUCTOR</p>
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
                        <thead class="bg-white border-b-2 border-gray-300 font-bold text-black" style="font-size: 0.8rem;">
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

                <!-- Section Title 6: Finanzas -->
                <div class="relative mb-8 mt-12 text-center" id="seccion_finanzas">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md px-8">Finanzas</span>
                    </div>
                </div>

                <div class="mb-8 p-6">
                    <!-- Row 1: Tipo de pago -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="text-left">
                            <label for="tipo_pago_grupo" class="block text-red-800 font-bold mb-1">* Tipo de pago</label>
                            <select id="tipo_pago_grupo" name="tipo_pago_grupo"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                required>
                                <option value="">» SELECCIONE EL TIPO DE PAGO</option>
                                <option value="PAGO POR GRUPO">PAGO POR GRUPO</option>
                                <option value="PAGO POR PERSONA">PAGO POR PERSONA</option>
                                <option value="CONDONACION">CONDONACION</option>
                                <option value="BECA GRUPAL">BECA GRUPAL</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Costos -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-left">
                            <label for="costo_por_persona" class="block text-red-800 font-bold mb-1">* Costo por
                                persona</label>
                            <input type="number" id="costo_por_persona" name="costo_por_persona" step="0.01" min="0"
                                value="0.0"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white disabled:bg-gray-200 calculate-finanzas font-bold"
                                disabled>
                        </div>

                        <div class="text-left">
                            <label for="costo_por_grupo" class="block text-red-800 font-bold mb-1">* Costo por grupo</label>
                            <input type="number" id="costo_por_grupo" name="costo_por_grupo" step="0.01" min="0" value="0.0"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white disabled:bg-gray-200 calculate-finanzas font-bold"
                                disabled>
                        </div>

                        <div class="text-left">
                            <label for="costo_coffee_break" class="block text-red-800 font-bold mb-1">* Costo del
                                coffee-break</label>
                            <input type="number" id="costo_coffee_break" name="costo_coffee_break" step="0.01" min="0"
                                value="0.0"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white calculate-finanzas font-bold">
                        </div>
                    </div>

                    <!-- Row 3: Totales -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-left">
                            <label for="ingreso_total" class="block text-red-800 font-bold mb-1">* Ingreso total del
                                grupo</label>
                            <input type="number" id="ingreso_total" name="ingreso_total" step="0.01" value="0.0"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none bg-white font-bold cursor-not-allowed"
                                readonly>
                        </div>

                        <div class="text-left">
                            <label for="utilidad_grupo" class="block text-red-800 font-bold mb-1">* Utilidad calculada del
                                grupo</label>
                            <input type="number" id="utilidad_grupo" name="utilidad_grupo" step="0.01" value="0.0"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none bg-white font-bold cursor-not-allowed"
                                readonly>
                        </div>
                    </div>
                </div>

        </div>

        <!-- Section Title 7: Archivos -->
        <div class="relative mb-8 mt-12 text-center" id="seccion_archivos">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md px-8">Archivos</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-8 px-4 lg:px-12">
            <!-- Archivo Plan Estudios -->
            <div class="text-left relative">
                <label class="block text-red-800 font-bold mb-2">* Archivo de plan de estudios</label>

                <!-- Default State UI -->
                <div id="ui_plan_default" class="flex items-center space-x-4 mb-2">
                    <label for="archivo_plan_estudios"
                        class="cursor-pointer bg-[#c5a880] hover:bg-[#b09570] text-gray-900 font-bold py-2 px-4 rounded shadow-md transition duration-300 whitespace-nowrap">
                        <i class="fas fa-file-upload mr-2"></i> Agrega archivo
                    </label>
                    <input type="file" id="archivo_plan_estudios" name="archivo_plan_estudios" accept=".xls,.xlsx"
                        class="hidden">
                    <span
                        class="text-gray-600 text-sm font-medium italic truncate max-w-[150px] inline-block align-middle">Sin
                        archivo seleccionado</span>
                </div>

                <!-- Uploaded State UI -->
                <div id="ui_plan_uploaded" class="hidden mb-2">
                    <div class="flex items-start space-x-4">
                        <button type="button" id="btn_delete_plan"
                            class="bg-[#8b0000] hover:bg-red-800 text-white font-bold py-1.5 px-3 rounded shadow-md transition duration-300 flex items-center shrink-0">
                            <i class="fas fa-trash-alt mr-2"></i> Eliminar
                        </button>
                        <div class="flex flex-col">
                            <span id="plan_estudios_name"
                                class="text-gray-800 font-medium text-sm word-break break-all"></span>
                            <span id="plan_estudios_size" class="text-gray-900 font-bold text-sm mt-1"></span>
                        </div>
                    </div>
                </div>

                <!-- Decorative bar -->
                <div class="h-2.5 w-full bg-[#dfcdae] rounded-full mt-2 drop-shadow-sm mb-1"></div>

                <p class="text-xs text-gray-400 mt-2">Formatos válidos: .xls, .xlsx (Máx 8MB)</p>
            </div>

            <!-- Archivo Becas -->
            <div class="text-left relative">
                <label id="lbl_archivo_becas" class="block text-red-800 font-bold mb-2">Archivo de becas del grupo</label>

                <div class="bg-[#f2fbfb] p-3 rounded-lg shadow-sm border border-transparent">
                    <!-- Default State UI -->
                    <div id="ui_becas_default" class="flex items-center space-x-4 mb-2">
                        <label for="archivo_becas"
                            class="cursor-pointer bg-[#c5a880] hover:bg-[#b09570] text-gray-900 font-bold py-2 px-4 rounded shadow-md transition duration-300 whitespace-nowrap">
                            <i class="fas fa-file-upload mr-2"></i> Agrega archivo
                        </label>
                        <input type="file" id="archivo_becas" name="archivo_becas" accept=".pdf" class="hidden">
                        <span
                            class="text-gray-600 text-sm font-medium italic truncate max-w-[150px] inline-block align-middle">Sin
                            archivo seleccionado</span>
                    </div>

                    <!-- Uploaded State UI -->
                    <div id="ui_becas_uploaded" class="hidden mb-2">
                        <div class="flex items-start space-x-4">
                            <button type="button" id="btn_delete_becas"
                                class="bg-[#8b0000] hover:bg-red-800 text-white font-bold py-1.5 px-3 rounded shadow-md transition duration-300 flex items-center shrink-0">
                                <i class="fas fa-trash-alt mr-2"></i> Eliminar
                            </button>
                            <div class="flex flex-col">
                                <span id="becas_name" class="text-gray-800 font-medium text-sm word-break break-all"></span>
                                <span id="becas_size" class="text-gray-900 font-bold text-sm mt-1"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative bar -->
                    <div class="h-2.5 w-full bg-[#dfcdae] rounded-full mt-2 drop-shadow-sm mb-1"></div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Formatos válidos: .pdf (Máx 8MB)</p>
            </div>
        </div>

        <!-- Section Title 8: Comentarios -->
        <div class="relative mb-8 mt-12 text-center" id="seccion_comentarios">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md px-8">Comentarios</span>
            </div>
        </div>

        <div class="mb-4 px-4 lg:px-12">
            <label for="comentarios" class="block text-red-800 font-bold mb-2">Comentarios</label>
            <textarea id="comentarios" name="comentarios" rows="3" maxlength="200"
                class="w-full border border-gray-500 rounded p-3 focus:outline-none focus:border-red-500 bg-white resize-none"
                placeholder=""></textarea>
            <div class="text-right text-xs text-gray-500 mt-1">
                <span id="comentarios_counter">0</span> / 200 caracteres
            </div>
        </div>

        <!-- Submit full width -->
        <div class="-mx-8 -mb-8 p-4 pb-8 px-8 mt-4 bg-[#f2fbfb] border-t border-gray-200">
            <div class="text-right pr-4 lg:pr-12">
                <button type="submit"
                    class="bg-[#2d3748] hover:bg-black text-white px-6 py-2 rounded-md shadow transition duration-300 flex items-center inline-flex">
                    Guardar <i class="fas fa-save ml-2 text-lg"></i>
                </button>
            </div>
        </div>
        </form>
    </div>
    </div>

    <!-- Modal for Calendario -->
    <div id="calendario_modal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-calendar-alt text-blue-400 mr-2 text-2xl"></i>
                    FECHA
                </div>
                <button type="button" id="btn_cerrar_modal_x" class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <div class="mb-4 text-center">
                    <label for="modal_tipo_fecha" class="block text-red-800 font-bold mb-1">* Tipo de fecha</label>
                    <select id="modal_tipo_fecha"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="DÍA">DÍA</option>
                        <option value="SEMANA">SEMANA</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center">
                        <label for="modal_fecha_inicial" class="block text-red-800 font-bold mb-1">* Fecha inicial</label>
                        <input type="date" id="modal_fecha_inicial"
                            class="w-full border-2 border-yellow-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white shadow-[0_0_10px_rgba(250,204,21,0.5)]">
                    </div>
                    <div class="text-center">
                        <label for="modal_fecha_final" class="block text-red-800 font-bold mb-1">* Fecha final</label>
                        <input type="date" id="modal_fecha_final" disabled
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none bg-gray-300 cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center">
                        <label for="modal_hora_inicial" class="block text-red-800 font-bold mb-1">* Hora inicial</label>
                        <input type="time" id="modal_hora_inicial"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white text-center">
                    </div>
                    <div class="text-center">
                        <label for="modal_hora_final" class="block text-red-800 font-bold mb-1">* Hora final</label>
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

    <!-- Modal for Convenios -->
    <div id="convenio_modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-file-contract text-blue-400 mr-2 text-2xl"></i>
                    CONVENIO
                </div>
                <button type="button" id="btn_cerrar_modal_convenio_x"
                    class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <!-- Buscador de Convenios -->
                <div class="mb-4 text-center">
                    <label for="buscar_tipo" class="block text-red-800 font-bold mb-1">* Tipo</label>
                    <select id="buscar_tipo"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="">» VER TODO</option>
                        <option value="MARCO">MARCO</option>
                        <option value="ESPECIFICO">ESPECIFICO</option>
                    </select>
                </div>

                <div class="mb-4 text-center">
                    <label for="buscar_numero" class="block text-red-800 font-bold mb-1">* Número del convenio</label>
                    <input type="text" id="buscar_numero"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                </div>

                <div class="mb-4 text-center">
                    <label for="buscar_nombre" class="block text-red-800 font-bold mb-1">* Nombre del convenio</label>
                    <input type="text" id="buscar_nombre"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                </div>

                <div class="text-center mb-6">
                    <button type="button" id="btn_buscar_convenios"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow text-sm flex items-center mx-auto">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                </div>

                <!-- Resultados Select -->
                <div class="mb-6 text-center">
                    <label for="resultado_convenio" class="block text-red-800 font-bold mb-1">* Convenio</label>
                    <select id="resultado_convenio"
                        class="w-full border-2 border-yellow-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white shadow-[0_0_10px_rgba(250,204,21,0.5)]">
                        <option value="">» SELECCIONA EL CONVENIO</option>
                    </select>
                </div>

                <div class="flex justify-between items-center bg-gray-50 -m-6 p-4 border-t border-gray-200">
                    <button type="button" id="btn_cerrar_modal_convenio"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-times-circle mr-2"></i> Cerrar
                    </button>
                    <button type="button" id="btn_agregar_convenio"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-plus mr-2"></i> Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 1 for Instructores (Search) -->
    <div id="instructor_modal_1"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-chalkboard-teacher text-teal-600 mr-2 text-2xl"></i>
                    INSTRUCTOR
                </div>
                <button type="button" id="btn_cerrar_modal_inst1_x"
                    class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <!-- Buscador de Instructores -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center">
                        <label for="buscar_inst_id" class="block text-red-800 font-bold mb-1">* ID instructor</label>
                        <input type="text" id="buscar_inst_id"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                    </div>
                    <div class="text-center">
                        <label for="buscar_inst_curp" class="block text-red-800 font-bold mb-1">* CURP</label>
                        <input type="text" id="buscar_inst_curp"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            maxlength="18">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="text-center">
                        <label for="buscar_inst_nombre" class="block text-red-800 font-bold mb-1">* Nombre</label>
                        <input type="text" id="buscar_inst_nombre"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                    </div>
                    <div class="text-center">
                        <label for="buscar_inst_ap1" class="block text-red-800 font-bold mb-1">* Apellido 1</label>
                        <input type="text" id="buscar_inst_ap1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                    </div>
                    <div class="text-center">
                        <label for="buscar_inst_ap2" class="block text-red-800 font-bold mb-1">* Apellido 2</label>
                        <input type="text" id="buscar_inst_ap2"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                    </div>
                </div>

                <div class="text-center mb-6 mt-6">
                    <button type="button" id="btn_buscar_instructores"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-8 rounded shadow text-sm flex items-center mx-auto">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                </div>

                <!-- Resultados Select -->
                <div class="mb-6 text-center">
                    <label for="resultado_instructor" class="block text-red-800 font-bold mb-1">* Instructor</label>
                    <select id="resultado_instructor"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="">» SELECCIONA EL INSTRUCTOR</option>
                    </select>
                </div>

                <div class="flex justify-between items-center bg-gray-50 -m-6 p-4 border-t border-gray-200">
                    <button type="button" id="btn_cerrar_modal_inst1"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-times-circle mr-2"></i> Cerrar
                    </button>
                    <button type="button" id="btn_siguiente_inst"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        Siguiente <i class="fas fa-arrow-circle-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 for Instructores (Details) -->
    <div id="instructor_modal_2"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl overflow-hidden relative">
            <div class="bg-white p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center text-gray-700 font-bold text-lg">
                    <i class="fas fa-chalkboard-teacher text-blue-500 mr-2 text-2xl"></i>
                    INSTRUCTOR EN GRUPO
                </div>
                <button type="button" id="btn_cerrar_modal_inst2_x"
                    class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <div class="p-6">
                <!-- Datos fijos del instructor -->
                <div class="grid grid-cols-3 gap-4 border-b border-gray-300 pb-4 mb-4 text-center">
                    <div>
                        <p class="text-red-800 font-bold mb-1">ID instructor</p>
                        <p id="det_inst_id" class="text-gray-700">-</p>
                    </div>
                    <div>
                        <p class="text-red-800 font-bold mb-1">CURP</p>
                        <p id="det_inst_curp" class="text-gray-700 uppercase">-</p>
                    </div>
                    <div>
                        <p class="text-red-800 font-bold mb-1">Nombre</p>
                        <p id="det_inst_nombre" class="text-gray-700 uppercase">-</p>
                    </div>
                    <div></div>
                    <div>
                        <p class="text-red-800 font-bold mb-1">Apellido 1</p>
                        <p id="det_inst_ap1" class="text-gray-700 uppercase">-</p>
                    </div>
                    <div>
                        <p class="text-red-800 font-bold mb-1">Apellido 2</p>
                        <p id="det_inst_ap2" class="text-gray-700 uppercase">-</p>
                    </div>
                </div>

                <!-- Formulario de participacion del grupo -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="text-center">
                        <label for="inst_tipo" class="block text-red-800 font-bold mb-1">* Tipo</label>
                        <select id="inst_tipo"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                            <option value="">» SELECCIONE</option>
                            <option value="HONORARIOS">HONORARIOS</option>
                            <option value="SIN PAGO AL INSTRUCTOR">SIN PAGO AL INSTRUCTOR</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <label for="inst_fecha_inicial" class="block text-red-800 font-bold mb-1">* Fecha de inicio</label>
                        <input type="date" id="inst_fecha_inicial"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                    </div>
                    <div class="text-center">
                        <label for="inst_fecha_final" class="block text-red-800 font-bold mb-1">* Fecha de término</label>
                        <input type="date" id="inst_fecha_final"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4 items-end">
                    <div class="text-center">
                        <label for="inst_duracion_dias" class="block text-red-800 font-bold mb-1">* Duración días</label>
                        <input type="number" id="inst_duracion_dias" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white text-center">
                    </div>
                    <div class="text-center">
                        <label for="inst_duracion_horas" class="block text-red-800 font-bold mb-1">* Duración horas</label>
                        <input type="number" id="inst_duracion_horas" min="1"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white text-center">
                    </div>
                    <div class="text-center">
                        <label for="inst_horario" class="block text-red-800 font-bold mb-1">* Horario</label>
                        <textarea id="inst_horario" rows="1"
                            class="w-full border-2 border-gray-400 rounded-lg p-2 px-4 focus:outline-none focus:border-red-500 bg-white"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="text-center">
                        <label for="inst_pago" class="block text-red-800 font-bold mb-1">* Pago al instructor</label>
                        <input type="number" step="0.01" min="0" id="inst_pago"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white text-center"
                            placeholder="0.0">
                    </div>
                    <div class="text-center">
                        <label for="inst_fecha_pago" class="block text-red-800 font-bold mb-1">* Fecha de pago</label>
                        <input type="date" id="inst_fecha_pago"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                    </div>
                    <div class="text-center">
                        <label for="inst_tipo_pago" class="block text-red-800 font-bold mb-1">* Tipo de pago</label>
                        <select id="inst_tipo_pago"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                            <option value="">» SELECCIONE</option>
                            <option value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option>
                            <option value="CHEQUE">CHEQUE</option>
                            <option value="NO APLICA">NO APLICA</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end items-center bg-gray-50 -m-6 p-4 border-t border-gray-200 space-x-2">
                    <button type="button" id="btn_cerrar_modal_inst2"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-times-circle mr-2"></i> Cerrar
                    </button>
                    <button type="button" id="btn_agregar_instructor"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                        <i class="fas fa-plus mr-2"></i> Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoServicio = document.getElementById('tipo_servicio');
        const modalidadCe = document.getElementById('modalidad_ce');

        const ofertaSelect = document.getElementById('oferta_educativa_id');
        const campoSelect = document.getElementById('campo_formacion_id');
        const especialidadSelect = document.getElementById('especialidad_ocupacional_id');
        const cursoSelect = document.getElementById('curso_select');

        const cursoIdInput = document.getElementById('curso_id');
        const cursoIcategroIdInput = document.getElementById('curso_icategro_id');

        // Toggle Modalidad CE
        tipoServicio.addEventListener('change', function () {
            if (this.value === 'Extensión') {
                modalidadCe.disabled = false;
            } else {
                modalidadCe.disabled = true;
                modalidadCe.value = '';
            }

            // Also refresh cursos if specialization is already selected
            if ($('#especialidad_ocupacional_id').val()) {
                loadCursos($('#especialidad_ocupacional_id').val(), this.value);
            }
        });

        // AJAX for dependent dropdown (Oferta Educativa -> Campo Formacion)
        $('#oferta_educativa_id').on('change', function () {
            var ofertaId = $(this).val();
            var campoDropdown = $('#campo_formacion_id');
            var loadingText = $('#campo-loading');
            var especialidadDropdown = $('#especialidad_ocupacional_id');
            var cursoDropdown = $('#curso_select');

            campoDropdown.empty();
            campoDropdown.append('<option value="">» SELECCIONA EL CAMPO DE FORMACION PROFESIONAL</option>');
            campoDropdown.prop('disabled', true);

            especialidadDropdown.empty();
            especialidadDropdown.append('<option value="">» SELECCIONA LA ESPECIALIDAD OCUPACIONAL</option>');
            especialidadDropdown.prop('disabled', true);

            cursoDropdown.empty();
            cursoDropdown.append('<option value="">» SELECCIONA EL CURSO</option>');
            cursoDropdown.prop('disabled', true);

            if (ofertaId) {
                loadingText.removeClass('hidden');

                $.ajax({
                    url: '/api/campos-by-oferta/' + ofertaId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        loadingText.addClass('hidden');
                        campoDropdown.prop('disabled', false);

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
                        alert('Hubo un error al cargar los campos de formación.');
                    }
                });
            }
        });

        // AJAX for dependent dropdown (Campo Formacion -> Especialidad Ocupacional)
        $('#campo_formacion_id').on('change', function () {
            var campoId = $(this).val();
            var especialidadDropdown = $('#especialidad_ocupacional_id');
            var loadingText = $('#especialidad-loading');
            var cursoDropdown = $('#curso_select');

            especialidadDropdown.empty();
            especialidadDropdown.append('<option value="">» SELECCIONA LA ESPECIALIDAD OCUPACIONAL</option>');
            especialidadDropdown.prop('disabled', true);

            cursoDropdown.empty();
            cursoDropdown.append('<option value="">» SELECCIONA EL CURSO</option>');
            cursoDropdown.prop('disabled', true);

            if (campoId) {
                loadingText.removeClass('hidden');

                $.ajax({
                    url: '/api/especialidades-by-campo/' + campoId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        loadingText.addClass('hidden');
                        especialidadDropdown.prop('disabled', false);

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
                        alert('Hubo un error al cargar las especialidades ocupacionales.');
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

            cursoDropdown.empty();
            cursoDropdown.append('<option value="">» SELECCIONA EL CURSO</option>');
            cursoDropdown.prop('disabled', true);

            if (!especialidadId || !tipoDesc) return;

            const tipo = tipoDesc === 'CAE' ? 'cae' : 'icategro';
            loadingText.removeClass('hidden');

            $.ajax({
                url: '/api/grupos/cursos/' + especialidadId + '/' + tipo,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    loadingText.addClass('hidden');
                    cursoDropdown.prop('disabled', false);

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
                    alert('Hubo un error al cargar los cursos.');
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

        // Date and Duration Validations
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaTermino = document.getElementById('fecha_termino');
        const duracionDias = document.getElementById('duracion_dias');
        const duracionHoras = document.getElementById('duracion_horas');

        // Ensure fecha_termino is >= fecha_inicio
        fechaInicio.addEventListener('change', function () {
            if (this.value) {
                fechaTermino.min = this.value;
                if (fechaTermino.value && fechaTermino.value < this.value) {
                    fechaTermino.value = this.value;
                }
            } else {
                fechaTermino.min = '';
            }
        });

        fechaTermino.addEventListener('change', function () {
            if (fechaInicio.value && this.value < fechaInicio.value) {
                alert('La fecha de término no puede ser anterior a la fecha de inicio.');
                this.value = fechaInicio.value;
            }
        });

        // Ensure duracion_horas <= duracion_dias * 24
        duracionHoras.addEventListener('change', function () {
            const dias = parseInt(duracionDias.value) || 0;
            const maxHoras = dias * 24;

            if (dias > 0 && this.value > maxHoras) {
                alert(`Las horas no pueden exceder el total de horas en ${dias} días (${maxHoras} horas).`);
                this.value = maxHoras;
            }
        });

        duracionDias.addEventListener('change', function () {
            const dias = parseInt(this.value) || 0;
            const maxHoras = dias * 24;
            const horasActuales = parseInt(duracionHoras.value) || 0;

            if (horasActuales > maxHoras) {
                duracionHoras.value = maxHoras;
            }
        });
        // Calendario Logic
        let calendarioData = [];
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
        const formSubmitBtn = document.querySelector('form button[type="submit"]');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            // reset form
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
                modFechaFinal.disabled = true;
                modFechaFinal.value = '';
                modFechaFinal.classList.add('bg-gray-300', 'cursor-not-allowed');
                modFechaFinal.classList.remove('border-yellow-400', 'shadow-[0_0_10px_rgba(250,204,21,0.5)]');
                modFechaInicial.classList.add('border-yellow-400', 'shadow-[0_0_10px_rgba(250,204,21,0.5)]');
            } else {
                modFechaFinal.disabled = false;
                modFechaFinal.classList.remove('bg-gray-300', 'cursor-not-allowed');
                modFechaFinal.classList.add('border-yellow-400', 'shadow-[0_0_10px_rgba(250,204,21,0.5)]');
            }
        });

        // Validation for date ranges inside modal
        modFechaInicial.addEventListener('change', function () {
            if (tipoFecha.value === 'SEMANA' && this.value) {
                modFechaFinal.min = this.value;
                if (modFechaFinal.value && modFechaFinal.value < this.value) {
                    modFechaFinal.value = this.value;
                }
            }
        });

        modFechaFinal.addEventListener('change', function () {
            if (modFechaInicial.value && this.value < modFechaInicial.value) {
                alert('La fecha final no puede ser anterior a la inicial.');
                this.value = modFechaInicial.value;
            }
        });

        // Time Validation inside modal
        modHoraFinal.addEventListener('change', function () {
            if (modHoraInicial.value && this.value <= modHoraInicial.value) {
                alert('La hora final debe ser posterior a la inicial.');
                this.value = '';
            }
        });

        btnAgregarFecha.addEventListener('click', function () {
            // Retrieve max values from group configuration
            const maxDiasGlobal = parseInt(duracionDias.value) || 0;
            const maxHorasGlobal = parseInt(duracionHoras.value) || 0;
            const globalFechaInicio = fechaInicio.value;
            const globalFechaTermino = fechaTermino.value;

            if (!globalFechaInicio || !globalFechaTermino || maxDiasGlobal <= 0 || maxHorasGlobal <= 0) {
                alert('Por favor complete primero los datos de fechas, horarios y duración del grupo en la sección superior.');
                return;
            }

            // Input Validate missing fields
            if (!modFechaInicial.value || !modHoraInicial.value || !modHoraFinal.value) {
                alert('Complete todos los campos requeridos (Fechas y Horas).');
                return;
            }
            if (tipoFecha.value === 'SEMANA' && !modFechaFinal.value) {
                alert('Complete la fecha final para modalidad SEMANA.');
                return;
            }

            // Validating ranges against global constraints
            if (modFechaInicial.value < globalFechaInicio || (modFechaFinal.value && modFechaFinal.value > globalFechaTermino) || (tipoFecha.value === 'DÍA' && modFechaInicial.value > globalFechaTermino)) {
                alert('Las fechas ingresadas exceden el rango global del grupo (' + globalFechaInicio + ' a ' + globalFechaTermino + ').');
                return;
            }

            // Calculate current sum
            let currentSumaDias = 0;
            let currentSumaHoras = 0;
            calendarioData.forEach(item => {
                currentSumaDias += item.total_dias;
                currentSumaHoras += parseFloat(item.total_horas);
            });

            // Calculate this entry
            let mDias = 1;
            if (tipoFecha.value === 'SEMANA') {
                const f1 = new Date(modFechaInicial.value);
                const f2 = new Date(modFechaFinal.value);
                const diffTime = Math.abs(f2 - f1);
                mDias = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Inclusive
            }

            const h1 = modHoraInicial.value.split(':');
            const h2 = modHoraFinal.value.split(':');
            const ms1 = (parseInt(h1[0]) * 60) + parseInt(h1[1]);
            const ms2 = (parseInt(h2[0]) * 60) + parseInt(h2[1]);
            let diffHours = (ms2 - ms1) / 60;

            // Si es por semana se multiplica la duración en horas por la cantidad de dias.
            let totalHoras = diffHours * mDias;

            if ((currentSumaDias + mDias) > maxDiasGlobal) {
                alert('No se puede agregar. Excede la duración total en días (' + maxDiasGlobal + ')');
                return;
            }

            if ((currentSumaHoras + totalHoras) > maxHorasGlobal) {
                alert('No se puede agregar. Excede la duración total en horas (' + maxHorasGlobal + ')');
                return;
            }

            // Passed all validations, add to array
            const newRecord = {
                id: Date.now(),
                tipo_fecha: tipoFecha.value,
                fecha_inicial: modFechaInicial.value,
                fecha_final: modFechaFinal.value,
                hora_inicial: modHoraInicial.value,
                hora_final: modHoraFinal.value,
                total_dias: mDias,
                total_horas: totalHoras.toFixed(2)
            };

            calendarioData.push(newRecord);
            updateTable();
            closeModal();
        });

        // Global Delete function
        window.deleteCalendarioItem = function (id) {
            calendarioData = calendarioData.filter(item => item.id !== id);
            updateTable();
        };

        function formatFecha(fechaStr) {
            if (!fechaStr) return '';
            const p = fechaStr.split('-');
            return `${p[2]}/${p[1]}/${p[0]}`;
        }

        function updateTable() {
            tbody.innerHTML = '';
            inputData.value = JSON.stringify(calendarioData);

            if (calendarioData.length === 0) {
                tbody.innerHTML = '<tr id="empty_row"><td colspan="8" class="py-4 text-gray-500 bg-gray-50 border-b">No hay datos disponibles en la tabla</td></tr>';
                return;
            }

            calendarioData.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-200 hover:bg-gray-100';
                tr.innerHTML = `
                    <td class="py-2 px-2">${item.tipo_fecha}</td>
                    <td class="py-2 px-2">${formatFecha(item.fecha_inicial)}</td>
                    <td class="py-2 px-2">${formatFecha(item.fecha_final)}</td>
                    <td class="py-2 px-2">${item.hora_inicial}</td>
                    <td class="py-2 px-2">${item.hora_final}</td>
                    <td class="py-2 px-2">${item.total_dias}</td>
                    <td class="py-2 px-2">${item.total_horas}</td>
                    <td class="py-2 px-2 text-center text-xl">
                        <button type="button" class="text-red-500 hover:text-red-700 mr-2" onclick="deleteCalendarioItem(${item.id})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <i class="fas fa-calendar-alt text-blue-500 cursor-pointer"></i>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Convenios Logic
        let conveniosData = [];
        const btnAbrirModalConvenio = document.getElementById('btn_abrir_modal_convenio');
        const modalConvenio = document.getElementById('convenio_modal');
        const btnCerrarModalConvenio = document.getElementById('btn_cerrar_modal_convenio');
        const btnCerrarModalConvenioX = document.getElementById('btn_cerrar_modal_convenio_x');
        const btnBuscarConvenios = document.getElementById('btn_buscar_convenios');
        const btnAgregarConvenio = document.getElementById('btn_agregar_convenio');

        const buscarTipo = document.getElementById('buscar_tipo');
        const buscarNumero = document.getElementById('buscar_numero');
        const buscarNombre = document.getElementById('buscar_nombre');
        const resultadoConvenio = document.getElementById('resultado_convenio');

        const tbodyConvenios = document.getElementById('convenios_tbody');
        const inputConveniosData = document.getElementById('convenios_data');

        function openModalConvenio() {
            modalConvenio.classList.remove('hidden');
        }

        function closeModalConvenio() {
            modalConvenio.classList.add('hidden');
            buscarTipo.value = '';
            buscarNumero.value = '';
            buscarNombre.value = '';
            resultadoConvenio.innerHTML = '<option value="">» SELECCIONA EL CONVENIO</option>';
        }

        btnAbrirModalConvenio.addEventListener('click', openModalConvenio);
        btnCerrarModalConvenio.addEventListener('click', closeModalConvenio);
        btnCerrarModalConvenioX.addEventListener('click', closeModalConvenio);

        // AJAX Search
        btnBuscarConvenios.addEventListener('click', function () {
            const params = new URLSearchParams();
            if (buscarTipo.value) params.append('tipo', buscarTipo.value);
            if (buscarNumero.value) params.append('numero', buscarNumero.value);
            if (buscarNombre.value) params.append('nombre', buscarNombre.value);

            btnBuscarConvenios.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Buscando...';
            btnBuscarConvenios.disabled = true;

            fetch(`/api/convenios/search?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    btnBuscarConvenios.innerHTML = '<i class="fas fa-search mr-2"></i> Buscar';
                    btnBuscarConvenios.disabled = false;

                    resultadoConvenio.innerHTML = '<option value="">» SELECCIONA EL CONVENIO</option>';
                    if (data.length === 0) {
                        alert('No se encontraron convenios con esos criterios.');
                        return;
                    }

                    data.forEach(conv => {
                        const option = document.createElement('option');
                        // Storing the full object as stringified JSON in the value so we can extract it easily.
                        // For the UI we just need the ID to sync in Laravel.
                        option.value = conv.id;
                        // To extract the text data without an extra fetch, we rely on datasets
                        option.dataset.numero = conv.number;
                        option.dataset.nombre = conv.name;
                        // For 'Tipo' and 'Objeto' which aren't fully exposed right now, we will fallback or you can expand the controller. Let's use the search inputs as mock or fetch full.
                        // Currently search endpoint only returns id, number, name. We will extract them.
                        option.dataset.tipo = buscarTipo.value || 'ESPECIFICO'; // Placeholder based on search since the model has it
                        option.dataset.objeto = 'Ver detalles'; // Placeholder since it's not in the optimized search API yet. Update controller if exact matching is needed.
                        option.textContent = `${conv.number} - ${conv.name}`;
                        resultadoConvenio.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching convenios:', error);
                    btnBuscarConvenios.innerHTML = '<i class="fas fa-search mr-2"></i> Buscar';
                    btnBuscarConvenios.disabled = false;
                    alert('Error de conexión al buscar convenios.');
                });
        });

        btnAgregarConvenio.addEventListener('click', function () {
            const selectedOption = resultadoConvenio.options[resultadoConvenio.selectedIndex];
            if (!selectedOption.value) {
                alert('Por favor selecciona un convenio de la lista.');
                return;
            }

            const isDuplicate = conveniosData.some(c => c === parseInt(selectedOption.value));
            if (isDuplicate) {
                alert('Este convenio ya fue agregado a la lista.');
                return;
            }

            // In Laravels sync we only realistically need the IDs array to save
            conveniosData.push(parseInt(selectedOption.value));

            // To render the table we append a row manually
            const tr = document.createElement('tr');
            tr.className = 'border-b border-gray-200 hover:bg-gray-100';
            tr.dataset.id = selectedOption.value;
            tr.innerHTML = `
                <td class="py-2 px-2 text-center text-xl">
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="deleteConvenioItem(${selectedOption.value})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
                <td class="py-2 px-2">${selectedOption.dataset.tipo}</td>
                <td class="py-2 px-2">${selectedOption.dataset.numero}</td>
                <td class="py-2 px-2">${selectedOption.dataset.nombre}</td>
                <td class="py-2 px-2">${selectedOption.dataset.objeto}</td>
            `;

            // Remove empty message if present
            const emptyRow = document.getElementById('empty_row_convenios');
            if (emptyRow) {
                emptyRow.remove();
            }

            tbodyConvenios.appendChild(tr);
            inputConveniosData.value = JSON.stringify(conveniosData);
            closeModalConvenio();
        });

        window.deleteConvenioItem = function (id) {
            conveniosData = conveniosData.filter(item => item !== id);
            inputConveniosData.value = JSON.stringify(conveniosData);

            // Remove row from DOM
            const tr = tbodyConvenios.querySelector(`tr[data-id="${id}"]`);
            if (tr) {
                tr.remove();
            }

            if (conveniosData.length === 0) {
                tbodyConvenios.innerHTML = '<tr id="empty_row_convenios"><td colspan="5" class="py-4 text-gray-500 bg-gray-50 border-b">No hay datos disponibles en la tabla</td></tr>';
            }
        };

        // --- INSTRUCTOR LOGIC ---
        const modalInstructor1 = document.getElementById('instructor_modal_1');
        const modalInstructor2 = document.getElementById('instructor_modal_2');
        const btnAbrirInst1 = document.getElementById('btn_abrir_modal_instructor1');
        const btnCerrarInst1 = document.getElementById('btn_cerrar_modal_inst1');
        const btnCerrarInst1x = document.getElementById('btn_cerrar_modal_inst1_x');
        const btnCerrarInst2 = document.getElementById('btn_cerrar_modal_inst2');
        const btnCerrarInst2x = document.getElementById('btn_cerrar_modal_inst2_x');
        const btnBuscarInst = document.getElementById('btn_buscar_instructores');
        const btnSiguienteInst = document.getElementById('btn_siguiente_inst');
        const btnAgregarInst = document.getElementById('btn_agregar_instructor');

        const instTipo = document.getElementById('inst_tipo');
        const instPago = document.getElementById('inst_pago');
        const instFechaPago = document.getElementById('inst_fecha_pago');
        const instTipoPago = document.getElementById('inst_tipo_pago');
        const tbodyInstructores = document.getElementById('instructores_tbody');
        const inputInstructoresData = document.getElementById('instructores_data');
        let instructoresData = [];

        function openModalInst1() {
            // Validation: Check if dates and durations are filled in main form
            const fInicial = document.getElementById('fecha_inicio').value;
            const fFinal = document.getElementById('fecha_termino').value;
            const dDias = document.getElementById('duracion_dias').value;
            const dHoras = document.getElementById('duracion_horas').value;

            if (!fInicial || !fFinal || !dDias || !dHoras) {
                alert("DEBE AGREGAR LA DURACIÓN EN DÍAS, HORAS Y LAS FECHAS PRINCIPALES DEL GRUPO PARA PODER AGREGAR INSTRUCTORES.");
                return;
            }

            modalInstructor1.classList.remove('hidden');
        }

        function closeModalInst1() {
            modalInstructor1.classList.add('hidden');
            document.getElementById('buscar_inst_id').value = '';
            document.getElementById('buscar_inst_curp').value = '';
            document.getElementById('buscar_inst_nombre').value = '';
            document.getElementById('buscar_inst_ap1').value = '';
            document.getElementById('buscar_inst_ap2').value = '';
            document.getElementById('resultado_instructor').innerHTML = '<option value="">» SELECCIONA EL INSTRUCTOR</option>';
        }

        function closeModalInst2() {
            modalInstructor2.classList.add('hidden');
            // reset form components
            instTipo.value = '';
            document.getElementById('inst_fecha_inicial').value = '';
            document.getElementById('inst_fecha_final').value = '';
            document.getElementById('inst_duracion_dias').value = '';
            document.getElementById('inst_duracion_horas').value = '';
            document.getElementById('inst_horario').value = '';
            instPago.value = '';
            instFechaPago.value = '';
            instTipoPago.value = '';
            instPago.disabled = false;
            instFechaPago.disabled = false;
            instTipoPago.disabled = false;
        }

        btnAbrirInst1.addEventListener('click', openModalInst1);
        btnCerrarInst1.addEventListener('click', closeModalInst1);
        btnCerrarInst1x.addEventListener('click', closeModalInst1);
        btnCerrarInst2.addEventListener('click', closeModalInst2);
        btnCerrarInst2x.addEventListener('click', closeModalInst2);

        btnBuscarInst.addEventListener('click', function () {
            const id = document.getElementById('buscar_inst_id').value;
            const curp = document.getElementById('buscar_inst_curp').value;
            const nombre = document.getElementById('buscar_inst_nombre').value;
            const ap1 = document.getElementById('buscar_inst_ap1').value;
            const ap2 = document.getElementById('buscar_inst_ap2').value;

            const params = new URLSearchParams();
            if (id) params.append('id', id);
            if (curp) params.append('curp', curp);
            if (nombre) params.append('nombre', nombre);
            if (ap1) params.append('apellido_1', ap1);
            if (ap2) params.append('apellido_2', ap2);

            fetch(`/api/instructores/search?${params.toString()}`)
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('resultado_instructor');
                    select.innerHTML = '<option value="">» SELECCIONA EL INSTRUCTOR</option>';
                    if (data.length === 0) {
                        alert("No se encontraron instructores con esos datos.");
                        return;
                    }
                    data.forEach(inst => {
                        const opt = document.createElement('option');
                        opt.value = inst.id;
                        opt.textContent = `${inst.nombre} ${inst.apellido_1} ${inst.apellido_2}`;
                        opt.dataset.curp = inst.curp;
                        opt.dataset.nombre = inst.nombre;
                        opt.dataset.ap1 = inst.apellido_1;
                        opt.dataset.ap2 = inst.apellido_2;
                        select.appendChild(opt);
                    });
                })
                .catch(err => alert("Error interno al buscar instructores."));
        });

        btnSiguienteInst.addEventListener('click', function () {
            const select = document.getElementById('resultado_instructor');
            const opt = select.options[select.selectedIndex];
            if (!opt.value) {
                alert("Por favor selecciona un instructor de los resultados.");
                return;
            }

            // Fill header in Modal 2
            document.getElementById('det_inst_id').textContent = opt.value;
            document.getElementById('det_inst_curp').textContent = opt.dataset.curp;
            document.getElementById('det_inst_nombre').textContent = opt.dataset.nombre;
            document.getElementById('det_inst_ap1').textContent = opt.dataset.ap1;
            document.getElementById('det_inst_ap2').textContent = opt.dataset.ap2;

            // Load group dates pre-filled
            document.getElementById('inst_fecha_inicial').value = document.getElementById('fecha_inicio').value;
            document.getElementById('inst_fecha_final').value = document.getElementById('fecha_termino').value;
            document.getElementById('inst_duracion_dias').value = document.getElementById('duracion_dias').value;
            document.getElementById('inst_duracion_horas').value = document.getElementById('duracion_horas').value;

            closeModalInst1();
            modalInstructor2.classList.remove('hidden');
        });

        // Toggling disabled based on type of instructor
        instTipo.addEventListener('change', function () {
            if (this.value === 'SIN PAGO AL INSTRUCTOR') {
                instPago.disabled = true;
                instFechaPago.disabled = true;
                instTipoPago.disabled = true;
                instPago.value = '0';
                instFechaPago.value = '';
                instTipoPago.value = 'NO APLICA';
            } else {
                instPago.disabled = false;
                instFechaPago.disabled = false;
                instTipoPago.disabled = false;
            }
        });

        btnAgregarInst.addEventListener('click', function () {
            const idInst = document.getElementById('det_inst_id').textContent;

            // Validate required fields explicitly
            const reqs = [
                'inst_tipo', 'inst_fecha_inicial', 'inst_fecha_final',
                'inst_duracion_dias', 'inst_duracion_horas', 'inst_horario'
            ];

            // If HONORARIOS, validate payout
            if (instTipo.value === 'HONORARIOS') {
                reqs.push('inst_pago', 'inst_fecha_pago', 'inst_tipo_pago');
            }

            let valid = true;
            reqs.forEach(req => {
                if (!document.getElementById(req).value) valid = false;
            });

            if (!valid) {
                alert("Por favor complete todos los datos obligatorios con (*).");
                return;
            }

            // Check array for uniqueness
            const isDup = instructoresData.some(i => i.instructor_id == idInst);
            if (isDup) {
                alert("El instructor ya ha sido agregado.");
                return;
            }

            // Validating Group Bounds Constraints
            const formFI = new Date(document.getElementById('fecha_inicio').value);
            const formFF = new Date(document.getElementById('fecha_termino').value);
            const gDias = parseInt(document.getElementById('duracion_dias').value);
            const gHoras = parseInt(document.getElementById('duracion_horas').value);

            const instFI = new Date(document.getElementById('inst_fecha_inicial').value);
            const instFF = new Date(document.getElementById('inst_fecha_final').value);
            const instDias = parseInt(document.getElementById('inst_duracion_dias').value);
            const instHoras = parseInt(document.getElementById('inst_duracion_horas').value);

            if (instFI < formFI || instFF > formFF) {
                alert("ATENCIÓN: Las fechas asignadas al instructor exceden la fecha de inicio/término del GRUPO.");
                return;
            }
            if (instDias > gDias || instHoras > gHoras) {
                alert("ATENCIÓN: La duración (días/horas) del instructor excede los topes estipulados por el GRUPO.");
                return;
            }

            // Compose object
            const instObj = {
                instructor_id: idInst,
                tipo: instTipo.value,
                fecha_inicio: document.getElementById('inst_fecha_inicial').value,
                fecha_termino: document.getElementById('inst_fecha_final').value,
                duracion_dias: instDias,
                duracion_horas: instHoras,
                horario: document.getElementById('inst_horario').value,
                pago_instructor: instPago.value ? parseFloat(instPago.value) : null,
                fecha_pago: document.getElementById('inst_fecha_pago').value || null,
                tipo_pago: instTipoPago.value || null
            };

            instructoresData.push(instObj);

            // Print Row
            const tr = document.createElement('tr');
            tr.dataset.id = idInst;
            tr.className = 'border-b border-gray-200 hover:bg-gray-100 text-xs';

            // Icon sets
            let instIcon = instObj.tipo === 'HONORARIOS' ? '<i class="fas fa-file-invoice-dollar text-green-800 text-lg"></i>' : '<i class="fas fa-handshake text-red-600 text-lg"></i>';
            let pagoIcon = '';
            if (instObj.tipo_pago === 'TRANSFERENCIA BANCARIA') pagoIcon = '<i class="fas fa-credit-card text-blue-600 text-lg"></i>';
            else if (instObj.tipo_pago === 'CHEQUE') pagoIcon = '<i class="fas fa-money-check-alt text-green-600 text-lg"></i>';
            else if (instObj.tipo_pago === 'NO APLICA') pagoIcon = '<i class="fas fa-ban text-red-500 text-lg"></i>';

            tr.innerHTML = `
                <td class="py-2 px-1 space-x-1">
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="deleteInstructorItem(${idInst})"><i class="fas fa-trash-alt"></i></button>
                    ${ /* TODO Instructor Route dynamically if they have permission */ ''}
                    <a href="/instructores/${idInst}" target="_blank" class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                </td>
                <td class="py-2 px-1">${idInst}</td>
                <td class="py-2 px-1">${document.getElementById('det_inst_nombre').textContent}</td>
                <td class="py-2 px-1">${document.getElementById('det_inst_ap1').textContent}</td>
                <td class="py-2 px-1">${document.getElementById('det_inst_ap2').textContent}</td>
                <td class="py-2 px-1" title="${instObj.tipo}">${instIcon}</td>
                <td class="py-2 px-1">${instObj.pago_instructor || '-'}</td>
                <td class="py-2 px-1">${instObj.fecha_inicio.split('-').reverse().join('/')}</td>
                <td class="py-2 px-1">${instObj.fecha_termino.split('-').reverse().join('/')}</td>
                <td class="py-2 px-1">${instObj.duracion_horas}</td>
                <td class="py-2 px-1">${instObj.duracion_dias}</td>
                <td class="py-2 px-1 whitespace-pre-line text-left leading-tight">${instObj.horario}</td>
                <td class="py-2 px-1">${instObj.fecha_pago ? instObj.fecha_pago.split('-').reverse().join('/') : '-'}</td>
                <td class="py-2 px-1" title="${instObj.tipo_pago || ''}">${pagoIcon}</td>
            `;

            const emptyRow = document.getElementById('empty_row_instructores');
            if (emptyRow) emptyRow.remove();

            tbodyInstructores.appendChild(tr);
            inputInstructoresData.value = JSON.stringify(instructoresData);
            closeModalInst2();
        });

        window.deleteInstructorItem = function (id) {
            instructoresData = instructoresData.filter(i => parseInt(i.instructor_id) !== parseInt(id));
            inputInstructoresData.value = JSON.stringify(instructoresData);
            const row = tbodyInstructores.querySelector(`tr[data-id="${id}"]`);
            if (row) row.remove();

            if (instructoresData.length === 0) {
                tbodyInstructores.innerHTML = '<tr id="empty_row_instructores"><td colspan="14" class="py-4 text-gray-500 bg-gray-50 border-b">No hay instructores asignados a este grupo</td></tr>';
            }
        };

        // --- FINANZAS LOGIC ---
        const tipoPagoSelect = document.getElementById('tipo_pago_grupo');
        const costoPersonaInput = document.getElementById('costo_por_persona');
        const costoGrupoInput = document.getElementById('costo_por_grupo');
        const costoCoffeeInput = document.getElementById('costo_coffee_break');
        const ingresoTotalInput = document.getElementById('ingreso_total');
        const utilidadGrupoInput = document.getElementById('utilidad_grupo');
        const alumnosInicianInput = document.getElementById('alumnos_inician');

        function calcularFinanzas() {
            let ingresos = 0;
            let egresos = 0;
            const tipoPago = tipoPagoSelect.value;
            const alumnos = parseFloat(alumnosInicianInput.value) || 0;
            const costoPersona = parseFloat(costoPersonaInput.value) || 0;
            const costoGrupo = parseFloat(costoGrupoInput.value) || 0;
            const costoCoffee = parseFloat(costoCoffeeInput.value) || 0;

            // 1. Calcular Ingresos
            if (tipoPago === 'PAGO POR PERSONA') {
                ingresos = alumnos * costoPersona;
            } else if (tipoPago === 'PAGO POR GRUPO') {
                ingresos = costoGrupo;
            } else if (tipoPago === 'CONDONACION' || tipoPago === 'BECA GRUPAL') {
                ingresos = 0;
            }

            ingresoTotalInput.value = ingresos.toFixed(2);

            // 2. Calcular Egresos (Coffee Break + Suma Honorarios Instructores)
            let sumaHonorarios = 0;
            instructoresData.forEach(inst => {
                if (inst.tipo === 'HONORARIOS' && inst.pago_instructor) {
                    sumaHonorarios += parseFloat(inst.pago_instructor);
                }
            });

            egresos = costoCoffee + sumaHonorarios;

            // 3. Utilidad
            const utilidad = ingresos - egresos;
            utilidadGrupoInput.value = utilidad.toFixed(2);
        }

        function evaluarTipoPagoGrupo() {
            const tipo = tipoPagoSelect.value;

            // Disable everything initially 
            costoPersonaInput.disabled = true;
            costoGrupoInput.disabled = true;

            if (tipo === 'PAGO POR PERSONA') {
                costoPersonaInput.disabled = false;
                costoGrupoInput.value = '0.00';
            } else if (tipo === 'PAGO POR GRUPO') {
                costoGrupoInput.disabled = false;
                costoPersonaInput.value = '0.00';
            } else {
                // BECA GRUPAL y CONDONACION
                costoPersonaInput.value = '0.00';
                costoGrupoInput.value = '0.00';
            }

            calcularFinanzas();
        }

        tipoPagoSelect.addEventListener('change', evaluarTipoPagoGrupo);
        costoPersonaInput.addEventListener('input', calcularFinanzas);
        costoGrupoInput.addEventListener('input', calcularFinanzas);
        costoCoffeeInput.addEventListener('input', calcularFinanzas);
        alumnosInicianInput.addEventListener('input', calcularFinanzas);

        // Inject hook onto btnAgregarInst 
        const btnAgInstFin = document.getElementById('btn_agregar_instructor');
        if (btnAgInstFin) {
            btnAgInstFin.addEventListener('click', () => { setTimeout(calcularFinanzas, 50); });
        }

        // Inject hook onto window.deleteInstructorItem
        const oldDelInst = window.deleteInstructorItem;
        window.deleteInstructorItem = function (id) {
            oldDelInst(id);
            calcularFinanzas();
        };

        // --- ARCHIVOS Y COMENTARIOS LOGIC ---
        // Helper function to format bytes
        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        }

        // Logic for Plan de Estudios
        const filePlanList = document.getElementById('archivo_plan_estudios');
        const uiPlanDefault = document.getElementById('ui_plan_default');
        const uiPlanUploaded = document.getElementById('ui_plan_uploaded');
        const planNameLabel = document.getElementById('plan_estudios_name');
        const planSizeLabel = document.getElementById('plan_estudios_size');
        const btnDeletePlan = document.getElementById('btn_delete_plan');

        if (filePlanList) {
            filePlanList.addEventListener('change', function (e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    planNameLabel.textContent = file.name;
                    planSizeLabel.textContent = formatBytes(file.size);

                    uiPlanDefault.classList.add('hidden');
                    uiPlanUploaded.classList.remove('hidden');
                } else {
                    // Should not happen via OS dialog cancel, but just in case
                    uiPlanUploaded.classList.add('hidden');
                    uiPlanDefault.classList.remove('hidden');
                }
            });

            btnDeletePlan.addEventListener('click', function () {
                filePlanList.value = ''; // Clear the input
                uiPlanUploaded.classList.add('hidden');
                uiPlanDefault.classList.remove('hidden');
            });
        }

        // Logic for Becas
        const fileBecassList = document.getElementById('archivo_becas');
        const uiBecasDefault = document.getElementById('ui_becas_default');
        const uiBecasUploaded = document.getElementById('ui_becas_uploaded');
        const becasNameLabel = document.getElementById('becas_name');
        const becasSizeLabel = document.getElementById('becas_size');
        const btnDeleteBecas = document.getElementById('btn_delete_becas');

        if (fileBecassList) {
            fileBecassList.addEventListener('change', function (e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    becasNameLabel.textContent = file.name;
                    becasSizeLabel.textContent = formatBytes(file.size);

                    uiBecasDefault.classList.add('hidden');
                    uiBecasUploaded.classList.remove('hidden');
                } else {
                    uiBecasUploaded.classList.add('hidden');
                    uiBecasDefault.classList.remove('hidden');
                }
            });

            btnDeleteBecas.addEventListener('click', function () {
                fileBecassList.value = ''; // Clear the input
                uiBecasUploaded.classList.add('hidden');
                uiBecasDefault.classList.remove('hidden');
            });
        }

        // Toggle Required class & state for Archivos Beca based on Tipo Pago select
        const lblArchivoBecas = document.getElementById('lbl_archivo_becas');
        function evaluarBecasRequired() {
            if (tipoPagoSelect.value === 'BECA GRUPAL') {
                lblArchivoBecas.textContent = '* Archivo de becas del grupo';
            } else {
                lblArchivoBecas.textContent = 'Archivo de becas del grupo';
            }
        }
        // We append our `evaluarBecasRequired` execution into the existing select change listener
        tipoPagoSelect.addEventListener('change', evaluarBecasRequired);
        // initial evaluation
        evaluarBecasRequired();

        // Comentarios Counter
        const comentariosInput = document.getElementById('comentarios');
        const comentariosCounter = document.getElementById('comentarios_counter');
        if (comentariosInput && comentariosCounter) {
            comentariosInput.addEventListener('input', function (e) {
                comentariosCounter.textContent = e.target.value.length;
            });
        }

        // Intercept form submission to prevent empty calendar
        document.querySelector('form').addEventListener('submit', function (e) {
            if (calendarioData.length === 0) {
                e.preventDefault();
                alert('El grupo no puede guardarse sin un calendario (añada al menos una fecha).');
            }
        });
    });
</script>