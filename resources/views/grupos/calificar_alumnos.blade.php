@extends('layouts.app')

@section('title', 'Calificar Alumnos - ICATEGRO')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl text-sm">
        <!-- Header CALIFICAR ALUMNOS -->
        <div class="bg-[#d4b996] p-4 text-center">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <i class="fas fa-edit mr-3 text-gray-800"></i>
                CALIFICAR ALUMNOS
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
                        {{-- Usamos la relación directa 'creador' cargada en el controlador --}}
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

            <!-- Section 3: Calificar alumnos -->
            <div class="relative mb-8 text-center mt-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-400"></div>
                </div>
                <div class="relative flex justify-center">
                    <span
                        class="px-6 py-1 bg-gray-600 text-white rounded-full text-lg shadow-md border-2 border-gray-500">Calificar
                        alumnos</span>
                </div>
            </div>

            <form action="{{ route('grupos.calificar.store', $grupo->id) }}" method="POST" id="formCalificar">
                @csrf

                <!-- Leyenda de Estatus -->
                <div class="mb-6 px-4">
                    <h4 class="font-bold text-sm text-gray-800 mb-3">Estatus</h4>
                    <div class="flex flex-wrap items-center gap-6 text-sm font-semibold text-gray-700">
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

                <!-- Tabla de Calificar -->
                <div class="overflow-x-auto bg-white rounded shadow-sm border border-gray-200 mt-4 mb-4">
                    <table id="alumnos_table" class="w-full text-left border-collapse min-w-max text-xs sm:text-sm">
                        <thead>
                            <tr
                                class="bg-gray-100 text-gray-800 font-bold border-b-2 border-gray-300 text-center uppercase text-[11px]">
                                <th class="py-3 px-2 w-16">Opciones</th>
                                <th class="py-3 px-2">ID Alumno</th>
                                <th class="py-3 px-2">CURP</th>
                                <th class="py-3 px-2">Nombre</th>
                                <th class="py-3 px-2">Apellido 1</th>
                                <th class="py-3 px-2">Apellido 2</th>
                                <th class="py-3 px-2 w-48">Estatus del alumno</th>
                                <th class="py-3 px-2 w-40">Calificación del alumno</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center text-gray-700 font-semibold border-b border-gray-200 bg-gray-50 text-[11px]">
                            @forelse($grupo->listaAlumnos as $index => $ins)
                                @php
                                    $alumno = $ins->student;
                                @endphp
                                @if($alumno)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition">
                                        <td class="py-3 px-2">
                                            <input type="hidden" name="alumnos[{{ $index }}][student_id]" value="{{ $alumno->id }}">
                                            <!-- Ojo azul -->
                                            <a href="#" class="text-blue-500 hover:text-blue-700 transition" title="Ver alumno">
                                                <i class="fas fa-eye text-lg"></i>
                                            </a>
                                        </td>
                                        <td class="py-3 px-2">{{ $alumno->id }}</td>
                                        <td class="py-3 px-2 uppercase">{{ $alumno->curp }}</td>
                                        <td class="py-3 px-2 uppercase">{{ $alumno->name }}</td>
                                        <td class="py-3 px-2 uppercase">{{ $alumno->lastname1 }}</td>
                                        <td class="py-3 px-2 uppercase">{{ $alumno->lastname2 }}</td>
                                        <td class="py-3 px-2">
                                            <div class="relative w-full">
                                                <select name="alumnos[{{ $index }}][estatus]"
                                                    class="estatus-select w-full border-2 border-gray-300 rounded-full py-1 text-xs px-3 focus:outline-none focus:border-blue-400 bg-white shadow-sm font-bold text-gray-600"
                                                    required>
                                                    <option value="">» SELECCIONE</option>
                                                    <option value="APROBADO" {{ $ins->student_status === 'APROBADO' ? 'selected' : '' }}>APROBADO</option>
                                                    <option value="NO APROBADO" {{ $ins->student_status === 'NO APROBADO' ? 'selected' : '' }}>NO APROBADO</option>
                                                    <option value="BAJA" {{ $ins->student_status === 'BAJA' ? 'selected' : '' }}>BAJA
                                                    </option>
                                                    <option value="DESERCION" {{ $ins->student_status === 'DESERCION' ? 'selected' : '' }}>DESERCION</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2">
                                            <div class="relative w-full">
                                                <select name="alumnos[{{ $index }}][calificacion]"
                                                    class="calificacion-select w-full border-2 border-gray-300 rounded-full py-1 text-xs px-3 focus:outline-none focus:border-blue-400 bg-white shadow-sm font-bold text-gray-600"
                                                    required>
                                                    <option value="">» SELECCIONE</option>
                                                    <option value="5" {{ $ins->calificacion == 5 ? 'selected' : '' }}>5</option>
                                                    <option value="6" {{ $ins->calificacion == 6 ? 'selected' : '' }}>6</option>
                                                    <option value="7" {{ $ins->calificacion == 7 ? 'selected' : '' }}>7</option>
                                                    <option value="8" {{ $ins->calificacion == 8 ? 'selected' : '' }}>8</option>
                                                    <option value="9" {{ $ins->calificacion == 9 ? 'selected' : '' }}>9</option>
                                                    <option value="10" {{ $ins->calificacion == 10 ? 'selected' : '' }}>10</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500 font-bold">No hay alumnos inscritos en
                                        este grupo para calificar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Botones Finales Guardar/Salir -->
                <div
                    class="flex justify-between items-center bg-teal-50 border-t border-teal-100 p-4 rounded-b-lg mt-8 shadow-inner">
                    <a href="{{ route('grupos.index') }}"
                        class="bg-[#d9534f] hover:bg-[#c9302c] text-white font-bold py-2 px-6 rounded-lg flex items-center transition shadow-md border border-[#d43f3a]">
                        Salir <i class="fas fa-sign-out-alt ml-2"></i>
                    </a>

                    @if($grupo->listaAlumnos->count() > 0)
                        <button type="submit" id="btnGuardarCalificaciones"
                            class="bg-[#1f2937] hover:bg-black text-white font-bold py-2 px-6 rounded-lg flex items-center transition shadow-md border border-gray-800">
                            Guardar <i class="fas fa-save ml-2"></i>
                        </button>
                    @endif
                </div>

            </form>

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
                    dom: '<"flex justify-between items-center mb-4"l f>rt<"flex flex-col sm:flex-row justify-between items-center mt-4 border-t border-gray-200 pt-4"i p>',
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
                    pageLength: 25
                });

                // Lógica Select Anidados (Validación de Frente)
                $('.estatus-select').on('change', function () {
                    let estatus = $(this).val();
                    let calificacionSelect = $(this).closest('tr').find('.calificacion-select');

                    calificacionSelect.empty();
                    calificacionSelect.append('<option value="">» SELECCIONE</option>');

                    if (estatus === 'APROBADO') {
                        calificacionSelect.append('<option value="6">6</option>');
                        calificacionSelect.append('<option value="7">7</option>');
                        calificacionSelect.append('<option value="8">8</option>');
                        calificacionSelect.append('<option value="9">9</option>');
                        calificacionSelect.append('<option value="10">10</option>');
                    } else if (estatus === 'NO APROBADO' || estatus === 'BAJA' || estatus === 'DESERCION') {
                        calificacionSelect.append('<option value="5">5</option>');
                    }
                });

                // Forzar trigger inicial renderizando para aquellos previamente guardados
                $('.estatus-select').each(function () {
                    let currentStatus = $(this).val();
                    if (currentStatus) {
                        let calificacionSelect = $(this).closest('tr').find('.calificacion-select');
                        let currentGrade = calificacionSelect.find('option:selected').val();

                        calificacionSelect.empty();
                        calificacionSelect.append('<option value="">» SELECCIONE</option>');

                        if (currentStatus === 'APROBADO') {
                            [6, 7, 8, 9, 10].forEach(n => calificacionSelect.append('<option value="' + n + '" ' + (currentGrade == n ? 'selected' : '') + '>' + n + '</option>'));
                        } else if (currentStatus === 'NO APROBADO' || currentStatus === 'BAJA' || currentStatus === 'DESERCION') {
                            calificacionSelect.append('<option value="5" ' + (currentGrade == 5 ? 'selected' : '') + '>5</option>');
                        }
                    }
                });

                // AJAX Confirmar Guardado
                $('#formCalificar').on('submit', function (e) {
                    e.preventDefault();

                    let allValid = true;

                    // Porque datatables pagina y saca rows del DOM invisible temporal, 
                    // debemos destruir provisionalmente para poder serializar completo o usar el API.
                    // Como es poco común destruir, usamos el objeto interno $()
                    let rows = alumnosTable.$('tr');

                    // Verificar que no haya campos vacíos
                    rows.each(function () {
                        let st = $(this).find('.estatus-select').val();
                        let cal = $(this).find('.calificacion-select').val();
                        if (!st || !cal) {
                            allValid = false;
                        }
                    });

                    if (!allValid) {
                        Swal.fire({
                            title: 'Datos Incompletos',
                            text: 'Asegúrese de seleccionar un estatus y calificación para TODOS los alumnos inscritos',
                            icon: 'warning',
                            confirmButtonColor: '#1f2937'
                        });
                        return;
                    }

                    let form = $(this);
                    let btn = $('#btnGuardarCalificaciones');
                    let originalHtml = btn.html();

                    btn.html('Guardando... <i class="fas fa-spinner fa-spin ml-2"></i>').prop('disabled', true);

                    // Serializar TODA la tabla a través de datatables
                    let dtData = alumnosTable.$('input, select').serialize();

                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: dtData + '&_token={{ csrf_token() }}',
                        success: function (response) {
                            btn.html(originalHtml).prop('disabled', false);

                            if (response.success) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#1f2937'
                                }).then(() => {
                                    window.location.href = "{{ route('grupos.index') }}";
                                });
                            } else {
                                Swal.fire('Atención', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            btn.html(originalHtml).prop('disabled', false);
                            let msg = xhr.responseJSON ? (xhr.responseJSON.message || 'Error en validación') : 'Error de servidor';
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                });

            });
        </script>
    @endpush