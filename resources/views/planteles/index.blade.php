@extends('layouts.app')

@section('title', 'Planteles - ICATEGRO')

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

        <!-- Registration Form Container -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-[#d4b996] p-4 text-center">
                <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                    <span
                        class="bg-gray-800 text-white rounded w-8 h-8 flex items-center justify-center text-xl mr-2">+</span>
                    ALTA DE PLANTEL / ACCIÓN MÓVIL
                </h1>
            </div>

            <!-- Form -->
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('planteles.store') }}" method="POST">
                    @csrf

                    <!-- Sección: Datos generales -->
                    <div class="relative py-6">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-gray-600 text-white px-4 py-1 rounded-full text-sm font-semibold shadow-md">
                                Datos generales
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="clasificacion" class="block text-red-800 font-bold mb-1">* Clasificación</label>
                            <select name="clasificacion" id="clasificacion"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                required>
                                <option value="">» SELECCIONA LA CLASIFICACIÓN</option>
                                <option value="UNIDAD DE CAPACITACIÓN" {{ old('clasificacion') == 'UNIDAD DE CAPACITACIÓN' ? 'selected' : '' }}>UNIDAD DE CAPACITACIÓN</option>
                                <option value="ACCIÓN MÓVIL" {{ old('clasificacion') == 'ACCIÓN MÓVIL' ? 'selected' : '' }}>
                                    ACCIÓN MÓVIL</option>
                                <option value="ACCIÓN EXTRAMUROS" {{ old('clasificacion') == 'ACCIÓN EXTRAMUROS' ? 'selected' : '' }}>ACCIÓN EXTRAMUROS</option>
                            </select>
                        </div>
                        <div>
                            <label for="tipo" class="block text-red-800 font-bold mb-1">* Tipo</label>
                            <select name="tipo" id="tipo"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                required>
                                <option value="">» SELECCIONA EL TIPO</option>
                                <option value="PLANTEL" {{ old('tipo') == 'PLANTEL' ? 'selected' : '' }}>PLANTEL</option>
                                <option value="SEDE" {{ old('tipo') == 'SEDE' ? 'selected' : '' }}>SEDE</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="clave_cct" class="block text-red-800 font-bold mb-1">* Clave CCT</label>
                            <input type="text" name="clave_cct" id="clave_cct" value="{{ old('clave_cct') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="Clave CCT" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="name" class="block text-red-800 font-bold mb-1">* Nombre del plantel</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="Nombre del plantel" required>
                        </div>
                    </div>


                    <!-- Sección: Domicilio -->
                    <div class="relative py-6">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-gray-600 text-white px-4 py-1 rounded-full text-sm font-semibold shadow-md">
                                Domicilio
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="estado" class="block text-red-800 font-bold mb-1">* Estado</label>
                        <select name="estado" id="estado"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="GUERRERO" selected>GUERRERO</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="municipio" class="block text-red-800 font-bold mb-1">* Municipio</label>
                        <select name="municipio" id="municipio"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            required>
                            <option value="CHILPANCINGO DE LOS BRAVO" selected>CHILPANCINGO DE LOS BRAVO</option>
                            <!-- Add other municipalities as needed -->
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="colonia" class="block text-red-800 font-bold mb-1">* Colonia</label>
                            <input type="text" name="colonia" id="colonia" value="{{ old('colonia') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="Nombre de la colonia" required>
                        </div>
                        <div>
                            <label for="calle" class="block text-red-800 font-bold mb-1">* Calle</label>
                            <input type="text" name="calle" id="calle" value="{{ old('calle') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="Nombre de la calle" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="numero_exterior" class="block text-red-800 font-bold mb-1">* Número exterior</label>
                            <input type="text" name="numero_exterior" id="numero_exterior"
                                value="{{ old('numero_exterior') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="Número exterior" required>
                        </div>
                        <div>
                            <label for="numero_interior" class="block text-red-800 font-bold mb-1">Número interior</label>
                            <input type="text" name="numero_interior" id="numero_interior"
                                value="{{ old('numero_interior') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="Número interior">
                        </div>
                        <div>
                            <label for="codigo_postal" class="block text-red-800 font-bold mb-1">* Código postal</label>
                            <input type="text" name="codigo_postal" id="codigo_postal" value="{{ old('codigo_postal') }}"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                placeholder="Código postal" required>
                        </div>
                    </div>


                    <!-- Sección: Director/Encargado -->
                    <div class="relative py-6">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-gray-600 text-white px-4 py-1 rounded-full text-sm font-semibold shadow-md">
                                Director/Encargado
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="tipo_asignacion" class="block text-red-800 font-bold mb-1">* Tipo de
                                asignación</label>
                            <select name="tipo_asignacion" id="tipo_asignacion"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                required>
                                <option value="">» SELECCIONA EL TIPO DE ASIGNACIÓN</option>
                                <option value="DIRECTOR" {{ old('tipo_asignacion') == 'DIRECTOR' ? 'selected' : '' }}>DIRECTOR
                                </option>
                                <option value="ENCARGADO" {{ old('tipo_asignacion') == 'ENCARGADO' ? 'selected' : '' }}>
                                    ENCARGADO</option>
                            </select>
                        </div>
                        <div>
                            <label for="director_id" class="block text-red-800 font-bold mb-1">* USUARIO</label>
                            <select name="director_id" id="director_id"
                                class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                                required>
                                <option value="">» SELECCIONA EL USUARIO</option>
                                @foreach($usuarios as $user)
                                    <option value="{{ $user->id }}" {{ old('director_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} {{ $user->lastname }} {{ $user->lastname2 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Actions -->
                    <div
                        class="flex justify-end bg-[#e6fcf5] -mx-8 -mb-8 p-4 border-t border-gray-200 rounded-b-lg shadow-inner mt-8">
                        <button type="submit"
                            class="bg-[#1f2937] hover:bg-black text-white px-5 py-2 rounded-md shadow flex items-center transition focus:outline-none font-medium">
                            Guardar <i class="fas fa-save ml-2 text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection