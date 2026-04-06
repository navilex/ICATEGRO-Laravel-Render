@extends('layouts.app')

@section('title', 'Ver Datos del Grupo - ICATEGRO')

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden min-h-[500px] max-w-5xl mx-auto mt-8 relative mb-12">
        <!-- Header -->
        <div class="bg-[#d4b996] p-4 text-center">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <i class="fas fa-eye mr-3 text-gray-800"></i>
                VER DATOS DEL GRUPO
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
                        class="bg-white border-2 border-gray-800 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
                        @if($grupo->creador)
                            {{ $grupo->creador->name }} {{ $grupo->creador->lastname }} {{ $grupo->creador->lastname2 }}
                        @else
                            ADMINISTRADOR / SISTEMA
                        @endif
                    </div>
                </div>
                <div class="col-span-1 border-b border-gray-300 pb-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Fecha captura</div>
                    <div
                        class="bg-white border-2 border-gray-800 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
                        {{ $grupo->created_at->format('d/m/Y \a \l\a\s H:i:s') }}
                    </div>
                </div>
                <div class="col-span-1 border-b border-gray-300 pb-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Estatus</div>
                    <div
                        class="bg-white border-2 border-gray-800 rounded-full px-4 py-2 text-sm font-bold text-gray-800 flex items-center shadow-inner">
                        <span class="w-4 h-4 rounded-full mr-3 shadow-sm 
                                @if(strtoupper($grupo->estatus) == 'PENDIENTE') bg-yellow-500 
                                @elseif(strtoupper($grupo->estatus) == 'AUTORIZADO') bg-green-600 
                                @elseif(strtoupper($grupo->estatus) == 'PROCESO' || strtoupper($grupo->estatus) == 'PROCESS') bg-blue-500 
                                @elseif(strtoupper($grupo->estatus) == 'CONCLUIDO') bg-purple-700 
                                @elseif(strtoupper($grupo->estatus) == 'RECHAZADO') bg-red-600 
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
                        class="bg-white border-2 border-gray-800 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
                        {{ $grupo->plantel ? $grupo->plantel->name : 'NO ASIGNADO' }}
                    </div>
                </div>
                <div class="col-span-1 border-b border-gray-300 pb-2 mt-2">
                    <div class="text-[#a02142] font-bold text-sm mb-1">Estatus Director/encargado</div>
                    <div
                        class="bg-white border-2 border-gray-800 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
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
                        class="bg-white border-2 border-gray-800 rounded-full px-4 py-2 text-sm font-bold text-gray-800 uppercase">
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
                    <div
                        class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                        {{ $grupo->id }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Número de grupo</label>
                    <div
                        class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                        {{ $grupo->numero_grupo ?? 'NO ASIGNADO' }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Tipo de servicio</label>
                    <div
                        class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                        {{ $grupo->tipo_servicio }}</div>
                </div>

                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Modalidad C.E.</label>
                    <div
                        class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                        {{ $grupo->modalidad_ce ?? 'N/A' }}</div>
                </div>

                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Modalidad</label>
                    <div
                        class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                        {{ $grupo->modalidad }}</div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-[#a02142] font-bold mb-1">Oferta Educativa</label>
                <div
                    class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                    {{ $grupo->ofertaEducativa ? $grupo->ofertaEducativa->name : 'N/A' }}</div>
            </div>

            <div class="mb-6">
                <label class="block text-[#a02142] font-bold mb-1">Campo de Formación Profesional</label>
                <div
                    class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                    {{ $grupo->campoFormacion ? $grupo->campoFormacion->name : 'N/A' }}</div>
            </div>

            <div class="mb-6">
                <label class="block text-[#a02142] font-bold mb-1">Especialidad Ocupacional</label>
                <div
                    class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                    {{ $grupo->especialidadOcupacional ? $grupo->especialidadOcupacional->name : 'N/A' }}</div>
            </div>

            <div class="mb-6">
                <label class="block text-[#a02142] font-bold mb-1">Curso</label>
                <div
                    class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">
                    @if($grupo->cursoIcategro)
                        {{ $grupo->cursoIcategro->name }}
                    @elseif($grupo->curso)
                        {{ $grupo->curso->name }}
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Alumnos inician</label>
                    <div
                        class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase md:w-1/2">
                        {{ $grupo->alumnos_inician }}</div>
                </div>

                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Capacidad máxima</label>
                    <div
                        class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase md:w-1/2">
                        {{ $grupo->capacidad_maxima }}</div>
                </div>
            </div>

            <!-- Section 3: Fechas, horario y duración del grupo -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Fechas, horario y duración del grupo</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha de inicio</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ \Carbon\Carbon::parse($grupo->fecha_inicio)->format('d-m-Y') }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha de término</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ \Carbon\Carbon::parse($grupo->fecha_termino)->format('d-m-Y') }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Duración días</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->duracion_dias }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Duración horas</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->duracion_horas }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 items-end">
                <div class="flex flex-col gap-6">
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1">Número de semanas del curso</label>
                        <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->numero_semanas }}</div>
                    </div>
                    <div>
                        <label class="block text-[#a02142] font-bold mb-1">Número de horas por semana</label>
                        <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ number_format($grupo->numero_horas_semana, 1) }}</div>
                    </div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Horario</label>
                    <div class="w-full border-2 border-gray-800 rounded-lg p-3 px-4 bg-white font-bold text-gray-800 uppercase min-h-[105px]">{{ $grupo->horario }}</div>
                </div>
            </div>

            <!-- Section 4: Calendario -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Calendario</span>
                </div>
            </div>

            <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                <table id="calendarioTable" class="w-full text-sm text-center">
                    <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                        <tr>
                            <th class="py-3 px-2 w-10"></th>
                            <th class="py-3 px-2">Tipo</th>
                            <th class="py-3 px-2">Fecha inicial</th>
                            <th class="py-3 px-2">Fecha final</th>
                            <th class="py-3 px-2">Hora inicial</th>
                            <th class="py-3 px-2">Hora final</th>
                            <th class="py-3 px-2">Total días</th>
                            <th class="py-3 px-2">Total horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupo->calendarios ?? [] as $calendario)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-2 px-2 text-center text-blue-500"><i class="fas fa-calendar-alt text-lg icon-calendario-deploy cursor-pointer hover:text-blue-700 transition" data-start="{{ \Carbon\Carbon::parse($calendario->fecha_inicial)->format('Y-m-d') }}" data-end="{{ $calendario->fecha_final ? \Carbon\Carbon::parse($calendario->fecha_final)->format('Y-m-d') : \Carbon\Carbon::parse($calendario->fecha_inicial)->format('Y-m-d') }}"></i></td>
                                <td class="py-2 px-2 uppercase">{{ $calendario->tipo_fecha }}</td>
                                <td class="py-2 px-2">{{ \Carbon\Carbon::parse($calendario->fecha_inicial)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2">{{ $calendario->fecha_final ? \Carbon\Carbon::parse($calendario->fecha_final)->format('d/m/Y') : '' }}</td>
                                <td class="py-2 px-2">{{ \Carbon\Carbon::parse($calendario->hora_inicial)->format('H:i') }}</td>
                                <td class="py-2 px-2">{{ \Carbon\Carbon::parse($calendario->hora_final)->format('H:i') }}</td>
                                <td class="py-2 px-2">{{ $calendario->total_dias }}</td>
                                <td class="py-2 px-2">{{ number_format($calendario->total_horas, 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Section 5: Ubicación del grupo -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Ubicación del grupo</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Sede del grupo</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->plantel ? $grupo->plantel->name : 'N/A' }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Estado</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->estado }}</div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-[#a02142] font-bold mb-1">Municipio</label>
                <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->municipio }}</div>
            </div>

            <div class="mb-6">
                <label class="block text-[#a02142] font-bold mb-1">Localidad</label>
                <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->localidad }}</div>
            </div>

            <div class="mb-10">
                <label class="block text-[#a02142] font-bold mb-1">Nombre del espacio</label>
                <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->nombre_espacio }}</div>
            </div>

            <!-- Section 6: Convenio -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Convenio</span>
                </div>
            </div>

            <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                <table class="w-full text-sm text-center">
                    <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                        <tr>
                            <th class="py-3 px-2 w-16">Opción</th>
                            <th class="py-3 px-2">Tipo</th>
                            <th class="py-3 px-2">Número</th>
                            <th class="py-3 px-2 text-left">Nombre</th>
                            <th class="py-3 px-2 text-left">Objeto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grupo->convenios ?? [] as $convenio)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-2 text-center text-gray-800"><i class="fas fa-eye text-lg"></i></td>
                                <td class="py-3 px-2 uppercase">{{ $convenio->type }}</td>
                                <td class="py-3 px-2 uppercase">{{ $convenio->number }}</td>
                                <td class="py-3 px-2 uppercase text-left break-words min-w-[200px]">{{ $convenio->name }}</td>
                                <td class="py-3 px-2 uppercase text-left break-words min-w-[250px]">{{ $convenio->object }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-gray-500 bg-gray-50">No hay convenios registrados para este grupo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Section 7: Instructores -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Instructor(es)</span>
                </div>
            </div>

            <!-- Legends -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-sm mt-4">
                <div>
                    <div class="font-bold text-gray-800 mb-2">Tipo de instructor</div>
                    <div class="flex items-center mb-1 text-gray-700 font-bold"><i class="fas fa-file-invoice-dollar text-green-600 w-6 text-lg"></i> HONORARIOS</div>
                    <div class="flex items-center text-gray-700 font-bold"><i class="fas fa-handshake text-red-600 w-6 text-lg"></i> SIN PAGO AL INSTRUCTOR</div>
                </div>
                <div>
                    <div class="font-bold text-gray-800 mb-2">Tipo de pago</div>
                    <div class="flex items-center mb-1 text-gray-700 font-bold"><i class="fas fa-credit-card text-blue-500 w-6 text-lg"></i> TRANSFERENCIA BANCARIA</div>
                    <div class="flex items-center mb-1 text-gray-700 font-bold"><i class="fas fa-money-check-alt text-green-600 w-6 text-lg"></i> CHEQUE</div>
                    <div class="flex items-center text-gray-700 font-bold"><i class="fas fa-ban text-red-600 w-6 text-lg"></i> NO APLICA</div>
                </div>
            </div>

            <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                <table class="w-full text-xs text-center border-collapse">
                    <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300 align-bottom">
                        <tr>
                            <th class="py-2 px-1 w-8"></th>
                            <th class="py-2 px-1 text-left">ID</th>
                            <th class="py-2 px-1 text-left">Nombre</th>
                            <th class="py-2 px-1 text-left">Apellido 1</th>
                            <th class="py-2 px-1 text-left">Apellido 2</th>
                            <th class="py-2 px-1">Tipo</th>
                            <th class="py-2 px-1">Pago<br>instructor</th>
                            <th class="py-2 px-1">Fecha<br>inicia</th>
                            <th class="py-2 px-1">Fecha<br>termina</th>
                            <th class="py-2 px-1">Horas</th>
                            <th class="py-2 px-1">Días</th>
                            <th class="py-2 px-1 text-left min-w-[150px]">Horario</th>
                            <th class="py-2 px-1">Fecha<br>pago</th>
                            <th class="py-2 px-1">Tipo<br>pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grupo->instructores ?? [] as $instructor)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-1 text-center text-blue-500">
                                    @can('leer_instructores')
                                        <a href="{{ route('instructores.show', $instructor->id) }}"><i class="fas fa-eye text-lg hover:text-blue-700 transition"></i></a>
                                    @else
                                        <i class="fas fa-eye text-lg text-gray-400 cursor-not-allowed" title="Sin permiso"></i>
                                    @endcan
                                </td>
                                <td class="py-3 px-1 text-left">{{ $instructor->id }}</td>
                                <td class="py-3 px-1 text-left uppercase break-words">{{ $instructor->nombre }}</td>
                                <td class="py-3 px-1 text-left uppercase">{{ $instructor->apellido_1 }}</td>
                                <td class="py-3 px-1 text-left uppercase">{{ $instructor->apellido_2 }}</td>
                                <td class="py-3 px-1 text-center text-[22px]">
                                    @if(strtoupper($instructor->pivot->tipo) == 'HONORARIOS')
                                        <i class="fas fa-file-invoice-dollar text-green-600" title="HONORARIOS"></i>
                                    @elseif(strtoupper($instructor->pivot->tipo) == 'SIN PAGO AL INSTRUCTOR' || strtoupper($instructor->pivot->tipo) == 'SIN PAGO')
                                        <i class="fas fa-handshake text-red-600" title="SIN PAGO AL INSTRUCTOR"></i>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-1">{{ floatval($instructor->pivot->pago_instructor) }}</td>
                                <td class="py-3 px-1">{{ \Carbon\Carbon::parse($instructor->pivot->fecha_inicio)->format('d/m/Y') }}</td>
                                <td class="py-3 px-1">{{ \Carbon\Carbon::parse($instructor->pivot->fecha_termino)->format('d/m/Y') }}</td>
                                <td class="py-3 px-1">{{ $instructor->pivot->duracion_horas }}</td>
                                <td class="py-3 px-1">{{ $instructor->pivot->duracion_dias }}</td>
                                <td class="py-3 px-1 text-left uppercase text-[10px] break-words">{{ $instructor->pivot->horario }}</td>
                                <td class="py-3 px-1">{{ $instructor->pivot->fecha_pago ? \Carbon\Carbon::parse($instructor->pivot->fecha_pago)->format('d/m/Y') : '' }}</td>
                                <td class="py-3 px-1 text-center text-xl">
                                    @if(strtoupper($instructor->pivot->tipo_pago) == 'TRANSFERENCIA BANCARIA' || strtoupper($instructor->pivot->tipo_pago) == 'TRANSFERENCIA')
                                        <i class="fas fa-credit-card text-blue-500" title="TRANSFERENCIA BANCARIA"></i>
                                    @elseif(strtoupper($instructor->pivot->tipo_pago) == 'CHEQUE')
                                        <i class="fas fa-money-check-alt text-green-600" title="CHEQUE"></i>
                                    @elseif(strtoupper($instructor->pivot->tipo_pago) == 'NO APLICA')
                                        <i class="fas fa-ban text-red-600" title="NO APLICA"></i>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="py-4 text-gray-500 bg-gray-50 text-center">No hay instructores asignados a este grupo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Section 8: Finanzas -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Finanzas</span>
                </div>
            </div>

            <div class="mb-6 mt-4">
                <label class="block text-[#a02142] font-bold mb-1">Tipo de pago</label>
                <div class="w-full md:w-1/2 border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->tipo_pago_grupo }}</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Costo por persona</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ floatval($grupo->costo_por_persona) }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Costo por grupo</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ floatval($grupo->costo_por_grupo) }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Costo del coffee-break</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ floatval($grupo->costo_coffee_break) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Ingreso total del grupo</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ floatval($grupo->ingreso_total) }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Utilidad calculada del grupo</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ floatval($grupo->utilidad_grupo) }}</div>
                </div>
            </div>

            <!-- Section 9: Archivos -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Archivos</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12 mt-8 px-8">
                <div class="flex flex-col items-center">
                    <div class="text-[#a02142] font-bold text-center text-lg mb-4">Archivo de plan de estudios</div>
                    @if($grupo->archivo_plan_estudios)
                        <a href="{{ asset('storage/' . $grupo->archivo_plan_estudios) }}" target="_blank" class="flex items-center justify-center bg-gray-800 hover:bg-gray-700 text-white px-8 py-5 rounded-[2rem] shadow-lg transition transform hover:-translate-y-1">
                            <i class="fas fa-file-download text-[#d4b996] text-5xl mr-5"></i>
                            <span class="text-xl font-medium tracking-wide">Descargar</span>
                        </a>
                    @else
                        <div class="flex items-center justify-center bg-gray-200 text-gray-500 px-8 py-5 rounded-[2rem] border-2 border-gray-300">
                            <i class="fas fa-file-excel text-gray-400 text-5xl mr-5"></i>
                            <span class="text-xl font-medium tracking-wide">Sin archivo</span>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-[#a02142] font-bold text-center text-lg mb-4">Archivo de becas del grupo</div>
                    @if($grupo->archivo_becas)
                        <a href="{{ asset('storage/' . $grupo->archivo_becas) }}" target="_blank" class="flex items-center justify-center bg-gray-800 hover:bg-gray-700 text-white px-8 py-5 rounded-[2rem] shadow-lg transition transform hover:-translate-y-1">
                            <i class="fas fa-file-download text-[#d4b996] text-5xl mr-5"></i>
                            <span class="text-xl font-medium tracking-wide">Descargar</span>
                        </a>
                    @else
                        <div class="flex items-center justify-center bg-gray-200 text-gray-500 px-8 py-5 rounded-[2rem] border-2 border-gray-300">
                            <i class="fas fa-file-excel text-gray-400 text-5xl mr-5"></i>
                            <span class="text-xl font-medium tracking-wide">Sin archivo</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 10: Comentarios -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Comentarios</span>
                </div>
            </div>

            <div class="mb-10 mt-4">
                <label class="block text-[#a02142] font-bold mb-1">Comentarios</label>
                <div class="w-full border-2 border-gray-800 rounded-lg p-3 px-4 bg-white font-bold text-gray-800 uppercase min-h-[100px]">{{ $grupo->comentarios }}</div>
            </div>

            <!-- Section 11: Última modificación -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Última modificación</span>
                </div>
            </div>

            @php
                $ultimaModificacion = $grupo->revisiones->last();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Modificado por</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $ultimaModificacion && $ultimaModificacion->user ? $ultimaModificacion->user->name . ' ' . $ultimaModificacion->user->lastname . ' ' . $ultimaModificacion->user->lastname2 : 'SIN MODIFICACIONES' }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha modificación</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $ultimaModificacion ? $ultimaModificacion->created_at->format('d/m/Y \a \l\a\s H:i:s') : 'SIN MODIFICACIONES' }}</div>
                </div>
            </div>

            <!-- Section 12: Autorización -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Autorización</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Autorizado por</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->autorizado_por ?? 'NO AUTORIZADO AÚN' }}</div>
                </div>
                <div>
                    <label class="block text-[#a02142] font-bold mb-1">Fecha autorización</label>
                    <div class="w-full border-2 border-gray-800 rounded-full p-2 px-4 bg-white font-bold text-gray-800 uppercase">{{ $grupo->fecha_autorizacion ? \Carbon\Carbon::parse($grupo->fecha_autorizacion)->format('d/m/Y \a \l\a\s H:i:s') : 'N/A' }}</div>
                </div>
            </div>

            <!-- Section 13: Revisiones -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Revisiones</span>
                </div>
            </div>

            <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                <table id="revisiones_table" class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-300">
                        <tr>
                            <th class="py-3 px-2">Estatus</th>
                            <th class="py-3 px-2">Observaciones</th>
                            <th class="py-3 px-2">Fecha revisión</th>
                            <th class="py-3 px-2">Revisado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupo->revisiones as $revision)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-2 px-2 uppercase font-bold flex items-center h-full">
                                    <span class="w-4 h-4 rounded-full mr-2 shadow-sm 
                                        @if(strtoupper($revision->estatus) == 'PENDIENTE') bg-yellow-500 
                                        @elseif(strtoupper($revision->estatus) == 'AUTORIZADO') bg-green-600 
                                        @elseif(strtoupper($revision->estatus) == 'PROCESO' || strtoupper($revision->estatus) == 'PROCESS') bg-blue-500 
                                        @elseif(strtoupper($revision->estatus) == 'CONCLUIDO') bg-purple-700 
                                        @elseif(strtoupper($revision->estatus) == 'RECHAZADO') bg-red-600 
                                        @else bg-gray-500 @endif
                                    "></span>
                                    <span>{{ $revision->estatus }}</span>
                                </td>
                                <td class="py-2 px-2 uppercase">{{ $revision->observaciones }}</td>
                                <td class="py-2 px-2 uppercase">{{ $revision->created_at->format('d/m/Y \a \l\a\s H:i:s') }}</td>
                                <td class="py-2 px-2 uppercase">{{ $revision->user ? $revision->user->name . ' ' . $revision->user->last_name . ' ' . $revision->user->last_name2 : 'SISTEMA' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Formulario de Revisión / Autorización -->
            <form action="{{ route('grupos.autorizar_submit', $grupo->id) }}" method="POST">
                @csrf
                <div class="mt-8 mb-6 text-[#a02142] font-bold text-lg flex items-center">
                    Estatus actual del grupo: 
                    <span class="text-gray-800 font-bold ml-2 flex items-center">
                        <span class="w-4 h-4 rounded-full mr-2 shadow-sm inline-block
                            @if(strtoupper($grupo->estatus) == 'PENDIENTE') bg-yellow-500 
                            @elseif(strtoupper($grupo->estatus) == 'AUTORIZADO') bg-green-600 
                            @elseif(strtoupper($grupo->estatus) == 'PROCESO' || strtoupper($grupo->estatus) == 'PROCESS') bg-blue-500 
                            @elseif(strtoupper($grupo->estatus) == 'CONCLUIDO') bg-purple-700 
                            @elseif(strtoupper($grupo->estatus) == 'RECHAZADO') bg-red-600 
                            @else bg-gray-500 @endif
                        "></span>
                        <span class="uppercase">{{ $grupo->estatus }}</span>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-4">
                    <div class="flex flex-col relative">
                        <label for="estatus" class="text-[#a02142] font-bold mb-2">* Estatus</label>
                        <select name="estatus" id="estatus" class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white uppercase font-bold text-gray-700" required>
                            <option value="">» SELECCIONE EL ESTATUS</option>
                            <option value="PENDIENTE">PENDIENTE</option>
                            <option value="PROCESO">PROCESO</option>
                            <option value="AUTORIZADO">AUTORIZAR</option>
                            <option value="RECHAZADO">RECHAZAR</option>
                            <option value="CANCELADO">CANCELAR</option>
                            <option value="CONCLUIDO">CONCLUIDO</option>
                        </select>
                        @error('estatus')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="observaciones" class="text-[#a02142] font-bold mb-2">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="4" maxlength="200"
                            class="w-full border-2 border-gray-400 rounded-lg p-3 px-4 focus:outline-none focus:border-red-500 bg-white uppercase resize-none font-bold text-gray-700 flex-grow"></textarea>
                        <div class="text-right text-gray-500 text-xs mt-1"><span id="char_count">0</span>/200 caracteres</div>
                        @error('observaciones')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex justify-between items-center bg-[#f2f9f9] p-4 rounded-lg mt-8 border border-[#e0ebeb] shadow-sm">
                    <a href="{{ route('grupos.index') }}"
                        class="bg-[#dc3545] hover:bg-[#c82333] text-white font-bold py-2 px-6 rounded shadow-md text-lg flex items-center transition">
                        Salir <i class="fas fa-sign-out-alt ml-2"></i>
                    </a>
                    
                    <button type="submit"
                        class="bg-[#1f2937] hover:bg-black text-white font-bold py-2 px-6 rounded shadow-md text-lg flex items-center transition">
                        Guardar <i class="fas fa-save ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .readonly-calendar .flatpickr-days { pointer-events: none; }
        .readonly-calendar .flatpickr-month { pointer-events: none; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#calendarioTable')) {
                $('#calendarioTable').DataTable().destroy();
            }
            $('#calendarioTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ entradas",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                dom: '<"flex justify-between items-center mb-4"l f>rt<"flex justify-between items-center mt-4"i p>',
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: 0 }
                ]
            });

            // Integración de flatpickr visual en miniatura para el ícono
            $('#calendarioTable').on('click', '.icon-calendario-deploy', function(e) {
                if (!this._flatpickr) {
                    var start = $(this).data('start');
                    var end = $(this).data('end');
                    flatpickr(this, {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        defaultDate: [start, end],
                        locale: "es",
                        clickOpens: false,
                        position: "auto left",
                        nextArrow: "",
                        prevArrow: "",
                        onReady: function(selectedDates, dateStr, instance) {
                            instance.calendarContainer.classList.add("readonly-calendar");
                            instance.calendarContainer.style.boxShadow = "0 10px 15px -3px rgba(0, 0, 0, 0.5)";
                        }
                    });
                }
                this._flatpickr.toggle();
            });

            if ($.fn.DataTable.isDataTable('#revisiones_table')) {
                $('#revisiones_table').DataTable().destroy();
            }
            $('#revisiones_table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ entradas",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
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
        });
    </script>
@endpush