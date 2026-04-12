@extends('layouts.app')

@section('title', 'Datos del Instructor - ICATEGRO')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        /* Ajustes visuales para emparejar con el diseño de referencia */
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 2px;
            background-color: transparent;
        }

        /* Ocultar barra de busqueda (DataTables Search Input) ya que no aparece en la imagen */
        .dataTables_filter {
            display: none;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #ddd;
            font-size: 0.85rem;
            color: #333;
            text-transform: uppercase;
        }

        table.dataTable tbody td {
            font-size: 0.85rem;
            color: #555;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .bg-gray-100 {
            background-color: #f3f4f6 !important;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden pb-8 max-w-7xl mx-auto mt-8">
        <!-- Header -->
        <div class="bg-[#d4b996] p-6 text-center border-b-4 border-[#bca380]">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center tracking-wide">
                <i class="fas fa-eye mr-3"></i> VER DATOS DEL INSTRUCTOR
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

        @php
            // Calculate DOB from CURP
            $curp = $instructor->curp ?? '';
            $dob = '';
            $age = '';
            $sex = '';

            if (strlen($curp) >= 11) {
                $yearStr = substr($curp, 4, 2);
                $monthStr = substr($curp, 6, 2);
                $dayStr = substr($curp, 8, 2);

                $yearNum = intval($yearStr);
                // CURP logic: If year is 00-24, assume 2000s (roughly, since this system might be used now).
                // Usually there is a letter in the 17th position to denote century but simple parsing:
                if ($yearNum <= date('y') + 5) { // e.g. 29
                    $fullYear = 2000 + $yearNum;
                } else {
                    $fullYear = 1900 + $yearNum;
                }

                if (checkdate(intval($monthStr), intval($dayStr), $fullYear)) {
                    $dobDate = \Carbon\Carbon::createFromDate($fullYear, $monthStr, $dayStr);
                    $dob = $dobDate->format('d/m/Y');
                    $age = $dobDate->age;
                }

                $sexChar = substr($curp, 10, 1);
                if ($sexChar === 'H') {
                    $sex = 'MASCULINO';
                } elseif ($sexChar === 'M') {
                    $sex = 'FEMENINO';
                }
            }
        @endphp

        <div class="px-8 mt-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-8 gap-x-8">
                <!-- Row 1 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Estatus</label>
                    <div class="flex items-center mt-2 ml-2 text-sm font-bold text-gray-800">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-2"></i> ACTIVO
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">ID Instructor</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->id }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">CURP</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->curp }}
                    </div>
                </div>

                <!-- Row 2 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Fecha de nacimiento</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $dob }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Edad</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $age }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Sexo</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $sex }}
                    </div>
                </div>

                <!-- Row 3 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Nombre</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->nombre }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Apellido 1</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->apellido_1 }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Apellido 2</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->apellido_2 ?? '' }}
                    </div>
                </div>

                <!-- Row 4 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Tipo de sangre</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->tipo_sangre ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Estado civil</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->estado_civil ?? '' }}
                    </div>
                </div>
            </div>

            <div class="mt-12 mb-8">
                <!-- Archivos -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Identificación -->
                    <div class="flex flex-col items-center">
                        <label class="block text-[#9b2242] font-bold mb-3 text-center">Archivo de Identificación
                            oficial</label>
                        @if($instructor->archivo_identificacion)
                            <a href="{{ route('instructores.download', [$instructor->id, 'identificacion']) }}"
                                class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                                <div class="relative z-10 flex items-center">
                                    <div
                                        class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                        <i class="fas fa-file-download text-2xl text-black"></i>
                                    </div>
                                    <span class="font-semibold text-sm">Descargar</span>
                                </div>
                            </a>
                        @else
                            <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                        @endif
                    </div>

                    <!-- CURP -->
                    <div class="flex flex-col items-center">
                        <label class="block text-[#9b2242] font-bold mb-3 text-center">Archivo de CURP</label>
                        @if($instructor->archivo_curp)
                            <a href="{{ route('instructores.download', [$instructor->id, 'curp']) }}"
                                class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                                <div class="relative z-10 flex items-center">
                                    <div
                                        class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                        <i class="fas fa-file-download text-2xl text-black"></i>
                                    </div>
                                    <span class="font-semibold text-sm">Descargar</span>
                                </div>
                            </a>
                        @else
                            <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                        @endif
                    </div>

                    <!-- Acta de Nacimiento -->
                    <div class="flex flex-col items-center">
                        <label class="block text-[#9b2242] font-bold mb-3 text-center">Archivo de Acta de nacimiento</label>
                        @if($instructor->archivo_acta_nacimiento)
                            <a href="{{ route('instructores.download', [$instructor->id, 'acta_nacimiento']) }}"
                                class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                                <div class="relative z-10 flex items-center">
                                    <div
                                        class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                        <i class="fas fa-file-download text-2xl text-black"></i>
                                    </div>
                                    <span class="font-semibold text-sm">Descargar</span>
                                </div>
                            </a>
                        @else
                            <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                        @endif
                    </div>
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
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->estado ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Municipio</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->municipio ?? '' }}
                    </div>
                </div>

                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Localidad</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->localidad ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Colonia</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->colonia ?? '' }}
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-6 gap-y-8 gap-x-8">
                <div class="md:col-span-3">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Calle</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->calle ?? '' }}
                    </div>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Núm. exterior</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->numero_exterior ?? '' }}
                    </div>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Núm. interior</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->numero_interior ?? '' }}
                    </div>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Código postal</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white uppercase shadow-sm">
                        {{ $instructor->codigo_postal ?? '' }}
                    </div>
                </div>
            </div>

            <div class="mt-12 mb-8">
                <div class="flex flex-col items-start w-64">
                    <label class="block text-[#9b2242] font-bold mb-3">Archivo de comprobante de domicilio</label>
                    @if($instructor->archivo_comprobante_domicilio)
                        <a href="{{ route('instructores.download', [$instructor->id, 'comprobante_domicilio']) }}"
                            class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                            <div class="relative z-10 flex items-center">
                                <div
                                    class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                    <i class="fas fa-file-download text-2xl text-black"></i>
                                </div>
                                <span class="font-semibold text-sm">Descargar</span>
                            </div>
                        </a>
                    @else
                        <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                    @endif
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Teléfono 1</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->telefono_1 ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Teléfono 2</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->telefono_2 ?? '' }}
                    </div>
                </div>

                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Email</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->email ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Email alternativo</label>
                    <div class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm">
                        {{ $instructor->email_trabajo ?? '' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Servicio médico
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">¿Cuenta con servicio médico?</label>
                    <div class="flex items-center mt-2 ml-2 text-sm font-bold text-gray-800">
                        @if($instructor->cuenta_servicio_medico)
                            <i class="fas fa-check-circle text-green-600 text-xl mr-2"></i> SÍ
                        @else
                            <i class="fas fa-times-circle text-red-600 text-xl mr-2"></i> NO
                        @endif
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Nombre del servicio médico</label>
                    <div
                        class="border-2 {{ $instructor->cuenta_servicio_medico ? 'border-gray-600 bg-white' : 'border-gray-400 bg-gray-300' }} rounded-full px-5 py-2 font-bold text-gray-900 shadow-sm uppercase">
                        {{ $instructor->nombre_servicio_medico ?? '' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Escolaridad
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                <!-- Row 1 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Escolaridad</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ $instructor->escolaridad ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Condición escolar</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ $instructor->condicion_escolar ?? '' }}
                    </div>
                </div>

                <!-- Row 2 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Nombre de la escuela</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ $instructor->nombre_escuela ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Cédula profesional</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ $instructor->cedula_profesional ?? '' }}
                    </div>
                </div>
            </div>

            <div class="mt-12 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- File Download -->
                    <div class="flex flex-col items-start w-64 md:col-span-1">
                        <label class="block text-[#9b2242] font-bold mb-3">Archivo de Comprobante de estudios</label>
                        @if($instructor->archivo_comprobante_estudios)
                            <a href="{{ route('instructores.download', [$instructor->id, 'comprobante_estudios']) }}"
                                class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                                <div class="relative z-10 flex items-center">
                                    <div
                                        class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                        <i class="fas fa-file-download text-2xl text-black"></i>
                                    </div>
                                    <span class="font-semibold text-sm">Descargar</span>
                                </div>
                            </a>
                        @else
                            <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                        @endif
                    </div>

                    <!-- STPS info -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                        <div>
                            <label class="block text-[#9b2242] font-bold mb-1 ml-2">¿Tiene registro STPS?</label>
                            <div class="flex items-center mt-2 ml-2 text-sm font-bold text-gray-800">
                                @if($instructor->tiene_registro_stps)
                                    <i class="fas fa-check-circle text-green-600 text-xl mr-2"></i> SÍ
                                @else
                                    <i class="fas fa-times-circle text-red-600 text-xl mr-2"></i> NO
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-[#9b2242] font-bold mb-1 ml-2">Registro STPS</label>
                            <div
                                class="border-2 {{ $instructor->tiene_registro_stps ? 'border-gray-600 bg-white' : 'border-gray-400 bg-gray-300' }} rounded-full px-5 py-2 font-bold text-gray-900 shadow-sm uppercase">
                                {{ $instructor->registro_stps ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Experiencia y tipo de instructor
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                <!-- Row 1 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Tipo de instructor</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ $instructor->tipo_instructor ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Experiencia laboral (Años)</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ number_format($instructor->experiencia_laboral ?? 0, 1) }}
                    </div>
                </div>

                <!-- Row 2 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Experiencia docente (Años)</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ number_format($instructor->experiencia_docente ?? 0, 1) }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Experiencia en el sector productivo
                        (Años)</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ number_format($instructor->experiencia_sector_productivo ?? 0, 1) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Datos fiscales
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">RFC</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase">
                        {{ $instructor->rfc ?? '' }}
                    </div>
                </div>

                <!-- File Download -->
                <div class="flex flex-col items-start md:items-center">
                    <label class="block text-[#9b2242] font-bold mb-3">Archivo RFC</label>
                    @if($instructor->archivo_rfc)
                        <a href="{{ route('instructores.download', [$instructor->id, 'rfc']) }}"
                            class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                            <div class="relative z-10 flex items-center">
                                <div
                                    class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                    <i class="fas fa-file-download text-2xl text-black"></i>
                                </div>
                                <span class="font-semibold text-sm">Descargar</span>
                            </div>
                        </a>
                    @else
                        <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Idiomas
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="overflow-x-auto">
                <table id="idiomas_table"
                    class="display responsive nowrap w-full text-sm text-left text-gray-500 mt-4 border-b border-gray-300">
                    <thead class="text-xs text-gray-900 uppercase bg-white border-b-2 border-gray-300 font-bold">
                        <tr>
                            <th class="px-4 py-3">Idioma</th>
                            <th class="px-4 py-3 text-center">¿Estudió en<br>el extranjero?</th>
                            <th class="px-4 py-3">Lugar de estudio</th>
                            <th class="px-4 py-3">Institución</th>
                            <th class="px-4 py-3">% de<br>conocimiento</th>
                            <th class="px-4 py-3">Estatus del<br>estudio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructor->idiomas as $idioma)
                            <tr class="bg-gray-100 border-b hover:bg-gray-200">
                                <td class="px-4 py-3 text-gray-800 uppercase">{{ $idioma->idioma }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($idioma->estudio_extranjero)
                                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                    @else
                                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-800 uppercase">
                                    @if($idioma->estudio_extranjero)
                                        EXTRANJERO
                                    @else
                                        {{ $idioma->municipio ?? 'N/A' }}, {{ $idioma->estado ?? '' }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-800 uppercase">{{ $idioma->institucion }}</td>
                                <td class="px-4 py-3 text-gray-800">{{ $idioma->porcentaje_conocimiento }}%</td>
                                <td class="px-4 py-3 text-gray-800 uppercase">{{ $idioma->estatus_estudios }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">No hay idiomas registrados
                                    para este instructor.</td>
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
                Habilidades
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="overflow-x-auto">
                <table id="habilidades_table"
                    class="display responsive nowrap w-full text-sm text-left text-gray-500 mt-4 border-b border-gray-300">
                    <thead class="text-xs text-gray-900 uppercase bg-white border-b-2 border-gray-300 font-bold">
                        <tr>
                            <th class="px-4 py-3 w-10"></th>
                            <th class="px-4 py-3">Habilidad</th>
                            <th class="px-4 py-3">Fecha captura</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructor->habilidades as $habilidad)
                            <tr class="bg-gray-100 border-b hover:bg-gray-200">
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-chevron-circle-right text-gray-800"></i>
                                </td>
                                <td class="px-4 py-3 text-gray-800 uppercase">{{ $habilidad->habilidad }}</td>
                                <td class="px-4 py-3 text-gray-800">
                                    {{ $habilidad->created_at ? $habilidad->created_at->format('d/m/Y \a \l\a\s H:i:s') : 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 italic">No hay habilidades
                                    registradas para este instructor.</td>
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
                Cursos impartidos
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="overflow-x-auto">
                <table id="cursos_table"
                    class="display responsive nowrap w-full text-sm text-left text-gray-500 mt-4 border-b border-gray-300">
                    <thead class="text-xs text-gray-900 uppercase bg-white border-b-2 border-gray-300 font-bold">
                        <tr>
                            <th class="px-4 py-3 w-10"></th>
                            <th class="px-4 py-3">Curso impartido</th>
                            <th class="px-4 py-3">Fecha captura</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructor->cursos as $curso)
                            <tr class="bg-gray-100 border-b hover:bg-gray-200">
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-chevron-circle-right text-gray-800"></i>
                                </td>
                                <td class="px-4 py-3 text-gray-800 uppercase">{{ $curso->curso }}</td>
                                <td class="px-4 py-3 text-gray-800">
                                    {{ $curso->created_at ? $curso->created_at->format('d/m/Y \a \l\a\s H:i:s') : 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 italic">No hay datos disponibles en
                                    la tabla</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-12">
                <div class="flex flex-col items-start md:items-start w-72">
                    <label class="block text-[#9b2242] font-bold mb-3">Archivo de Constancias de cursos</label>
                    @if($instructor->archivo_constancias_cursos)
                        <a href="{{ route('instructores.download', [$instructor->id, 'constancias_cursos']) }}"
                            class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                            <div class="relative z-10 flex items-center">
                                <div
                                    class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                    <i class="fas fa-file-download text-2xl text-black"></i>
                                </div>
                                <span class="font-semibold text-sm">Descargar</span>
                            </div>
                        </a>
                    @else
                        <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Datos financieros
            </div>
        </div>

        <div class="px-8 mt-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                <!-- Row 1 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Tipo</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase min-h-[44px] flex items-center">
                        {{ $instructor->banco_tipo ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Banco</label>
                    <div
                        class="border-2 border-gray-600 rounded-full px-5 py-2 font-bold text-gray-900 bg-white shadow-sm uppercase min-h-[44px] flex items-center">
                        {{ $instructor->banco_nombre ?? '' }}
                    </div>
                </div>

                <!-- Row 2 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Clabe interbancaria</label>
                    <div
                        class="border-2 {{ $instructor->clabe ? 'border-gray-600 bg-white' : 'border-gray-400 bg-gray-400 opacity-60' }} rounded-full px-5 py-2 font-bold text-gray-900 shadow-sm uppercase min-h-[44px] flex items-center">
                        {{ $instructor->clabe ?? '' }}
                    </div>
                </div>
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Número de cuenta</label>
                    <div
                        class="border-2 {{ $instructor->numero_cuenta ? 'border-gray-600 bg-white' : 'border-gray-400 bg-gray-400 opacity-60' }} rounded-full px-5 py-2 font-bold text-gray-900 shadow-sm uppercase min-h-[44px] flex items-center">
                        {{ $instructor->numero_cuenta ?? '' }}
                    </div>
                </div>

                <!-- Row 3 -->
                <div>
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Número de tarjeta</label>
                    <div
                        class="border-2 {{ $instructor->numero_tarjeta ? 'border-gray-600 bg-white' : 'border-gray-400 bg-gray-400 opacity-60' }} rounded-full px-5 py-2 font-bold text-gray-900 shadow-sm uppercase min-h-[44px] flex items-center">
                        {{ $instructor->numero_tarjeta ?? '' }}
                    </div>
                </div>

                <!-- File Download -->
                <div class="flex flex-col items-start md:items-center">
                    <label class="block text-[#9b2242] font-bold mb-3">Archivo Estado de cuenta o tarjeta</label>
                    @if($instructor->archivo_estado_cuenta)
                        <a href="{{ route('instructores.download', [$instructor->id, 'estado_cuenta']) }}"
                            class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                            <div class="relative z-10 flex items-center">
                                <div
                                    class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                    <i class="fas fa-file-download text-2xl text-black"></i>
                                </div>
                                <span class="font-semibold text-sm">Descargar</span>
                            </div>
                        </a>
                    @else
                        <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-12 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Documentación adicional
            </div>
        </div>

        <div class="px-8 mt-8 mb-8 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8">
                <!-- File Download 1 -->
                <div class="flex flex-col items-start md:items-start pl-4">
                    <label class="block text-[#9b2242] font-bold mb-3">Curriculum VITAE actualizado</label>
                    @if($instructor->archivo_cv)
                        <a href="{{ route('instructores.download', [$instructor->id, 'cv']) }}"
                            class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                            <div class="relative z-10 flex items-center">
                                <div
                                    class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                    <i class="fas fa-file-download text-2xl text-black"></i>
                                </div>
                                <span class="font-semibold text-sm">Descargar</span>
                            </div>
                        </a>
                    @else
                        <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                    @endif
                </div>

                <!-- File Download 2 -->
                <div class="flex flex-col items-start md:items-start pl-4 md:pl-12">
                    <label class="block text-[#9b2242] font-bold mb-3">Solicitud de empleo con fotografía vigente</label>
                    @if($instructor->archivo_solicitud_empleo)
                        <a href="{{ route('instructores.download', [$instructor->id, 'solicitud_empleo']) }}"
                            class="flex items-center justify-center bg-[#2d3748] hover:bg-black text-white rounded-2xl border-4 border-gray-400 p-4 shadow-lg transition-transform hover:scale-105 w-48 h-20 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-30"></div>
                            <div class="relative z-10 flex items-center">
                                <div
                                    class="bg-[#cba365] p-2 rounded mr-3 border border-[#a28148] flex items-center justify-center">
                                    <i class="fas fa-file-download text-2xl text-black"></i>
                                </div>
                                <span class="font-semibold text-sm">Descargar</span>
                            </div>
                        </a>
                    @else
                        <div class="text-gray-500 italic text-sm mt-4">No disponible</div>
                    @endif
                </div>

                <!-- Observaciones -->
                <div class="col-span-1 md:col-span-2 mt-4 pl-4 pr-4">
                    <label class="block text-[#9b2242] font-bold mb-1">Observaciones</label>
                    <div class="border border-gray-400 rounded-md p-4 min-h-[100px] bg-white text-gray-800">
                        {{ $instructor->observaciones ?? '' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW: Cursos impartidos (Grupos) -->
        <div class="mt-8 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Cursos impartidos
            </div>
        </div>

        <div class="px-8 mt-8 mb-8 pb-8">
            <!-- Legend -->
            <div class="bg-[#5a6b7d] text-white px-3 py-1 text-sm font-bold w-full uppercase flex items-center h-8">
                Estatus del grupo
            </div>
            <div class="flex flex-wrap gap-x-6 gap-y-3 mt-4 text-xs font-bold text-gray-700 uppercase">
                <div class="flex items-center"><span
                        class="w-5 h-5 rounded-full bg-yellow-500 mr-2 inline-block shadow"></span> PENDIENTE</div>
                <div class="flex items-center"><span
                        class="w-5 h-5 rounded-full bg-red-600 mr-2 inline-block shadow"></span> RECHAZADO</div>
                <div class="flex items-center"><span
                        class="w-5 h-5 rounded-full bg-green-500 mr-2 inline-block shadow"></span> AUTORIZADO</div>
                <div class="flex items-center"><span
                        class="w-5 h-5 rounded-full bg-blue-500 mr-2 inline-block shadow"></span> PROCESO</div>
                <div class="flex items-center"><span
                        class="w-5 h-5 rounded-full bg-fuchsia-500 mr-2 inline-block shadow"></span> CALIFICADO</div>
                <div class="flex items-center"><span
                        class="w-5 h-5 rounded-full bg-purple-700 mr-2 inline-block shadow"></span> CONCLUIDO</div>
                <div class="flex items-center"><span
                        class="w-5 h-5 rounded-full bg-gray-500 mr-2 inline-block shadow"></span> CANCELADO</div>
            </div>

            <div class="overflow-x-auto mt-6">
                <!-- DataTables for groups -->
                <table id="grupos_table"
                    class="display responsive nowrap w-full text-sm text-left text-gray-500 border-b border-gray-300">
                    <thead class="text-xs text-gray-900 bg-white border-b-2 border-gray-300 font-bold uppercase">
                        <tr>
                            <th class="px-4 py-3">Estatus<br>grupo</th>
                            <th class="px-4 py-3">Plantel</th>
                            <th class="px-4 py-3">ID<br>grupo</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Fecha<br>de inicio</th>
                            <th class="px-4 py-3">Fecha<br>de término</th>
                            <th class="px-4 py-3">Días</th>
                            <th class="px-4 py-3">Horas</th>
                            <th class="px-4 py-3">Tipo</th>
                            <th class="px-4 py-3">Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructor->grupos as $grupo)
                            <tr class="bg-gray-100 border-b hover:bg-gray-200">
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $color = 'gray-500'; // Default CANCELADO
                                        switch ($grupo->estatus) {
                                            case 'PENDIENTE':
                                                $color = 'yellow-500';
                                                break;
                                            case 'RECHAZADO':
                                                $color = 'red-600';
                                                break;
                                            case 'AUTORIZADO':
                                                $color = 'green-500';
                                                break;
                                            case 'PROCESO':
                                                $color = 'blue-500';
                                                break;
                                            case 'CALIFICADO':
                                                $color = 'fuchsia-500';
                                                break;
                                            case 'CONCLUIDO':
                                                $color = 'purple-700';
                                                break;
                                        }
                                    @endphp
                                    <span class="w-4 h-4 rounded-full bg-{{ $color }} inline-block shadow"
                                        title="{{ $grupo->estatus }}"></span>
                                </td>
                                <td class="px-4 py-3 uppercase">{{ $grupo->plantel ? $grupo->plantel->name : 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $grupo->id }}</td>
                                <td class="px-4 py-3 uppercase text-blue-600 font-semibold truncate max-w-xs">
                                    <a href="{{ route('grupos.show', $grupo->id) }}" class="hover:underline">
                                        <i class="fas fa-eye mr-1"></i> {{ $grupo->nombre_curso }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($grupo->fecha_inicio)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($grupo->fecha_termino)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $grupo->duracion_dias }}</td>
                                <td class="px-4 py-3">{{ $grupo->duracion_horas }}</td>
                                <td class="px-4 py-3 uppercase">{!! nl2br(e($grupo->pivot->tipo_pago ?? 'N/A')) !!}</td>
                                <td class="px-4 py-3">{{ number_format($grupo->pivot->pago_instructor ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-4 text-center text-gray-500 italic">No hay grupos asociados
                                    para este instructor.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- NEW: Registro -->
        <div class="mt-8 relative flex items-center justify-center">
            <div class="absolute w-full z-0 px-8">
                <div class="border-t-2 border-gray-400"></div>
            </div>
            <div
                class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                Registro
            </div>
        </div>

        <div class="px-8 mt-8 mb-8 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-y-6 gap-x-6">
                <!-- User ID -->
                <div class="md:col-span-1">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">ID usuario capturó</label>
                    <div
                        class="w-full border-2 border-gray-600 rounded-full px-4 py-1.5 font-bold text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-0 text-sm">
                        {{ $instructor->user_id ?? 'N/A' }}
                    </div>
                </div>

                <!-- User Name -->
                <div class="md:col-span-2">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Registrado por</label>
                    <div
                        class="w-full border-2 border-gray-600 rounded-full px-4 py-1.5 font-bold text-gray-900 bg-white uppercase shadow-sm focus:outline-none focus:ring-0 text-sm">
                        {{ $instructor->creator->name ?? 'N/A' }}
                    </div>
                </div>

                <!-- Capture Date -->
                <div class="md:col-span-1">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Fecha captura</label>
                    <div
                        class="w-full border-2 border-gray-600 rounded-full px-4 py-1.5 font-bold text-gray-900 bg-white uppercase shadow-sm focus:outline-none focus:ring-0 text-sm">
                        {{ $instructor->created_at ? $instructor->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                    </div>
                </div>

                <!-- Plantel -->
                <div class="md:col-span-4">
                    <label class="block text-[#9b2242] font-bold mb-1 ml-2">Plantel</label>
                    <div
                        class="w-full border-2 border-gray-600 rounded-full px-4 py-1.5 font-bold text-gray-900 bg-white uppercase shadow-sm focus:outline-none focus:ring-0 text-sm">
                        {{ $instructor->creator->plantel->name ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Section background below content similar to the image -->
        <div class="bg-cyan-50 mt-12 py-6 border-t border-gray-200">
            <div class="flex justify-center">
                <a href="{{ route('instructores.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-8 rounded shadow flex items-center">
                    <i class="fas fa-sign-out-alt mr-2 text-xl"></i>
                    Salir
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery y DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function () {
            // Configuración común para DataTables
            const dataTableConfig = {
                responsive: true,
                language: {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de un total de _MAX_ entradas)",
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
                bSort: true,
                searching: false, // Disabled as per design (no search box visible)
            };

            $('#idiomas_table').DataTable({
                ...dataTableConfig,
                order: [[0, 'asc']]
            });

            $('#habilidades_table').DataTable({
                ...dataTableConfig,
                columnDefs: [
                    { orderable: false, targets: 0 } // Disable sort on icon column
                ],
                order: [[1, 'asc']]
            });

            $('#cursos_table').DataTable({
                ...dataTableConfig,
                columnDefs: [
                    { orderable: false, targets: 0 } // Disable sort on icon column
                ],
                order: [[1, 'asc']]
            });

            $('#grupos_table').DataTable({
                ...dataTableConfig,
                columnDefs: [
                    { orderable: false, targets: 0 } // Disable sort on icon column
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
@endpush