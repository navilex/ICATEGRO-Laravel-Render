@extends('layouts.app')

@section('title', 'Consultar Planteles - ICATEGRO')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
                    CONSULTAR PLANTELES
                </h1>
            </div>

            <!-- Table Container -->
            <div class="p-8">
                <div class="overflow-x-auto">
                    <table id="plantelesTable" class="w-full text-sm text-left text-gray-600 stripe hover">
                        <thead class="text-xs text-gray-800 font-bold bg-white border-b-2 border-gray-300">
                            <tr>
                                <th class="px-2 py-3">No.</th>
                                <th class="px-2 py-3">CCT</th>
                                <th class="px-2 py-3">Plantel</th>
                                <th class="px-2 py-3">Clasificación</th>
                                <th class="px-2 py-3">Estado/Municipio</th>
                                <th class="px-2 py-3 text-center">Encargado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($planteles as $plantel)
                                <tr class="border-b transition duration-150 hover:bg-gray-50 uppercase">
                                    <td class="px-2 py-4 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-4 font-semibold">{{ $plantel->clave_cct }}</td>
                                    <td class="px-2 py-4 text-gray-800">{{ $plantel->name }}</td>
                                    <td class="px-2 py-4">{{ $plantel->clasificacion }}</td>
                                    <td class="px-2 py-4">{{ $plantel->estado }} / {{ $plantel->municipio }}</td>
                                    <td class="px-2 py-4 text-center">
                                        @if($plantel->usuarioEncargado)
                                            {{ $plantel->usuarioEncargado->name }} {{ $plantel->usuarioEncargado->lastname }}
                                            {{ $plantel->usuarioEncargado->lastname2 }}
                                        @else
                                            <span class="text-red-500 italic text-xs font-bold">Sin titular asignado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            // DataTable initialization
            $('#plantelesTable').DataTable({
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
                order: [[0, "asc"]] // Sort by No. ascending initially
            });
        });
    </script>
@endpush