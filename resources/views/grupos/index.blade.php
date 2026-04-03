@extends('layouts.app')

@section('title', 'Listado de Grupos - ICATEGRO')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            padding: 0.25rem 2rem 0.25rem 0.5rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
            margin-left: 0.5rem;
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

@php
    function mapColor($estatus)
    {
        switch (strtoupper($estatus)) {
            case 'PENDIENTE':
                return 'bg-yellow-500';
            case 'RECHAZADO':
                return 'bg-red-600';
            case 'AUTORIZADO':
                return 'bg-green-600';
            case 'PROCESO':
                return 'bg-blue-500';
            case 'CALIFICADO':
                return 'bg-fuchsia-500';
            case 'CONCLUIDO':
                return 'bg-purple-700';
            case 'CANCELADO':
                return 'bg-gray-500';
            default:
                return 'bg-gray-400';
        }
    }
@endphp

@section('content')
    <div class="max-w-7xl mx-auto space-y-8 mt-8">

        <!-- List Container -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden pb-8">
            <!-- Header -->
            <div class="bg-[#d4b996] p-6 text-center shadow-sm">
                <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                    <span
                        class="bg-gray-800 text-white text-xl w-8 h-8 rounded-md flex items-center justify-center mr-3 shadow">
                        <i class="fas fa-list-ul text-sm"></i>
                    </span>
                    LISTADO DE GRUPOS
                </h1>
            </div>

            <!-- Estatus Legend -->
            <div class="px-8 pt-6 pb-2">
                <h3 class="text-red-800 font-bold mb-3 uppercase">ESTATUS DE GRUPO</h3>
                <div class="flex flex-wrap gap-4 text-xs font-bold text-gray-800">
                    <div class="flex items-center"><span
                            class="w-4 h-4 rounded-full bg-yellow-500 inline-block mr-2"></span>PENDIENTE</div>
                    <div class="flex items-center"><span
                            class="w-4 h-4 rounded-full bg-red-600 inline-block mr-2"></span>RECHAZADO</div>
                    <div class="flex items-center"><span
                            class="w-4 h-4 rounded-full bg-green-600 inline-block mr-2"></span>AUTORIZADO</div>
                    <div class="flex items-center"><span
                            class="w-4 h-4 rounded-full bg-blue-500 inline-block mr-2"></span>PROCESO</div>
                    <div class="flex items-center"><span
                            class="w-4 h-4 rounded-full bg-fuchsia-500 inline-block mr-2"></span>CALIFICADO</div>
                    <div class="flex items-center"><span
                            class="w-4 h-4 rounded-full bg-purple-700 inline-block mr-2"></span>CONCLUIDO</div>
                    <div class="flex items-center"><span
                            class="w-4 h-4 rounded-full bg-gray-500 inline-block mr-2"></span>CANCELADO</div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="p-8">
                <div class="w-full">
                    <table id="gruposTable" class="w-full text-xs text-left text-gray-600 stripe hover rounded-lg">
                        <thead class="text-xs text-gray-800 font-bold bg-white border-b-2 border-gray-300">
                            <tr>
                                <th class="px-2 py-3">Plantel</th>
                                <th class="px-2 py-3 text-center">Opciones</th>
                                <th class="px-2 py-3 text-center">Impresiones</th>
                                <th class="px-2 py-3 text-center">No.<br>Solicitud</th>
                                <th class="px-2 py-3 text-center">Estatus</th>
                                <th class="px-2 py-3">Curso</th>
                                <th class="px-2 py-3 text-center">Alumnos</th>
                                <th class="px-2 py-3">Fecha<br>inicio</th>
                                <th class="px-2 py-3">Fecha<br>termino</th>
                                <th class="px-2 py-3 text-center">Tipo<br>servicio</th>
                                <th class="px-2 py-3">Instructor(es)</th>
                                <th class="px-2 py-3">Tipo<br>pago</th>
                                <th class="px-2 py-3">Ingreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupos as $grupo)
                                @php
                                    $alumnosCount = $grupo->alumnos_inician ?? 0;
                                    $hasAlumnos = $alumnosCount > 0;
                                    $colorClass = mapColor($grupo->estatus);
                                @endphp
                                <tr class="border-b transition duration-150 hover:bg-gray-50">
                                    <td class="px-2 py-4 font-medium uppercase text-gray-800">{{ $grupo->plantel->name ?? '-' }}
                                    </td>

                                    <td class="px-2 py-4 text-center">
                                        <button
                                            class="btn-opciones text-white hover:text-white rounded-full bg-blue-500 hover:bg-blue-600 transition p-2 shadow"
                                            data-id="{{ $grupo->id }}"
                                            data-nombre="{{ $grupo->curso ? $grupo->curso->name : ($grupo->cursoIcategro ? $grupo->cursoIcategro->name : '-') }}"
                                            data-estatus="{{ $grupo->estatus }}" title="Opciones">
                                            <i class="fas fa-cog text-sm"></i>
                                        </button>
                                    </td>

                                    <td class="px-2 py-4 text-center">
                                        <button
                                            class="btn-impresiones {{ $hasAlumnos ? 'text-white bg-purple-500 hover:bg-purple-600 cursor-pointer shadow' : 'text-gray-400 bg-gray-200 cursor-not-allowed' }} rounded-full transition p-2"
                                            data-id="{{ $grupo->id }}"
                                            data-nombre="{{ $grupo->curso ? $grupo->curso->name : ($grupo->cursoIcategro ? $grupo->cursoIcategro->name : '-') }}"
                                            data-estatus="{{ $grupo->estatus }}" title="Impresiones" {{ !$hasAlumnos ? 'disabled' : '' }}>
                                            <i class="fas fa-print text-sm"></i>
                                        </button>
                                    </td>

                                    <td class="px-2 py-4 text-center">{{ $grupo->id }}</td>

                                    <td class="px-2 py-4 text-center">
                                        <span class="inline-block w-4 h-4 rounded-full {{ $colorClass }} shadow-sm"
                                            title="{{ $grupo->estatus }}"></span>
                                    </td>

                                    <td class="px-2 py-4 uppercase font-semibold text-gray-700">
                                        {{ $grupo->curso ? $grupo->curso->name : ($grupo->cursoIcategro ? $grupo->cursoIcategro->name : '-') }}
                                    </td>

                                    <td class="px-2 py-4 text-center">
                                        {{ $alumnosCount }}/{{ $grupo->capacidad_maxima }}
                                    </td>

                                    <td class="px-2 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($grupo->fecha_inicio)->format('d-m-Y') }}
                                    </td>

                                    <td class="px-2 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($grupo->fecha_termino)->format('d-m-Y') }}
                                    </td>

                                    <td class="px-2 py-4 text-center uppercase">{{ $grupo->tipo_servicio }}</td>

                                    <td class="px-2 py-4">
                                        @if($grupo->instructores->count() > 0)
                                            <ul class="list-disc pl-4 uppercase">
                                                @foreach($grupo->instructores as $inst)
                                                    <li>• {{ $inst->name }} {{ $inst->lastname }} {{ $inst->lastname2 }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-400 italic">No asignado</span>
                                        @endif
                                    </td>

                                    <td class="px-2 py-4 uppercase text-xs">{{ $grupo->tipo_pago_grupo }}</td>

                                    <td class="px-2 py-4 text-gray-800 font-bold">
                                        {{ number_format($grupo->ingreso_total ?? 0, 1) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Opciones Modal -->
        <div id="modalOpciones"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl overflow-hidden relative">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b">
                    <div class="flex items-center text-lg font-bold text-gray-800">
                        <i class="fas fa-cog text-blue-500 mr-2 text-2xl"></i> OPCIONES DEL GRUPO
                    </div>
                    <button type="button"
                        class="btn-cerrar-modal text-white bg-pink-500 hover:bg-pink-600 rounded-full w-8 h-8 flex items-center justify-center border-2 border-pink-400 transition shadow"
                        title="Cerrar">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Info Section -->
                <div class="grid grid-cols-3 gap-6 p-6 text-center border-b">
                    <div>
                        <div class="text-[#a02142] font-bold mb-2">ID Grupo</div>
                        <div id="modal-grupo-id" class="text-gray-700 text-sm"></div>
                    </div>
                    <div>
                        <div class="text-[#a02142] font-bold mb-2">Nombre del grupo</div>
                        <div id="modal-grupo-nombre" class="text-gray-700 text-sm uppercase"></div>
                    </div>
                    <div>
                        <div class="text-[#a02142] font-bold mb-2">Estatus</div>
                        <div class="flex items-center justify-center text-sm font-bold text-gray-700 uppercase">
                            <span id="modal-grupo-estatus-dot" class="w-4 h-4 rounded-full mr-2"></span>
                            <span id="modal-grupo-estatus"></span>
                        </div>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="px-8 pb-12 pt-8 text-center bg-gray-50 bg-opacity-50 relative">
                    <div
                        class="inline-block bg-[#c9ab81] text-white font-bold py-2 px-8 rounded-full shadow-md mb-10 border-b-4 border-yellow-700 text-lg">
                        ACCIONES DEL GRUPO
                    </div>

                    <div id="accionesContainer" class="flex flex-wrap justify-center gap-8">
                        <!-- Botones Dinámicos -->
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-4 border-t flex justify-end bg-white">
                    <button type="button"
                        class="btn-cerrar-modal bg-[#ec3243] hover:bg-red-700 text-white font-bold py-2 px-6 rounded transition shadow">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>

        <!-- Impresiones Modal -->
        <div id="modalImpresiones"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl overflow-hidden relative">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b">
                    <div class="flex items-center text-lg font-bold text-gray-800">
                        <i class="fas fa-print text-purple-600 mr-2 text-2xl"></i> IMPRESIONES DE DOCUMENTOS DEL GRUPO
                    </div>
                    <button type="button"
                        class="btn-cerrar-modal text-white bg-pink-500 hover:bg-pink-600 rounded-full w-8 h-8 flex items-center justify-center border-2 border-pink-400 transition shadow"
                        title="Cerrar">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Info Section -->
                <div class="grid grid-cols-3 gap-6 p-6 text-center border-b">
                    <div>
                        <div class="text-[#a02142] font-bold mb-2">ID Grupo</div>
                        <div id="modal-imp-grupo-id" class="text-gray-700 text-sm"></div>
                    </div>
                    <div>
                        <div class="text-[#a02142] font-bold mb-2">Nombre del grupo</div>
                        <div id="modal-imp-grupo-nombre" class="text-gray-700 text-sm uppercase"></div>
                    </div>
                    <div>
                        <div class="text-[#a02142] font-bold mb-2">Estatus</div>
                        <div class="flex items-center justify-center text-sm font-bold text-gray-700 uppercase">
                            <span id="modal-imp-grupo-estatus-dot" class="w-4 h-4 rounded-full mr-2"></span>
                            <span id="modal-imp-grupo-estatus"></span>
                        </div>
                    </div>
                </div>

                <!-- Formatos Section -->
                <div class="px-8 pb-12 pt-8 text-center bg-gray-50 bg-opacity-50 relative">
                    <div class="w-[90%] border-t border-gray-400 absolute top-12 left-[5%] z-0"></div>
                    <div
                        class="inline-block bg-[#c9ab81] text-white font-bold py-2 px-8 rounded-full shadow-md mb-10 border-b-4 border-yellow-700 text-lg relative z-10">
                        Formatos
                    </div>

                    <div class="flex flex-wrap justify-center gap-12 relative z-10">
                        <!-- Botón 1 -->
                        <div class="flex flex-col items-center cursor-pointer group w-28">
                            <div
                                class="w-24 h-24 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-purple-300 group-hover:shadow-lg transition">
                                <i
                                    class="fas fa-file-invoice text-[2.5rem] text-purple-500 group-hover:text-purple-600 transition"></i>
                            </div>
                            <span
                                class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-purple-600 transition text-center">LISTA
                                DE<br>ASISTENCIA</span>
                        </div>
                        <!-- Botón 2 -->
                        <div class="flex flex-col items-center cursor-pointer group w-28">
                            <div
                                class="w-24 h-24 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-blue-300 group-hover:shadow-lg transition">
                                <i
                                    class="fas fa-file-alt text-[2.5rem] text-blue-500 group-hover:text-blue-600 transition"></i>
                            </div>
                            <span
                                class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-blue-600 transition text-center">DOCUMENTOS<br>ENTREGADOS</span>
                        </div>
                        <!-- Botón 3 -->
                        <div class="flex flex-col items-center cursor-pointer group w-28">
                            <div
                                class="w-24 h-24 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-green-300 group-hover:shadow-lg transition relative">
                                <i
                                    class="fas fa-certificate text-[2.5rem] text-green-500 group-hover:text-green-600 transition"></i>
                                <div class="absolute bottom-2 right-2 text-red-500"><i
                                        class="fas fa-ribbon text-xl drop-shadow-sm"></i></div>
                            </div>
                            <span
                                class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-green-600 transition text-center">IMPRESIÓN
                                DE<br>CONSTANCIAS</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-4 border-t flex justify-end bg-white">
                    <button type="button"
                        class="btn-cerrar-modal bg-[#ec3243] hover:bg-red-700 text-white font-bold py-2 px-6 rounded transition shadow">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function () {
            // DataTable initialization with Responsive plugin
            $('#gruposTable').DataTable({
                language: {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                responsive: true,
                order: [[3, "desc"]], // Ordenar por No. Solicitud descendente
                columnDefs: [
                    { orderable: false, targets: [1, 2, 4, 10] } // Disable sorting on action and estatus columns
                ]
            });

            // Configuración del modal general
            $('.btn-cerrar-modal').on('click', function () {
                $('#modalOpciones').addClass('hidden');
                $('#modalImpresiones').addClass('hidden');
            });

            $('#modalOpciones, #modalImpresiones').on('click', function (e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // Generador dinámico de botones según estatus
            function getActionButtons(id, estatus) {
                let btnVerDatos = `
                                            <a href="/grupos/${id}" class="flex flex-col items-center cursor-pointer group w-24">
                                                <div class="w-20 h-20 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-blue-300 group-hover:shadow-lg transition">
                                                    <i class="fas fa-eye text-4xl text-blue-400 group-hover:text-blue-500 transition"></i>
                                                </div>
                                                <span class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-blue-600 transition text-center">VER DATOS DEL GRUPO</span>
                                            </a>
                                        `;
                let btnModificar = `
                                        <a href="/grupos/${id}/edit" class="flex flex-col items-center cursor-pointer group w-24">
                                            <div class="w-20 h-20 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-yellow-300 group-hover:shadow-lg transition">
                                                <i class="fas fa-file-signature text-4xl text-yellow-500 group-hover:text-yellow-600 transition"></i>
                                            </div>
                                            <span class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-yellow-600 transition text-center">MODIFICAR GRUPO</span>
                                        </a>
                                    `;
                let btnAgregarAlumnos = `
                                            <a href="/grupos/${id}/alumnos" class="flex flex-col items-center cursor-pointer group w-24">
                                                <div class="w-20 h-20 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-green-300 group-hover:shadow-lg transition relative">
                                                    <i class="fas fa-users text-4xl text-green-500 group-hover:text-green-600 transition"></i>
                                                    <div class="absolute -bottom-1 -right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-xs shadow border-2 border-white"><i class="fas fa-plus"></i></div>
                                                </div>
                                                <span class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-green-600 transition text-center">AGREGAR ALUMNOS</span>
                                            </a>
                                        `;
                let btnCalificar = `
                                            <a href="/grupos/${id}/calificar" class="flex flex-col items-center cursor-pointer group w-24">
                                                <div class="w-20 h-20 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-purple-300 group-hover:shadow-lg transition">
                                                    <i class="fas fa-clipboard-check text-4xl text-purple-400 group-hover:text-purple-500 transition"></i>
                                                </div>
                                                <span class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-purple-600 transition text-center">CALIFICAR ALUMNOS</span>
                                            </a>
                                        `;
                let btnFolios = `
                                            <a href="/grupos/${id}/folios" class="flex flex-col items-center cursor-pointer group w-24">
                                                <div class="w-20 h-20 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-orange-300 group-hover:shadow-lg transition relative">
                                                    <i class="fas fa-clipboard-list text-4xl text-orange-400 group-hover:text-orange-500 transition"></i>
                                                    <div class="absolute -bottom-1 -right-1 text-yellow-500 rounded-full bg-white w-6 h-6 flex items-center justify-center font-bold text-[10px] shadow border-2 border-white"><i class="fas fa-certificate"></i></div>
                                                </div>
                                                <span class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-orange-600 transition text-center">ASIGNAR FOLIOS</span>
                                            </a>
                                        `;
                let btnAutorizar = `
                                            <a href="/grupos/${id}/autorizar" class="flex flex-col items-center cursor-pointer group w-24">
                                                <div class="w-20 h-20 rounded-full border-4 border-gray-200 flex items-center justify-center bg-white shadow-md mb-3 group-hover:border-gray-800 group-hover:shadow-lg transition">
                                                    <i class="fas fa-thumbs-up text-4xl text-gray-700 group-hover:text-black transition"></i>
                                                </div>
                                                <span class="text-[11px] font-bold text-gray-800 uppercase leading-snug group-hover:text-black transition text-center">AUTORIZAR GRUPO</span>
                                            </a>
                                        `;

                let html = '';

                if (estatus.toUpperCase() === 'AUTORIZADO' || estatus.toUpperCase() === 'PENDIENTE' || estatus.toUpperCase() === 'PROCESO') {
                    html = btnVerDatos + btnAutorizar + btnModificar + btnAgregarAlumnos + btnCalificar;
                } else if (estatus.toUpperCase() === 'CONCLUIDO' || estatus.toUpperCase() === 'CALIFICADO') {
                    html = btnVerDatos + btnModificar + btnCalificar + btnFolios;
                } else {
                    html = btnVerDatos + btnAutorizar;
                }
                return html;
            }

            function getColorClass(estatus) {
                switch (estatus.toUpperCase()) {
                    case 'PENDIENTE': return 'bg-yellow-500';
                    case 'RECHAZADO': return 'bg-red-600';
                    case 'AUTORIZADO': return 'bg-green-600';
                    case 'PROCESO': return 'bg-blue-500';
                    case 'CALIFICADO': return 'bg-fuchsia-500';
                    case 'CONCLUIDO': return 'bg-purple-700';
                    case 'CANCELADO': return 'bg-gray-500';
                    default: return 'bg-gray-400';
                }
            }

            // Click en el botón de opciones
            $('#gruposTable').on('click', '.btn-opciones', function () {
                let id = $(this).data('id');
                let nombre = $(this).data('nombre');
                let estatus = $(this).data('estatus') || '';

                // Rellenar cabecera modal
                $('#modal-grupo-id').text(id);
                $('#modal-grupo-nombre').text(nombre);
                $('#modal-grupo-estatus').text(estatus.toUpperCase());

                $('#modal-grupo-estatus-dot')
                    .removeClass()
                    .addClass('w-4 h-4 rounded-full mr-2 ' + getColorClass(estatus));

                // Inyectar botones
                $('#accionesContainer').html(getActionButtons(id, estatus));

                // Show modal
                $('#modalOpciones').removeClass('hidden');
            });

            // Click en el botón de impresiones
            $('#gruposTable').on('click', '.btn-impresiones', function () {
                if ($(this).prop('disabled')) return;

                let id = $(this).data('id');
                let nombre = $(this).data('nombre');
                let estatus = $(this).data('estatus') || '';

                if (estatus.toUpperCase() !== 'CONCLUIDO') {
                    alert('Atención: El grupo debe estar CONCLUIDO para poder imprimir sus formatos correspondientes.');
                    return;
                }

                // Rellenar cabecera modal
                $('#modal-imp-grupo-id').text(id);
                $('#modal-imp-grupo-nombre').text(nombre);
                $('#modal-imp-grupo-estatus').text(estatus.toUpperCase());

                $('#modal-imp-grupo-estatus-dot')
                    .removeClass()
                    .addClass('w-4 h-4 rounded-full mr-2 ' + getColorClass(estatus));

                // Mostrar modal
                $('#modalImpresiones').removeClass('hidden');
            });
        });
    </script>
@endpush