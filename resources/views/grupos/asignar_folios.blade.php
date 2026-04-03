@extends('layouts.app')

@section('title', 'Asignación de Folios - ICATEGRO')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl text-sm">
        <!-- Header ASIGNACIÓN DE FOLIOS -->
            <div class="bg-[#d4b996] p-4 text-center">
                <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                    <i class="fas fa-edit mr-3 text-gray-800"></i>
                    ASIGNACIÓN DE FOLIOS
                </h1>
            </div>
        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-10 mb-8 border border-gray-200">
            <!-- Section 1: Registro -->
            <div class="relative mb-8 text-center mt-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Registro</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Estatus del grupo</label>
                    <div class="w-full md:w-3/4 border border-gray-500 rounded-full p-2 px-4 bg-gray-50 font-bold text-gray-800 flex items-center shadow-inner uppercase select-none">
                        <span class="w-4 h-4 rounded-full mr-2 shadow-sm inline-block
                            @if(strtoupper($grupo->estatus) == 'PENDIENTE') bg-yellow-500 
                            @elseif(strtoupper($grupo->estatus) == 'AUTORIZADO') bg-green-600 
                            @elseif(strtoupper($grupo->estatus) == 'PROCESO' || strtoupper($grupo->estatus) == 'PROCESS') bg-blue-500 
                            @elseif(strtoupper($grupo->estatus) == 'CONCLUIDO') bg-purple-700 
                            @elseif(strtoupper($grupo->estatus) == 'RECHAZADO') bg-red-600
                            @elseif(strtoupper($grupo->estatus) == 'CALIFICADO') bg-pink-500  
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
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->plantel->user ? $grupo->plantel->user->name . ' ' . $grupo->plantel->user->last_name . ' ' . $grupo->plantel->user->last_name2 : 'N/A' }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Usuario registró</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->plantel->user ? $grupo->plantel->user->name . ' ' . $grupo->plantel->user->last_name . ' ' . $grupo->plantel->user->last_name2 : 'N/A' }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha de registro</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ $grupo->created_at->format('d/m/Y \a \l\a\s H:i:s') }}</div>
                </div>
            </div>

            <!-- Section 2: Datos generales -->
            <div class="relative mb-8 text-center mt-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Datos generales</span>
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
                    <div class="w-full font-bold text-gray-700 uppercase">{{ \Carbon\Carbon::parse($grupo->fecha_inicio)->translatedFormat('d \d\e F \d\e\l Y') }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha de término</label>
                    <div class="w-full font-bold text-gray-700 uppercase">{{ \Carbon\Carbon::parse($grupo->fecha_termino)->translatedFormat('d \d\e F \d\e\l Y') }}</div>
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

            <!-- Section 3: Folios -->
            <div class="relative mb-8 text-center mt-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Folios</span>
                </div>
            </div>

        <form action="{{ route('grupos.folios.store', $grupo->id) }}" method="POST" id="formFolios">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-4">
                <div>
                    <label class="block text-[#a02142] font-bold mb-2 text-sm">Tipo de documento</label>
                    <select name="doc_type" id="doc_type" class="w-full border-2 border-gray-400 rounded-full py-2 px-4 focus:outline-none focus:border-red-500 font-bold text-gray-700 uppercase shadow-sm" required>
                        <option value="">» SELECCIONE</option>
                        <option value="CONSTANCIA">CONSTANCIA</option>
                        <option value="DIPLOMA">DIPLOMA</option>
                        <option value="RECONOCIMIENTO">RECONOCIMIENTO</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-2 text-sm">Prefijo y Folio inicial</label>
                    <div class="flex">
                        <input type="text" name="folio_inicial" placeholder="Ej: SR-0000001" class="w-full border-2 border-gray-400 rounded-full py-2 px-4 focus:outline-none focus:border-red-500 font-bold text-gray-700 uppercase shadow-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-2 text-sm">Prefijo y Folio final</label>
                    <div class="flex">
                        <input type="text" name="folio_final" placeholder="Ej: SR-0000100" class="w-full border-2 border-gray-400 rounded-full py-2 px-4 focus:outline-none focus:border-red-500 font-bold text-gray-700 uppercase shadow-sm" required>
                    </div>
                </div>
            </div>

            <!-- Section 4: Listado de folios de alumnos -->
            <div class="relative mb-8 text-center mt-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Listado de folios de alumnos</span>
                </div>
            </div>

            <!-- Leyenda de Estatus / Documento -->
            <div class="mb-6 px-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-bold text-sm text-gray-800 mb-3">Estatus</h4>
                    <div class="flex flex-wrap items-center gap-6 text-xs font-semibold text-gray-700">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-thumbs-up text-green-500 text-lg"></i>
                            <span class="uppercase">Aprobado</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-thumbs-down text-red-500 text-lg"></i>
                            <span class="uppercase">No aprobado</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user-minus text-blue-800 text-lg"></i>
                            <span class="uppercase">Baja</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-walking text-orange-500 text-lg"></i>
                            <span class="uppercase">Desercion</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-gray-800 mb-3">Tipo de documento</h4>
                    <div class="flex flex-wrap items-center gap-6 text-xs font-semibold text-gray-700">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-contract text-green-500 text-lg"></i>
                            <span class="uppercase">Documento Asignado</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-excel text-red-500 text-lg"></i>
                            <span class="uppercase">No Aplica</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto bg-white rounded shadow-sm border border-gray-200 mt-4 mb-4">
                <table id="alumnos_table" class="w-full text-left border-collapse min-w-max text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-800 font-bold border-b-2 border-gray-300 text-center uppercase text-[11px]">
                            <th class="py-3 px-2 w-16">Opciones</th>
                            <th class="py-3 px-2">ID Alumno</th>
                            <th class="py-3 px-2">CURP</th>
                            <th class="py-3 px-2">Nombre</th>
                            <th class="py-3 px-2">Apellido 1</th>
                            <th class="py-3 px-2">Apellido 2</th>
                            <th class="py-3 px-2">Calificación del alumno</th>
                            <th class="py-3 px-2">Estatus del alumno</th>
                            <th class="py-3 px-2">Tipo de documento</th>
                            <th class="py-3 px-2">Folio</th>
                        </tr>
                    </thead>
                    <tbody class="text-center text-gray-700 font-semibold border-b border-gray-200 bg-gray-50 text-[11px]">
                        @forelse($grupo->listaAlumnos as $index => $ins)
                            @php
                                $alumno = $ins->student;
                                $isAprobado = ($ins->student_status === 'APROBADO');
                            @endphp
                            @if($alumno)
                                <tr class="border-b border-gray-200 hover:bg-gray-100 transition">
                                <td class="py-3 px-2 flex justify-center space-x-2">
                                        @if($isAprobado && !empty($ins->folio))
                                            <a href="javascript:void(0)" class="text-red-500 hover:text-red-700 transition btn-cancelar-folio" title="Cancelar folio"
                                                data-id="{{ $ins->id }}"
                                                data-idalumno="{{ $alumno->id }}"
                                                data-curp="{{ $alumno->curp }}"
                                                data-name="{{ $alumno->name }}"
                                                data-app1="{{ $alumno->lastname1 }}"
                                                data-app2="{{ $alumno->lastname2 }}"
                                                data-doctype="{{ $ins->doc_type }}"
                                                data-folio="{{ $ins->folio }}">
                                                <i class="fas fa-ban text-lg"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="text-purple-700 hover:text-purple-900 transition btn-change-folio" title="Cambiar folio"
                                                data-id="{{ $ins->id }}"
                                                data-idalumno="{{ $alumno->id }}"
                                                data-curp="{{ $alumno->curp }}"
                                                data-name="{{ $alumno->name }}"
                                                data-app1="{{ $alumno->lastname1 }}"
                                                data-app2="{{ $alumno->lastname2 }}"
                                                data-doctype="{{ $ins->doc_type }}"
                                                data-folio="{{ $ins->folio }}">
                                                <i class="fas fa-exchange-alt text-lg"></i>
                                            </a>
                                        @endif
                                        <a href="#" class="text-blue-500 hover:text-blue-700 transition" title="Ver alumno">
                                            <i class="fas fa-eye text-lg"></i>
                                        </a>
                                    </td>
                                    <td class="py-3 px-2">{{ $alumno->id }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $alumno->curp }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $alumno->name }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $alumno->lastname1 }}</td>
                                    <td class="py-3 px-2 uppercase">{{ $alumno->lastname2 }}</td>
                                    <td class="py-3 px-2">{{ $ins->calificacion ?? '-' }}</td>
                                    <td class="py-3 px-2 text-left w-32">
                                        @if($isAprobado)
                                            <span class="text-green-600 font-bold uppercase"><i class="fas fa-thumbs-up mr-2 text-lg"></i> APROBADO</span>
                                        @elseif($ins->student_status === 'NO APROBADO')
                                            <span class="text-red-500 font-bold uppercase"><i class="fas fa-thumbs-down mr-2 text-lg"></i> NO APROBADO</span>
                                        @elseif($ins->student_status === 'BAJA')
                                            <span class="text-blue-800 font-bold uppercase"><i class="fas fa-user-minus mr-2 text-lg"></i> BAJA</span>
                                        @elseif($ins->student_status === 'DESERCION')
                                            <span class="text-orange-500 font-bold uppercase"><i class="fas fa-walking mr-2 text-lg"></i> DESERCION</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 px-2 text-left w-36">
                                        @if($isAprobado)
                                            <span class="text-green-600 font-bold uppercase doc-type-display"><i class="fas fa-file-contract mr-2 text-lg"></i> CONSTANCIA</span>
                                        @else
                                            <span class="text-red-500 font-bold uppercase"><i class="fas fa-file-excel mr-2 text-lg"></i> NO APLICA</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-2 text-gray-500 uppercase font-black tracking-wide bg-gray-100">{{ $isAprobado ? ($ins->folio ?? 'PENDIENTE') : '' }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-6 text-gray-500 font-bold">No hay alumnos inscritos en este grupo para asignar folios.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Botones Finales Guardar/Salir -->
            <div class="flex justify-between items-center bg-teal-50 border-t border-teal-100 p-4 rounded-b-lg mt-8 shadow-inner">
                <a href="{{ route('grupos.index') }}" class="bg-[#d9534f] hover:bg-[#c9302c] text-white font-bold py-2 px-6 rounded-lg flex items-center transition shadow-md border border-[#d43f3a]">
                    Salir <i class="fas fa-sign-out-alt ml-2"></i>
                </a>

                @if($grupo->listaAlumnos->where('student_status', 'APROBADO')->count() > 0)
                    <button type="submit" id="btnGuardarFolios" class="bg-[#1f2937] hover:bg-black text-white font-bold py-2 px-6 rounded-lg flex items-center transition shadow-md border border-gray-800">
                        Guardar <i class="fas fa-save ml-2"></i>
                    </button>
                @endif
            </div>

        </form>

        <!-- Modal: Cambio de Folio -->
        <div id="modalCambioFolio" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all">
                <form id="formCambioFolio">
                    @csrf
                    <input type="hidden" id="change_id_lista" name="id_lista">

                    <!-- Header -->
                    <div class="flex justify-between items-center bg-white border-b border-gray-200 p-4 rounded-t-lg shadow-sm">
                        <h3 class="text-lg font-extrabold text-gray-800 flex items-center uppercase tracking-wide">
                            <span class="bg-indigo-100 w-8 h-8 rounded-full flex items-center justify-center mr-3 shadow text-indigo-500"><i class="fas fa-file-invoice text-sm"></i></span>
                            CAMBIO DE FOLIO
                        </h3>
                        <button type="button" class="close-modal bg-red-100 hover:bg-red-200 text-red-500 rounded-full w-8 h-8 flex items-center justify-center border border-red-200 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 md:p-8">
                        <div class="flex flex-col md:flex-row gap-6 mb-4">
                            <div class="w-full md:w-1/3">
                                <label class="block text-center text-[#a02142] font-bold mb-1">ID alumno</label>
                                <input type="text" id="change_id_alumno" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm">
                            </div>
                            <div class="w-full md:w-2/3">
                                <label class="block text-center text-[#a02142] font-bold mb-1">CURP</label>
                                <input type="text" id="change_curp" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Nombre</label>
                                <input type="text" id="change_nombre" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Apellido 1</label>
                                <input type="text" id="change_app1" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Apellido 2</label>
                                <input type="text" id="change_app2" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                        </div>

                        <h4 class="text-center font-bold text-gray-800 mb-4 tracking-wide uppercase border-t pt-4 border-gray-300">
                            <i class="fas fa-file-alt mr-2"></i> DATOS DEL FOLIO
                        </h4>

                        <div class="mb-4">
                            <label class="block text-center text-[#a02142] font-bold mb-1">Tipo de documento</label>
                            <input type="text" id="change_doctype" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-gray-700 text-sm shadow-sm uppercase text-center">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Folio actual</label>
                                <div class="flex items-center">
                                    <input type="text" id="change_folio_prefix" disabled class="w-16 border-2 border-gray-400 border-r-0 rounded-l-full p-2 bg-gray-100 text-gray-500 font-bold text-sm text-center">
                                    <input type="text" id="change_folio_num" disabled class="w-full border-2 border-gray-400 rounded-r-full p-2 px-4 bg-white text-gray-800 font-bold text-sm shadow-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">* Folio nuevo</label>
                                <div class="flex items-center">
                                    <input type="text" id="change_new_prefix" disabled class="w-16 border-2 border-gray-400 border-r-0 rounded-l-full p-2 bg-gray-100 text-gray-500 font-bold text-sm text-center">
                                    <input type="text" id="change_new_num" class="w-full border-2 border-gray-400 rounded-r-full p-2 px-4 bg-white text-gray-800 font-bold text-sm shadow-sm" required autofocus autocomplete="off">
                                </div>
                                <input type="hidden" name="folio_nuevo" id="hidden_folio_nuevo">
                            </div>
                        </div>

                        <div>
                            <label class="block text-center text-[#a02142] font-bold mb-1">* Motivo del cambio</label>
                            <textarea name="motivo_cambio" rows="3" class="w-full border-2 border-gray-400 rounded-xl p-3 focus:outline-none focus:border-red-500 bg-white font-bold text-gray-700 text-sm shadow-sm resize-none" required></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end bg-gray-50 border-t border-gray-200 p-4 rounded-b-lg space-x-3">
                        <button type="button" class="close-modal bg-[#dc3545] hover:bg-[#c82333] text-white font-bold py-2 px-6 rounded flex items-center transition shadow-sm text-sm border border-[#d43f3a]">
                            <i class="fas fa-times-circle mr-2"></i> Cerrar
                        </button>
                        <button type="submit" id="btnProcesarCambio" class="bg-[#198754] hover:bg-[#157347] text-white font-bold py-2 px-6 rounded flex items-center transition shadow-sm text-sm border border-[#146c43]">
                            <i class="fas fa-exchange-alt mr-2"></i> Cambiar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal: Cancelar Folio -->
        <div id="modalCancelarFolio" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all">
                <form id="formCancelarFolio">
                    @csrf
                    <input type="hidden" id="cancel_id_lista" name="id_lista">
                    
                    <!-- Header -->
                    <div class="flex justify-between items-center bg-white border-b border-gray-200 p-4 rounded-t-lg shadow-sm">
                        <h3 class="text-lg font-extrabold text-gray-800 flex items-center uppercase tracking-wide">
                            <span class="bg-red-100 w-8 h-8 rounded-full flex items-center justify-center mr-3 shadow text-red-500"><i class="fas fa-file-excel text-sm"></i></span>
                            CANCELAR FOLIO
                        </h3>
                        <button type="button" class="close-modal bg-red-100 hover:bg-red-200 text-red-500 rounded-full w-8 h-8 flex items-center justify-center border border-red-200 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 md:p-8">
                        <div class="flex flex-col md:flex-row gap-6 mb-4">
                            <div class="w-full md:w-1/3">
                                <label class="block text-center text-[#a02142] font-bold mb-1">ID alumno</label>
                                <input type="text" id="cancel_id_alumno" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm">
                            </div>
                            <div class="w-full md:w-2/3">
                                <label class="block text-center text-[#a02142] font-bold mb-1">CURP</label>
                                <input type="text" id="cancel_curp" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Nombre</label>
                                <input type="text" id="cancel_nombre" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Apellido 1</label>
                                <input type="text" id="cancel_app1" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Apellido 2</label>
                                <input type="text" id="cancel_app2" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-center text-gray-700 text-sm shadow-sm uppercase">
                            </div>
                        </div>

                        <h4 class="text-center font-bold text-gray-800 mb-4 tracking-wide uppercase border-t pt-4 border-gray-300">
                            <i class="fas fa-file-alt mr-2"></i> DATOS DEL FOLIO
                        </h4>

                        <div class="mb-4">
                            <label class="block text-center text-[#a02142] font-bold mb-1">Tipo de documento</label>
                            <input type="text" id="cancel_doctype" disabled class="w-full border-2 border-gray-400 rounded-full p-2 px-4 bg-white font-bold text-gray-700 text-sm shadow-sm uppercase text-center">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">Folio actual</label>
                                <div class="flex items-center">
                                    <input type="text" id="cancel_folio_prefix" disabled class="w-16 border-2 border-gray-400 border-r-0 rounded-l-full p-2 bg-gray-100 text-gray-500 font-bold text-sm text-center">
                                    <input type="text" id="cancel_folio_num" disabled class="w-full border-2 border-gray-400 rounded-r-full p-2 px-4 bg-white text-gray-800 font-bold text-sm shadow-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-center text-[#a02142] font-bold mb-1">* Estatus nuevo</label>
                                <select name="estatus_nuevo" class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 font-bold text-gray-700 text-sm shadow-sm" required>
                                    <option value="">» SELECCIONA</option>
                                    <option value="NO APROBADO">NO APROBADO</option>
                                    <option value="BAJA">BAJA</option>
                                    <option value="DESERCION">DESERCION</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-center text-[#a02142] font-bold mb-1">* Motivo de la cancelación</label>
                            <textarea name="motivo_cancelacion" rows="3" maxlength="200" class="w-full border-2 border-gray-400 rounded-xl p-3 focus:outline-none focus:border-red-500 bg-white font-bold text-gray-700 text-sm shadow-sm resize-none" required></textarea>
                            <div class="text-right text-xs text-gray-500 mt-1">Máximo 200 caracteres</div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end bg-gray-50 border-t border-gray-200 p-4 rounded-b-lg space-x-3">
                        <button type="button" class="close-modal bg-[#dc3545] hover:bg-[#c82333] text-white font-bold py-2 px-6 rounded flex items-center transition shadow-sm text-sm border border-[#d43f3a]">
                            <i class="fas fa-times-circle mr-2"></i> Cerrar
                        </button>
                        <button type="submit" id="btnProcesarCancelar" class="bg-[#198754] hover:bg-[#157347] text-white font-bold py-2 px-6 rounded flex items-center transition shadow-sm text-sm border border-[#146c43]">
                            <i class="fas fa-ban mr-2"></i> Cancelar folio
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
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
            font-size: 0.875rem;
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
        $(document).ready(function() {
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
                dom: '<"flex justify-between items-center mb-4"l f>rt<"flex flex-col sm:flex-row justify-between items-center mt-4 border-t border-gray-200 pt-4"i p>',
                lengthMenu: [[10, 25, 50, -1], [10, 100, "Todo"]],
                pageLength: 100
            });

            // Lógica para Almacenar Masivamente Folios
            $('#formFolios').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let btn = $('#btnGuardarFolios');
                let originalHtml = btn.html();

                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Guardando...').prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        btn.html(originalHtml).prop('disabled', false);
                        if(response.success) {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#1f2937'
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        btn.html(originalHtml).prop('disabled', false);

                        if(xhr.responseJSON && xhr.responseJSON.errors_list) {
                            let errsHTML = '<div class="text-left font-semibold text-gray-700 text-sm h-64 overflow-y-auto">';
                            xhr.responseJSON.errors_list.forEach(function(err) {
                                errsHTML += '<p class="mb-2 border-b pb-1"><i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i> ' + err + '</p>';
                            });
                            errsHTML += '</div>';

                            Swal.fire({
                                title: '<span class="text-red-500 font-bold uppercase"><i class="fas fa-times-circle"></i> ERROR DE FOLIOS</span>',
                                html: errsHTML,
                                icon: 'error',
                                confirmButtonColor: '#1f2937'
                            });
                        } else {
                            let msg = xhr.responseJSON ? (xhr.responseJSON.message || 'Error al procesar la solicitud.') : 'Error de servidor';
                            Swal.fire({
                                title: '<span class="text-red-500 font-bold uppercase"><i class="fas fa-exclamation-circle"></i> Error</span>',
                                html: '<span class="text-md text-gray-700">' + msg + '</span>',
                                icon: 'error',
                                confirmButtonColor: '#1f2937'
                            });
                        }
                    }
                });
            });

            // Lógica para Modales Cambio Folio
            const modalCambioFolio = $('#modalCambioFolio');

            $(document).on('click', '.close-modal', function() {
                modalCambioFolio.addClass('hidden');
                $('#formCambioFolio')[0].reset();
            });

            $(document).on('click', '.btn-change-folio', function() {
                let id = $(this).data('id');
                let idalumno = $(this).data('idalumno');
                let curp = $(this).data('curp');
                let name = $(this).data('name');
                let app1 = $(this).data('app1');
                let app2 = $(this).data('app2');
                let doctype = $(this).data('doctype');
                let folio = $(this).data('folio');

                // Regex to split folio (GR-000014 -> prefix: GR-, num: 000014)
                let prefix = "";
                let num = folio;
                let m = folio.match(/^(.*?)(\d+)$/);
                if(m) {
                    prefix = m[1];
                    num = m[2];
                }

                $('#change_id_lista').val(id);
                $('#change_id_alumno').val(idalumno);
                $('#change_curp').val(curp);
                $('#change_nombre').val(name);
                $('#change_app1').val(app1);
                $('#change_app2').val(app2);
                $('#change_doctype').val(doctype);

                $('#change_folio_prefix').val(prefix);
                $('#change_folio_num').val(num);
                $('#change_new_prefix').val(prefix);

                modalCambioFolio.removeClass('hidden');
            });

            $('#formCambioFolio').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let btn = $('#btnProcesarCambio');
                let originalHtml = btn.html();

                // Construimos el folio fusionado
                let prefix = $('#change_new_prefix').val();
                let suffix = $('#change_new_num').val();
                $('#hidden_folio_nuevo').val(prefix + suffix);

                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Cambiando...').prop('disabled', true);

                $.ajax({
                    url: '{{ route('grupos.folios.cambiar', $grupo->id) }}',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        btn.html(originalHtml).prop('disabled', false);
                        if(response.success) {
                            Swal.fire({
                                title: 'Éxito',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#1f2937'
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        btn.html(originalHtml).prop('disabled', false);
                        if(xhr.status === 422) {
                            let msg = '<span class="text-md text-gray-700">' + xhr.responseJSON.message + '</span>';
                            Swal.fire({
                                title: '<span class="text-red-500 font-bold uppercase"><i class="fas fa-exclamation-circle"></i> Error</span>',
                                html: msg,
                                icon: 'error',
                                confirmButtonColor: '#1f2937'
                            });
                        } else {
                            Swal.fire('Error', 'Hubo un error de conexión', 'error');
                        }
                    }
                });
            });

            // Lógica para Modal Cancelar Folio
            const modalCancelarFolio = $('#modalCancelarFolio');

            $(document).on('click', '.btn-cancelar-folio', function() {
                let id = $(this).data('id');
                let idalumno = $(this).data('idalumno');
                let curp = $(this).data('curp');
                let name = $(this).data('name');
                let app1 = $(this).data('app1');
                let app2 = $(this).data('app2');
                let doctype = $(this).data('doctype');
                let folio = $(this).data('folio');
                
                let prefix = "";
                let num = folio;
                let m = folio.match(/^(.*?)(\d+)$/);
                if(m) {
                    prefix = m[1];
                    num = m[2];
                }

                $('#cancel_id_lista').val(id);
                $('#cancel_id_alumno').val(idalumno);
                $('#cancel_curp').val(curp);
                $('#cancel_nombre').val(name);
                $('#cancel_app1').val(app1);
                $('#cancel_app2').val(app2);
                $('#cancel_doctype').val(doctype);

                $('#cancel_folio_prefix').val(prefix);
                $('#cancel_folio_num').val(num);

                modalCancelarFolio.removeClass('hidden');
            });

            $(document).on('click', '#modalCancelarFolio .close-modal', function() {
                modalCancelarFolio.addClass('hidden');
                $('#formCancelarFolio')[0].reset();
            });

            $('#formCancelarFolio').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let btn = $('#btnProcesarCancelar');
                let originalHtml = btn.html();

                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Cancelando...').prop('disabled', true);

                $.ajax({
                    url: '{{ route('grupos.folios.cancelar', $grupo->id) }}',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        btn.html(originalHtml).prop('disabled', false);
                        if(response.success) {
                            Swal.fire({
                                title: '¡Cancelado!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#1f2937'
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        btn.html(originalHtml).prop('disabled', false);
                        let msg = xhr.responseJSON ? (xhr.responseJSON.message || 'Error al cancelar') : 'Hubo un error de conexión';
                        Swal.fire({
                            title: '<span class="text-red-500 font-bold uppercase"><i class="fas fa-exclamation-circle"></i> Error</span>',
                            html: '<span class="text-md text-gray-700">' + msg + '</span>',
                            icon: 'error',
                            confirmButtonColor: '#1f2937'
                        });
                    }
                });
            });

        });
    </script>
@endpush
