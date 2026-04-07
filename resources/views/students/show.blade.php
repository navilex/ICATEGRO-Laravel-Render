@extends('layouts.app')

@section('title', 'Datos del Alumno - ICATEGRO')

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden pb-8">
        <!-- Header -->
        <div class="bg-[#e2cba4] p-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <i class="fas fa-eye mr-3"></i> VER DATOS DEL ALUMNO
            </h1>
        </div>

        <div class="mt-8 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Datos generales
            </div>
        </div>

        <div class="px-8 mt-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-8 gap-x-8">
                <!-- Row 1 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">ID alumno</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                        {{ $student->id }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Matrícula</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                        {{ $student->matricula }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">CURP</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                        {{ $student->curp }}
                    </div>
                </div>

                <!-- Row 2 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Fecha de nacimiento</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                        {{ $student->fecha_nacimiento }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Edad</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                        {{ $student->edad }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Sexo</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                        {{ $student->sexo }}
                    </div>
                </div>

                <!-- Row 3 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Nombre</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                        {{ $student->name }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Apellido 1</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                        {{ $student->lastname1 }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Apellido 2</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                        {{ $student->lastname2 }}
                    </div>
                </div>

                <!-- Row 4 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Tipo de sangre</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                        {{ $student->blood_type ?? 'N' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Estado civil</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                        {{ $student->civil_status ?? 'N' }}
                    </div>
                </div>
            </div>

            <div class="mt-12 relative flex items-center justify-center">
                <div class="absolute w-full z-0 px-8">
                    <div class="border-t-2 border-gray-400"></div>
                </div>
                <div
                    class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                    Domicilio
                </div>
            </div>

            <div class="px-8 mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                    <div>
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Estado</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->state ?? '' }}</div>
                    </div>
                    <div>
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Municipio</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->municipality ?? '' }}</div>
                    </div>

                    <div>
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Localidad</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->locality ?? '' }}</div>
                    </div>
                    <div>
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Colonia</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->colony ?? '' }}</div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-6 gap-y-8 gap-x-8">
                    <div class="md:col-span-3">
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Calle</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->street ?? '' }}</div>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Núm. exterior</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->exterior_number ?? '' }}</div>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Núm. interior</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->interior_number === 'N' ? '' : ($student->interior_number ?? '') }}</div>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Código postal</label>
                        <div
                            class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                            {{ $student->zip_code ?? '' }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-12 relative flex items-center justify-center">
                <div class="absolute w-full z-0 px-8">
                    <div class="border-t-2 border-gray-400"></div>
                </div>
                <div
                    class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                    Datos de contacto
                </div>
            </div>

            <div class="px-8 mt-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-y-8 gap-x-8">
                    <div>
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Teléfono 1</label>
                        <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                            {{ $student->phone1 ?? '' }}</div>
                    </div>
                    <div>
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Teléfono 2</label>
                        <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                            {{ $student->phone2 === '0' ? '' : ($student->phone2 ?? '') }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[#9b2242] font-bold mb-1 ml-2">Email</label>
                        <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">
                            {{ $student->email ?? '' }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-12 relative flex items-center justify-center">
                <div class="absolute w-full z-0 px-8">
                    <div class="border-t-2 border-gray-400"></div>
                </div>
                <div
                    class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                    Lista de cursos
                </div>
            </div>

            <div class="px-8 mt-8">
                <!-- Legends Section -->
                <div class="bg-white rounded-lg mb-6 border border-gray-200">
                    <!-- Estatus del grupo -->
                    <div class="bg-gray-500 text-white font-bold px-4 py-1 text-sm bg-opacity-90">Estatus del grupo</div>
                    <div class="px-4 py-3 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-700 font-semibold uppercase">
                        <div class="flex items-center"><span
                                class="w-4 h-4 rounded-full bg-yellow-400 mr-2"></span>Pendiente</div>
                        <div class="flex items-center"><span class="w-4 h-4 rounded-full bg-red-500 mr-2"></span>Rechazado
                        </div>
                        <div class="flex items-center"><span
                                class="w-4 h-4 rounded-full bg-green-600 mr-2"></span>Autorizado</div>
                        <div class="flex items-center"><span class="w-4 h-4 rounded-full bg-blue-500 mr-2"></span>Proceso
                        </div>
                        <div class="flex items-center"><span
                                class="w-4 h-4 rounded-full bg-fuchsia-500 mr-2"></span>Calificado</div>
                        <div class="flex items-center"><span
                                class="w-4 h-4 rounded-full bg-purple-700 mr-2"></span>Concluido</div>
                        <div class="flex items-center"><span class="w-4 h-4 rounded-full bg-gray-500 mr-2"></span>Cancelado
                        </div>
                    </div>

                    <!-- Estatus del alumno -->
                    <div class="bg-gray-500 text-white font-bold px-4 py-1 text-sm bg-opacity-90 border-t border-gray-300">
                        Estatus del alumno</div>
                    <div class="px-4 py-3 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-700 font-semibold uppercase">
                        <div class="flex items-center"><i class="fas fa-thumbs-up text-green-600 text-lg mr-2"></i>Aprobado
                        </div>
                        <div class="flex items-center"><i class="fas fa-thumbs-down text-red-600 text-lg mr-2"></i>No
                            Aprobado</div>
                        <div class="flex items-center"><i class="fas fa-user-minus text-blue-700 text-lg mr-2"></i>Baja
                        </div>
                        <div class="flex items-center"><i class="fas fa-running text-orange-500 text-lg mr-2"></i>Desercion
                        </div>
                        <div class="flex items-center"><i class="fas fa-user-clock text-black text-lg mr-2"></i>Pendiente
                        </div>
                    </div>

                    <!-- Tipo de documento -->
                    <div class="bg-gray-500 text-white font-bold px-4 py-1 text-sm bg-opacity-90 border-t border-gray-300">
                        Tipo de documento</div>
                    <div class="px-4 py-3 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-700 font-semibold uppercase">
                        <div class="flex items-center"><i
                                class="fas fa-file-invoice text-green-600 text-lg mr-2"></i>Constancia</div>
                        <div class="flex items-center"><i class="fas fa-file-excel text-red-600 text-lg mr-2"></i>No aplica
                        </div>
                        <div class="flex items-center"><i class="fas fa-clock text-black text-lg mr-2"></i>Pendiente</div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 mt-4 border-b border-gray-300">
                        <thead class="text-xs text-gray-800 uppercase bg-gray-50 border-b-2 border-gray-300">
                            <tr>
                                <th class="px-2 py-3 font-bold">Estatus<br>grupo</th>
                                <th class="px-2 py-3 font-bold">Plantel</th>
                                <th class="px-2 py-3 font-bold">ID<br>grupo</th>
                                <th class="px-2 py-3 font-bold">Nombre</th>
                                <th class="px-2 py-3 font-bold">Fecha<br>de inicio</th>
                                <th class="px-2 py-3 font-bold">Fecha<br>de término</th>
                                <th class="px-2 py-3 font-bold" title="Estatus del alumno">Estatus</th>
                                <th class="px-2 py-3 font-bold">Calif.</th>
                                <th class="px-2 py-3 font-bold">Tipo<br>de doc.</th>
                                <th class="px-2 py-3 font-bold">Folio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($student->cursos as $curso)
                                @php
                                    // Map Group Status to color
                                    $statusColor = 'bg-gray-300';
                                    switch (strtoupper($curso->grupo->estatus)) {
                                        case 'PENDIENTE':
                                            $statusColor = 'bg-yellow-400';
                                            break;
                                        case 'RECHAZADO':
                                            $statusColor = 'bg-red-500';
                                            break;
                                        case 'AUTORIZADO':
                                            $statusColor = 'bg-green-600';
                                            break;
                                        case 'PROCESO':
                                            $statusColor = 'bg-blue-500';
                                            break;
                                        case 'CALIFICADO':
                                            $statusColor = 'bg-fuchsia-500';
                                            break;
                                        case 'CONCLUIDO':
                                            $statusColor = 'bg-purple-700';
                                            break;
                                        case 'CANCELADO':
                                            $statusColor = 'bg-gray-500';
                                            break;
                                        default:
                                            $statusColor = 'bg-black';
                                            break;
                                    }

                                    // Map Student Status to icon
                                    $studentStatusIcon = '';
                                    switch (strtoupper($curso->student_status)) {
                                        case 'APROBADO':
                                            $studentStatusIcon = '<i class="fas fa-thumbs-up text-green-600 text-lg"></i>';
                                            break;
                                        case 'NO APROBADO':
                                            $studentStatusIcon = '<i class="fas fa-thumbs-down text-red-600 text-lg"></i>';
                                            break;
                                        case 'BAJA':
                                            $studentStatusIcon = '<i class="fas fa-user-minus text-blue-700 text-lg"></i>';
                                            break;
                                        case 'DESERCION':
                                            $studentStatusIcon = '<i class="fas fa-running text-orange-500 text-lg"></i>';
                                            break;
                                        case 'PENDIENTE':
                                            $studentStatusIcon = '<i class="fas fa-user-clock text-black text-lg"></i>';
                                            break;
                                    }

                                    // Map Doc Type to icon
                                    $docTypeIcon = '';
                                    switch (strtoupper($curso->doc_type)) {
                                        case 'CONSTANCIA':
                                            $docTypeIcon = '<i class="fas fa-file-invoice text-green-600 text-lg"></i>';
                                            break;
                                        case 'NO APLICA':
                                            $docTypeIcon = '<i class="fas fa-file-excel text-red-600 text-lg"></i>';
                                            break;
                                        case 'PENDIENTE':
                                            $docTypeIcon = '<i class="fas fa-clock text-black text-lg"></i>';
                                            break;
                                    }
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-2 py-3 text-center">
                                        <span class="inline-block w-4 h-4 rounded-full {{ $statusColor }}"></span>
                                    </td>
                                    <td class="px-2 py-3 uppercase">{{ $curso->grupo->plantel->name ?? 'N/A' }}</td>
                                    <td class="px-2 py-3">{{ $curso->group_id }}</td>
                                    <td class="px-2 py-3 uppercase text-blue-600 font-semibold cursor-pointer hover:underline">
                                        <i class="fas fa-eye mr-1"></i> {{ $curso->curso->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-2 py-3">
                                        {{ $curso->start_date ? \Carbon\Carbon::parse($curso->start_date)->format('d/m/Y') : '' }}
                                    </td>
                                    <td class="px-2 py-3">
                                        {{ $curso->end_date ? \Carbon\Carbon::parse($curso->end_date)->format('d/m/Y') : '' }}
                                    </td>
                                    <td class="px-2 py-3 text-center">{!! $studentStatusIcon !!}</td>
                                    <td class="px-2 py-3">{{ $curso->calificacion ?? '-' }}</td>
                                    <td class="px-2 py-3 text-center">{{ $curso->doc_type ?? '-' }}</td>
                                    <td class="px-2 py-3">{{ $curso->folio ?? 'PENDIENTE' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-4 text-center text-gray-500 italic">No hay cursos
                                        registrados para este alumno.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Registro
            </div>
        </div>

        <div class="px-8 mt-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-y-8 gap-x-8">
                <div class="md:col-span-1">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">ID usuario capturó</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">{{ $student->user_id ?? '' }}</div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Registrado por</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">
                        {{ $student->creator ? $student->creator->name . ' ' . $student->creator->lastname : '' }}
                    </div>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Fecha captura</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white">{{ $student->created_at ? $student->created_at->format('d/m/Y H:i:s') : '' }}</div>
                </div>
                
                <div class="md:col-span-4">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Plantel</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase">{{ $student->creator->adscription ?? '' }}</div>
                </div>
            </div>
        </div>

        <!-- Section background below content similar to the image -->
        <div class="bg-cyan-50 mt-12 py-6 border-t border-gray-200">
            <div class="flex justify-center">
                <a href="{{ route('students.index') }}"
                    class="bg-[#dc3545] hover:bg-red-700 text-white font-bold py-2 px-8 rounded-lg shadow transition flex items-center">
                    Salir <i class="fas fa-sign-out-alt ml-2"></i>
                </a>
            </div>
        </div>
    </div>
@endsection