@extends('layouts.app')

@section('title', 'Alta de Alumnos - ICATEGRO')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl text-sm">
        <!-- Header ALTA DE ALUMNOS EN GRUPO -->
        <div class="bg-[#d4b996] p-4 text-center">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <i class="fas fa-plus-square mr-3 text-gray-800"></i>
                ALTA DE ALUMNOS EN GRUPO
            </h1>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-10 mb-8 border border-gray-200">
            <!-- Section 1: Registro -->
            <div class="relative mb-8 text-center mt-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span
                        class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Registro</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Estatus del grupo</label>
                    <div
                        class="w-full md:w-3/4 border border-gray-500 rounded-full p-2 px-4 bg-gray-50 font-bold text-gray-800 flex items-center shadow-inner uppercase select-none">
                        <span class="w-4 h-4 rounded-full mr-2 shadow-sm inline-block
                                @if(strtoupper($grupo->estatus) == 'PENDIENTE') bg-yellow-500 
                                @elseif(strtoupper($grupo->estatus) == 'AUTORIZADO') bg-green-600 
                                @elseif(strtoupper($grupo->estatus) == 'PROCESO' || strtoupper($grupo->estatus) == 'PROCESS') bg-blue-500 
                                @elseif(strtoupper($grupo->estatus) == 'CONCLUIDO') bg-purple-700 
                                @elseif(strtoupper($grupo->estatus) == 'RECHAZADO') bg-red-600 
                                @else bg-gray-500 @endif
                            "></span>
                        <span class="uppercase font-extrabold">{{ $grupo->estatus }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1 uppercase">Plantel</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->plantel->name ?? 'N/A' }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1 uppercase">Director:</label>
                    <div class="w-full font-bold text-gray-700 uppercase">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Usuario registró</label>
                    <div class="w-full font-bold text-gray-700 uppercase">
                        @if($grupo->creador)
                            {{ $grupo->creador->name }} {{ $grupo->creador->lastname }} {{ $grupo->creador->lastname2 }}
                        @else
                            ADMINISTRADOR / SISTEMA
                        @endif
                    </div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha de registro</label>
                    <div class="w-full font-bold text-gray-700 uppercase">
                        {{ $grupo->created_at->format('d/m/Y \a \l\a\s H:i:s') }}</div>
                </div>
            </div>

            <!-- Section 2: Datos generales -->
            <div class="relative mb-8 text-center mt-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span
                        class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Datos
                        generales</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 mt-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">ID del grupo</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->id }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Número de grupo</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->numero_grupo ?? '' }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Curso</label>
                    <div class="w-full font-bold text-gray-700 uppercase">
                        @if($grupo->tipo_servicio === 'CAE' && $grupo->curso)
                            {{ $grupo->curso->name }}
                        @elseif($grupo->tipo_servicio === 'Extensión' && $grupo->cursoIcategro)
                            {{ $grupo->cursoIcategro->name }}
                        @else
                            {{ 'NO DEFINIDO' }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 mt-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha de inicio</label>
                    <div class="w-full font-bold text-gray-700 uppercase">
                        {{ \Carbon\Carbon::parse($grupo->fecha_inicio)->translatedFormat('d \d\e F \d\e\l Y') }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha de término</label>
                    <div class="w-full font-bold text-gray-700 uppercase">
                        {{ \Carbon\Carbon::parse($grupo->fecha_termino)->translatedFormat('d \d\e F \d\e\l Y') }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Días</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->duracion_dias }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Horas</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->duracion_horas }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6 mt-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Horario</label>
                    <div class="w-full font-bold text-gray-700 uppercase break-words">{{ $grupo->horario }}</div>
                </div>
            </div>

            <!-- Section 3: Alumnos inscritos -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span
                        class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Alumnos
                        inscritos</span>
                </div>
            </div>

            <div class="flex justify-start mb-4 mt-6">
                <!-- Trigger for Modal: Agregar alumno -->
                <button type="button"
                    class="bg-[#198754] hover:bg-[#157347] text-white font-bold py-2 px-6 rounded shadow flex items-center transition"
                    id="btnAgregarAlumno">
                    <i class="fas fa-user-plus mr-2 text-xl"></i> Agregar alumno
                </button>
            </div>

            <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4 mt-2">
                <table id="alumnos_table" class="w-full text-xs text-left">
                    <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                        <tr>
                            <th class="py-2 px-2">Opciones</th>
                            <th class="py-2 px-2">ID<br>Alumno</th>
                            <th class="py-2 px-2">CURP</th>
                            <th class="py-2 px-2">Nombre</th>
                            <th class="py-2 px-2">Apellido 1</th>
                            <th class="py-2 px-2">Apellido 2</th>
                            <th class="py-2 px-2">Edad</th>
                            <th class="py-2 px-2">Grupo(s)<br>vulnerable(s)</th>
                            <th class="py-2 px-2">Discapacidad(es)</th>
                            <th class="py-2 px-2">Nivel de<br>estudios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grupo->listaAlumnos ?? [] as $ins)
                            @php
                                $alumno = $ins->student;
                            @endphp
                            @if($alumno)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-2 flex justify-start items-center space-x-3 whitespace-nowrap">
                                        {{-- El bote de basura se muestra si no cuenta con calificacion y no cuenta con estatus --}}
                                        @if(empty($ins->grade) && empty($ins->student_status))
                                            <form action="#" method="POST" class="inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-500 hover:text-red-700 transition"
                                                    title="Eliminar alumno">
                                                    <i class="fas fa-trash-alt text-lg"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- El ojo visualiza los datos del alumno --}}
                                        <a href="#" class="text-blue-500 hover:text-blue-700 transition"
                                            title="Ver detalles del alumno">
                                            <i class="fas fa-eye text-lg"></i>
                                        </a>
                                    </td>
                                    <td class="py-3 px-2">{{ $alumno->id }}</td>
                                    <td class="py-3 px-2">{{ $alumno->curp }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $alumno->name }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $alumno->lastname1 }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $alumno->lastname2 }}</td>
                                    <td class="py-3 px-2">{{ $alumno->edad }}</td>
                                    <td class="py-3 px-2 uppercase">
                                        {{ $ins->grupos_vulnerables ? implode(', ', $ins->grupos_vulnerables) : '' }}</td>
                                    <td class="py-3 px-2 uppercase">
                                        {{ $ins->discapacidades ? implode(', ', $ins->discapacidades) : '' }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $ins->escolaridad ?? '' }}</td>
                                </tr>
                            @endif
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Buttons -->
            <div
                class="flex justify-center mt-12 pb-6 pt-6 relative before:absolute before:top-0 before:left-[-1.5rem] before:right-[-1.5rem] before:border-t-2 before:border-[#bde4e6] bg-[#f0f9f9] -mx-6 md:-mx-10 rounded-b-lg">
                <a href="{{ route('grupos.index') }}"
                    class="bg-[#dc3545] hover:bg-[#c82333] text-white font-bold py-2 px-10 rounded shadow-md text-lg flex items-center transition mt-2">
                    Salir <i class="fas fa-sign-out-alt ml-2"></i>
                </a>
            </div>

        </div>

        <!-- Modal: Filtro/Búsqueda de Alumnos -->
        <div id="modalBusquedaAlumno"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl transform transition-all">
                <!-- Header -->
                <div class="flex justify-between items-center bg-white border-b border-gray-200 p-4 rounded-t-lg shadow-sm">
                    <h3 class="text-xl font-extrabold text-gray-800 flex items-center uppercase tracking-wide">
                        <span
                            class="bg-blue-300 w-8 h-8 rounded-full flex items-center justify-center mr-3 shadow text-white"><i
                                class="fas fa-user-friends text-sm"></i></span>
                        Alumno
                    </h3>
                    <button type="button"
                        class="close-modal bg-red-100 hover:bg-red-200 text-red-500 rounded-full w-8 h-8 flex items-center justify-center border border-red-200 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 md:p-8 select-none">
                    <form id="formBusquedaAlumno">
                        <!-- Fila 1 -->
                        <div class="flex flex-col md:flex-row gap-6 mb-6">
                            <div class="w-full md:w-1/3">
                                <label class="block text-center text-[#a02142] font-bold mb-2">ID alumno</label>
                                <input type="number" id="search_id_alumno"
                                    class="w-full border-2 border-[#d4b996] rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white font-bold text-center text-gray-700 shadow-sm">
                            </div>
                            <div class="w-full md:w-2/3">
                                <label class="block text-center text-[#a02142] font-bold mb-2">CURP</label>
                                <input type="text" id="search_curp"
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white uppercase font-bold text-gray-700 shadow-sm text-center">
                            </div>
                        </div>

                        <!-- Fila 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-2">Nombre</label>
                                <input type="text" id="search_nombre"
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white uppercase font-bold text-center text-gray-700 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-2">Apellido 1</label>
                                <input type="text" id="search_apellido_1"
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white uppercase font-bold text-center text-gray-700 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-2">Apellido 2</label>
                                <input type="text" id="search_apellido_2"
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white uppercase font-bold text-center text-gray-700 shadow-sm">
                            </div>
                        </div>

                        <!-- Botón Buscar -->
                        <div class="flex justify-center mb-8">
                            <button type="button" id="btnProcesarBusqueda"
                                class="bg-[#1f2937] hover:bg-black text-white font-bold py-2 px-8 rounded shadow-md text-sm flex items-center transition">
                                <i class="fas fa-search mr-2"></i> Buscar
                            </button>
                        </div>

                        <!-- Resultado Select -->
                        <div class="w-full">
                            <label class="block text-center text-[#a02142] font-bold mb-2">* Alumno</label>
                            <select id="alumno_select"
                                class="w-full border-2 border-gray-400 rounded-full p-3 px-4 focus:outline-none focus:border-red-500 bg-white uppercase font-bold text-gray-700 shadow-sm">
                                <option value="">» SELECCIONE EL ALUMNO</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="flex justify-end bg-white border-t border-gray-200 p-4 rounded-b-lg space-x-3">
                    <button type="button"
                        class="close-modal bg-[#dc3545] hover:bg-[#c82333] text-white font-bold py-2 px-4 rounded flex items-center transition shadow">
                        <i class="fas fa-times-circle mr-2"></i> Cerrar
                    </button>
                    <button type="button" id="btnSiguienteAlumno"
                        class="bg-[#4b5563] hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center transition shadow opacity-50 cursor-not-allowed"
                        disabled>
                        Siguiente <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal 2: Completar Alumno -->
        <div id="modalCompletarAlumno"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div
                class="bg-white rounded-lg shadow-xl w-full max-w-4xl transform transition-all max-h-[90vh] overflow-y-auto">
                <form action="{{ route('grupos.alumnos.store', $grupo->id) }}" method="POST" id="formCompletarAlumno">
                    @csrf
                    <input type="hidden" name="alumno_id" id="comp_alumno_id" value="">

                    <!-- Header -->
                    <div
                        class="flex justify-between items-center bg-white border-b border-gray-200 p-4 rounded-t-lg shadow-sm sticky top-0 z-10">
                        <h3 class="text-lg font-black text-gray-800 flex items-center tracking-wide uppercase">
                            <span
                                class="text-xl mr-3 shadow text-white flex items-center justify-center w-8 h-8 rounded-full">
                                <img src="https://ui-avatars.com/api/?name=AG&background=0D8ABC&color=fff&rounded=true"
                                    alt="Icon" class="w-8 h-8 rounded-full border border-gray-300">
                            </span>
                            ALUMNO EN GRUPO
                        </h3>
                        <button type="button"
                            class="close-modal bg-red-100 hover:bg-red-200 text-red-500 rounded-full w-8 h-8 flex items-center justify-center border border-red-200 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 md:p-8 select-none">
                        <!-- Fila 1: ID, CURP, Nombre -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                            <div class="md:col-span-1">
                                <label class="block text-center text-[#a02142] font-bold mb-1">ID alumno</label>
                                <input type="text" id="comp_id" disabled
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-gray-100 text-gray-700 font-bold text-center shadow-sm text-xs">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-center text-[#a02142] font-bold mb-1">CURP</label>
                                <input type="text" id="comp_curp" disabled
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-gray-100 text-gray-700 font-bold uppercase text-center shadow-sm text-xs">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-center text-[#a02142] font-bold mb-1">Nombre</label>
                                <input type="text" id="comp_nombre" disabled
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-gray-100 text-gray-700 font-bold uppercase text-center shadow-sm text-xs">
                            </div>
                        </div>

                        <!-- Fila 2: Apellidos -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Apellido 1</label>
                                <input type="text" id="comp_apellido1" disabled
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-gray-100 text-gray-700 font-bold uppercase text-center shadow-sm text-xs">
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Apellido 2</label>
                                <input type="text" id="comp_apellido2" disabled
                                    class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-gray-100 text-gray-700 font-bold uppercase text-center shadow-sm text-xs">
                            </div>
                        </div>

                        <hr class="border-gray-200 mb-6">

                        <!-- Grupos Vulnerables -->
                        <h4 class="text-center text-[#a02142] font-bold text-lg mb-6 tracking-wide">Grupo(s) vulnerable(s)
                            al que pertenece</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-2 mb-8">
                            @php
                                $vulnerables = [
                                    'ADOLESCENTES',
                                    'ADULTOS MAYORES',
                                    'MINORÍAS RELIGIOSAS',
                                    'MUJERES JEFAS DE FAMILIA',
                                    'PERSONAS AFRODESCENDIENTES',
                                    'PERSONAS CON DISCAPACIDAD',
                                    'PERSONAS DE LA DIVERSIDAD SEXUAL',
                                    'PERSONAS DESEMPLEADAS',
                                    'PERSONAS EN SITUACIÓN DE CALLE',
                                    'PERSONAS INDÍGENAS O PERTENECIENTES A ALGUNA ETNIA',
                                    'PERSONAS JÓVENES',
                                    'PERSONAS MIGRANTES, REFUGIADOS Y SOLICITANTES DE ASILO',
                                    'PERSONAS PRIVADAS DE LA LIBERTAD',
                                    'PERSONAS RESIDENTES EN INSTITUCIONES DE ASISTENCIA SOCIAL',
                                    'POBLACIONES MARGINADAS'
                                ];
                            @endphp
                            @foreach($vulnerables as $vul)
                                <label
                                    class="flex items-center space-x-3 cursor-pointer group hover:bg-gray-50 p-1 rounded transition">
                                    <div class="relative">
                                        <input type="checkbox" name="vulnerables[]" value="{{ $vul }}"
                                            class="sr-only peer toggle-checkbox">
                                        <div
                                            class="w-9 h-5 bg-gray-300 rounded-full peer peer-checked:bg-[#a02142] transition shadow-inner">
                                        </div>
                                        <div
                                            class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition transform peer-checked:translate-x-4 shadow">
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 uppercase">{{ $vul }}</span>
                                </label>
                            @endforeach
                        </div>

                        <hr class="border-gray-200 mb-6">

                        <!-- Discapacidades -->
                        <h4 class="text-center text-[#a02142] font-bold text-lg mb-6 tracking-wide">Discapacidades</h4>
                        <div class="flex flex-wrap justify-center gap-6 mb-8">
                            @php
                                $discapacidades = [
                                    'PARA VER',
                                    'PARA OIR',
                                    'PARA HABLAR',
                                    'MOTRIZ',
                                    'MENTAL'
                                ];
                            @endphp
                            @foreach($discapacidades as $disc)
                                <label
                                    class="flex items-center space-x-3 cursor-pointer group hover:bg-gray-50 p-1 rounded transition">
                                    <div class="relative">
                                        <input type="checkbox" name="discapacidades[]" value="{{ $disc }}"
                                            class="sr-only peer toggle-checkbox">
                                        <div
                                            class="w-9 h-5 bg-gray-300 rounded-full peer peer-checked:bg-[#a02142] transition shadow-inner">
                                        </div>
                                        <div
                                            class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition transform peer-checked:translate-x-4 shadow">
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 uppercase">{{ $disc }}</span>
                                </label>
                            @endforeach
                        </div>

                        <hr class="border-gray-200 mb-6">

                        <!-- Escolaridad -->
                        <h4 class="text-center text-[#a02142] font-bold text-lg mb-6 tracking-wide">Escolaridad</h4>
                        <div class="flex justify-center mb-6">
                            <select name="escolaridad"
                                class="w-full md:w-3/4 border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white uppercase font-bold text-gray-700 shadow-sm text-sm"
                                required>
                                <option value="">» SELECCIONA</option>
                                <option value="SABE LEER Y ESCRIBIR">SABE LEER Y ESCRIBIR</option>
                                <option value="PRIMARIA INCOMPLETA">PRIMARIA INCOMPLETA</option>
                                <option value="PRIMARIA COMPLETA">PRIMARIA COMPLETA</option>
                                <option value="SECUNDARIA INCOMPLETA">SECUNDARIA INCOMPLETA</option>
                                <option value="SECUNDARIA COMPLETA">SECUNDARIA COMPLETA</option>
                                <option value="BACHILLERATO INCOMPLETO">BACHILLERATO INCOMPLETO</option>
                                <option value="BACHILLERATO COMPLETO">BACHILLERATO COMPLETO</option>
                                <option value="CARRERA TÉCNICA INCOMPLETA">CARRERA TÉCNICA INCOMPLETA</option>
                                <option value="CARRERA TÉCNICA COMPLETA">CARRERA TÉCNICA COMPLETA</option>
                                <option value="LICENCIATURA INCOMPLETA">LICENCIATURA INCOMPLETA</option>
                                <option value="LICENCIATURA COMPLETA">LICENCIATURA COMPLETA</option>
                                <option value="POSTGRADO INCOMPLETO">POSTGRADO INCOMPLETO</option>
                                <option value="POSTGRADO COMPLETO">POSTGRADO COMPLETO</option>
                            </select>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div
                        class="flex justify-end bg-gray-50 border-t border-gray-200 p-4 rounded-b-lg space-x-3 sticky bottom-0 z-10">
                        <button type="button"
                            class="close-modal bg-[#dc3545] hover:bg-[#c82333] text-white font-bold py-2 px-5 rounded flex items-center transition shadow-sm text-sm">
                            <i class="fas fa-times-circle mr-2"></i> Cerrar
                        </button>
                        <button type="submit"
                            class="bg-[#4b5563] hover:bg-gray-700 text-white font-bold py-2 px-5 rounded flex items-center transition shadow-sm text-sm">
                            <i class="fas fa-plus mr-2"></i> Agregar
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#alumnos_table')) {
                $('#alumnos_table').DataTable().destroy();
            }
            var alumnosTable = $('#alumnos_table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ entradas",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                ordering: false,
                dom: '<"flex justify-between items-center mb-4"l f>rt<"flex justify-between items-center mt-4"i p>',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
                pageLength: 25
            });

            const modalInfo = $('#modalBusquedaAlumno');
            const modalCompletar = $('#modalCompletarAlumno');

            // Action para btnAgregarAlumno (Abrir Modal)
            $('#btnAgregarAlumno').on('click', function () {
                modalInfo.removeClass('hidden');
            });

            // Action para Cerrar Modal
            $('.close-modal').on('click', function () {
                modalInfo.addClass('hidden');
                modalCompletar.addClass('hidden');
                // Limpiar modal busqueda
                $('#formBusquedaAlumno')[0].reset();
                $('#alumno_select').html('<option value="">» SELECCIONE EL ALUMNO</option>');
                $('#btnSiguienteAlumno').prop('disabled', true).addClass('opacity-50 cursor-not-allowed').removeClass('bg-[#374151] hover:bg-black').addClass('bg-[#4b5563]');
                // Limpiar modal completar
                $('#formCompletarAlumno')[0].reset();
            });

            // Habilitar / Deshabilitar Siguiente
            $('#alumno_select').on('change', function () {
                if ($(this).val() !== '') {
                    $('#btnSiguienteAlumno').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed bg-[#4b5563]').addClass('bg-[#374151] hover:bg-black');
                } else {
                    $('#btnSiguienteAlumno').prop('disabled', true).addClass('opacity-50 cursor-not-allowed bg-[#4b5563]').removeClass('bg-[#374151] hover:bg-black');
                }
            });

            // AJAX Buscar Alumnos
            $('#btnProcesarBusqueda').on('click', function () {
                let id_alumno = $('#search_id_alumno').val();
                let curp = $('#search_curp').val();
                let nombre = $('#search_nombre').val();
                let apellido_1 = $('#search_apellido_1').val();
                let apellido_2 = $('#search_apellido_2').val();

                let btn = $(this);
                let originalHtml = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Buscando...');
                btn.prop('disabled', true);

                $.ajax({
                    url: '/api/alumnos/search',
                    type: 'GET',
                    data: {
                        id_alumno: id_alumno,
                        curp: curp,
                        nombre: nombre,
                        apellido_1: apellido_1,
                        apellido_2: apellido_2
                    },
                    success: function (response) {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);

                        let select = $('#alumno_select');
                        select.empty();
                        select.append('<option value="">» SELECCIONE EL ALUMNO</option>');

                        if (response.length > 0) {
                            response.forEach(function (alumno) {
                                select.append('<option value="' + alumno.id + '">' + alumno.id + ' - ' + alumno.curp + ' - ' + alumno.name + ' ' + alumno.lastname1 + ' ' + (alumno.lastname2 ? alumno.lastname2 : '') + '</option>');
                            });
                        } else {
                            select.append('<option value="">» NO SE ENCONTRARON ALUMNOS</option>');
                        }

                        $('#btnSiguienteAlumno').prop('disabled', true).addClass('opacity-50 cursor-not-allowed bg-[#4b5563]').removeClass('bg-[#374151] hover:bg-black');
                    },
                    error: function () {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                        Swal.fire('Error', 'Hubo un problema al buscar en el servidor', 'error');
                    }
                });
            });

            // Action para Siguiente Alumno
            $('#btnSiguienteAlumno').on('click', function () {
                let alumno_id = $('#alumno_select').val();
                let btn = $(this);
                let originalHtml = btn.html();
                btn.html('Validando... <i class="fas fa-spinner fa-spin ml-2"></i>');
                btn.prop('disabled', true);

                $.ajax({
                    url: '{{ route('grupos.alumnos.validar', $grupo->id) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        alumno_id: alumno_id
                    },
                    success: function (response) {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);

                        if (response.valid === false) {
                            Swal.fire({
                                title: '<span class="text-red-500 font-bold uppercase"><i class="fas fa-exclamation-circle"></i> Error</span>',
                                html: '<span class="text-md text-gray-700">' + response.message + '</span>',
                                icon: 'error',
                                confirmButtonColor: '#1f2937',
                                customClass: {
                                    popup: 'rounded-xl',
                                    title: 'text-left'
                                }
                            });
                        } else if (response.valid === true) {
                            // Rellenar datos en el segundo modal
                            $('#comp_alumno_id').val(response.student.id);
                            $('#comp_id').val(response.student.id);
                            $('#comp_curp').val(response.student.curp);
                            $('#comp_nombre').val(response.student.name);
                            $('#comp_apellido1').val(response.student.lastname1);
                            $('#comp_apellido2').val(response.student.lastname2 || '');

                            // Ocultar modal 1 y mostrar modal 2
                            modalInfo.addClass('hidden');
                            modalCompletar.removeClass('hidden');
                        }
                    },
                    error: function () {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                        Swal.fire('Error', 'Hubo un error al validar el alumno', 'error');
                    }
                });
            });

            // AJAX Submission formCompletarAlumno
            $('#formCompletarAlumno').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let btn = form.find('button[type="submit"]');
                let originalHtml = btn.html();

                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Guardando...');
                btn.prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function (response) {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                        if (response.success) {
                            Swal.fire({
                                title: 'Éxito',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Para refrescar limpiamente la vista, recargamos (redibuja tabla instantaneo)
                                window.location.reload();
                            });
                        }
                    },
                    error: function (xhr) {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                        let msg = xhr.responseJSON ? (xhr.responseJSON.message || 'Hubo un error guardando el alumno') : 'Error al conectar con servidor';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

        });
    </script>
@endpush