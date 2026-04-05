@extends('layouts.app')

@section('title', 'Alta de Usuario')

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden min-h-[500px] max-w-5xl mx-auto mt-8">
        <!-- Header -->
        <div class="bg-[#d4b996] p-4 text-center">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <span class="bg-gray-800 text-white rounded w-8 h-8 flex items-center justify-center text-xl mr-2">+</span>
                ALTA DE USUARIO
            </h1>
        </div>

        <!-- Form -->
        <div class="p-8">
            <!-- Section Title: Datos generales -->
            <div class="relative mb-8 text-center">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Datos generales</span>
                </div>
            </div>

            <!-- Mensajes de éxito/error -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
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

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <!-- Row 1: CURP and Nombre -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                    <!-- CURP -->
                    <div class="md:col-span-4">
                        <label for="curp" class="block text-red-800 font-bold mb-1">* CURP <span
                                class="bg-white text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-xs ml-1"></span></label>
                        <input type="text" name="curp" id="curp" value="{{ old('curp') }}"
                            class="w-full border-2 border-gray-400 rounded p-2 focus:outline-none focus:border-red-500 uppercase"
                            placeholder="CURP" required maxlength="18">
                        <p id="curp-status" class="text-xs mt-1 text-gray-500 italic hidden"></p>
                    </div>

                    <!-- Help Icon -->
                    <div class="md:col-span-1 flex items-end justify-center pb-3">
                        <a href="https://www.gob.mx/curp/" target="_blank" rel="noopener noreferrer"
                            class="bg-green-600 text-white rounded p-1 shadow hover:bg-green-700 transition"
                            title="Consultar CURP en RENAPO">
                            <i class="fas fa-question-circle"></i>
                        </a>
                    </div>

                    <!-- Nombre -->
                    <div class="md:col-span-7">
                        <label for="name" class="block text-red-800 font-bold mb-1">* Nombre <span
                                class="bg-white text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-xs ml-1"></span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50"
                            placeholder="Nombre" required>
                    </div>
                </div>

                <!-- Row 2: Apellidos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Apellido 1 -->
                    <div>
                        <label for="lastname" class="block text-red-800 font-bold mb-1">* Apellido 1 <span
                                class="bg-white text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-xs ml-1"></span></label>
                        <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50 uppercase"
                            placeholder="Apellido 1" required>
                    </div>

                    <!-- Apellido 2 -->
                    <div>
                        <label for="lastname2" class="block text-red-800 font-bold mb-1">* Apellido 2</label>
                        <input type="text" name="lastname2" id="lastname2" value="{{ old('lastname2') }}"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50 uppercase"
                            placeholder="Apellido 2 (o 'X')" required>
                    </div>
                </div>


                <!-- Section Title: Domicilio -->
                <div class="relative mb-8 text-center mt-8">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Domicilio</span>
                    </div>
                </div>

                <!-- Estado -->
                <div class="mb-6">
                    <label for="state" class="block text-red-800 font-bold mb-1">* Estado</label>
                    <select name="state" id="state"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="GUERRERO" selected>GUERRERO</option>
                    </select>
                </div>

                <!-- Municipio -->
                <div class="mb-6">
                    <label for="municipality" class="block text-red-800 font-bold mb-1">* Municipio</label>
                    <select name="municipality" id="municipality"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="CHILPANCINGO DE LOS BRAVO" selected>CHILPANCINGO DE LOS BRAVO</option>
                    </select>
                </div>

                <!-- Localidad -->
                <div class="mb-6">
                    <label for="locality" class="block text-red-800 font-bold mb-1">* Localidad</label>
                    <select name="locality" id="locality"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white">
                        <option value="">» SELECCIONA LA LOCALIDAD</option>
                        <option value="CHILPANCINGO">CHILPANCINGO</option>
                        <option value="PETAQUILLAS">PETAQUILLAS</option>
                        <option value="MAZATLAN">MAZATLAN</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Colonia -->
                    <div>
                        <label for="colony" class="block text-red-800 font-bold mb-1">* Colonia</label>
                        <input type="text" name="colony" id="colony"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50 placeholder-gray-300"
                            placeholder="Nombre de la colonia" required value="{{ old('colony') }}">
                    </div>
                    <!-- Calle -->
                    <div>
                        <label for="street" class="block text-red-800 font-bold mb-1">* Calle</label>
                        <input type="text" name="street" id="street"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50 placeholder-gray-300"
                            placeholder="Nombre de la calle" required value="{{ old('street') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- No. Ext -->
                    <div>
                        <label for="exterior_number" class="block text-red-800 font-bold mb-1">* Número
                            exterior</label>
                        <input type="text" name="exterior_number" id="exterior_number"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50 placeholder-gray-300"
                            placeholder="Número exterior" required value="{{ old('exterior_number') }}">
                    </div>
                    <!-- No. Int -->
                    <div>
                        <label for="interior_number" class="block text-red-800 font-bold mb-1">Número
                            interior</label>
                        <input type="text" name="interior_number" id="interior_number"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50 placeholder-gray-300"
                            placeholder="Número interior" value="{{ old('interior_number') }}">
                    </div>
                    <!-- CP -->
                    <div>
                        <label for="zip_code" class="block text-red-800 font-bold mb-1">* Código postal</label>
                        <input type="text" name="zip_code" id="zip_code"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-gray-50 placeholder-gray-300"
                            placeholder="Código postal" required value="{{ old('zip_code') }}">
                    </div>
                </div>

                <!-- Section Title: Datos de contacto -->
                <div class="relative mb-8 text-center mt-8">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Datos de contacto</span>
                    </div>
                </div>

                <!-- Row: Teléfono y Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Teléfono -->
                    <div>
                        <label for="phone" class="block text-red-800 font-bold mb-1">* Teléfono</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="Teléfono" required>
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-red-800 font-bold mb-1">* Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                            placeholder="Email" required>
                    </div>
                </div>

                <!-- Section Title: Asignación -->
                <div class="relative mb-8 text-center mt-8">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Asignación</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="adscription" class="block text-red-800 font-bold mb-1">* Clasificación del Plantel</label>
                    <select name="adscription" id="adscription"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="">» SELECCIONA CLASIFICACIÓN</option>
                        <option value="UNIDAD DE CAPACITACION" {{ old('adscription') == 'UNIDAD DE CAPACITACION' ? 'selected' : '' }}>UNIDAD DE CAPACITACION</option>
                        <option value="ACCION MOVIL" {{ old('adscription') == 'ACCION MOVIL' ? 'selected' : '' }}>ACCION MOVIL</option>
                        <option value="ACCION EXTRAMUROS" {{ old('adscription') == 'ACCION EXTRAMUROS' ? 'selected' : '' }}>ACCION EXTRAMUROS</option>
                        <option value="DIRECCION GENERAL" {{ old('adscription') == 'DIRECCION GENERAL' ? 'selected' : '' }}>DIRECCION GENERAL</option>
                    </select>
                </div>

                <div id="plantel_container" class="mb-8 {{ old('plantel_id') ? '' : 'hidden' }}">
                    <label for="plantel_id" class="block text-red-800 font-bold mb-1">* Seleccione el Plantel específico</label>
                    <select name="plantel_id" id="plantel_id"
                        class="w-full border-2 border-red-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-600 bg-white">
                        <option value="">» SELECCIONA EL PLANTEL</option>
                        </select>
                </div>

                <!-- Section Title: Datos de usuario -->
                <div class="relative mb-8 text-center mt-8">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Datos de usuario</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-red-800 font-bold mb-1">* Usuario</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white font-bold"
                            placeholder="Usuario" required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-red-800 font-bold mb-1">* Password</label>
                        <input type="text" name="password" id="password" value="{{ old('password', 'ICATEGRO2023') }}"
                            class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white font-bold"
                            placeholder="Contraseña" required>
                    </div>
                </div>

                <div class="mb-10">
                    <label for="role" class="block text-red-800 font-bold mb-1">* Tipo de usuario</label>
                    <select name="role" id="role"
                        class="w-full border-2 border-gray-400 rounded-full p-2 px-4 focus:outline-none focus:border-red-500 bg-white"
                        required>
                        <option value="USUARIO COMUN" {{ old('role') == 'USUARIO COMUN' ? 'selected' : '' }}>USUARIO COMUN
                        </option>
                        <option value="USUARIO ADMINISTRADOR" {{ old('role') == 'USUARIO ADMINISTRADOR' ? 'selected' : '' }}>
                            USUARIO ADMINISTRADOR</option>
                    </select>
                </div>

                @php
                    $modules = [
                        'OFERTA EDUCATIVA' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'PLANTELES' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'ALUMNOS' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'EMPRESAS' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'GRUPOS' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'ALUMNOS GRUPOS' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'REPORTES' => ['leer' => true, 'editar' => false, 'insertar' => false, 'eliminar' => false],
                        'INSTRUCTORES' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'USUARIOS' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                        'GRUPOS AUTORIZAR' => ['leer' => true, 'editar' => true, 'insertar' => false, 'eliminar' => false],
                        'CONVENIOS' => ['leer' => true, 'editar' => true, 'insertar' => true, 'eliminar' => true],
                    ];
                @endphp

                <!-- Section Title: Permisos -->
                <div class="relative mb-8 text-center mt-12">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gray-600 text-white rounded-full text-lg shadow-md">Permisos</span>
                    </div>
                </div>

                <div class="border border-gray-200 mt-4 mb-4">
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white border-b border-t border-gray-200">
                                    <th class="p-3 font-bold text-gray-800 text-sm whitespace-nowrap">Modulo</th>
                                    <th class="p-3 font-bold text-gray-800 text-sm text-center whitespace-nowrap">Permiso
                                        Leer</th>
                                    <th class="p-3 font-bold text-gray-800 text-sm text-center whitespace-nowrap">Permiso
                                        Editar</th>
                                    <th class="p-3 font-bold text-gray-800 text-sm text-center whitespace-nowrap">Permiso
                                        Insertar</th>
                                    <th class="p-3 font-bold text-gray-800 text-sm text-center whitespace-nowrap">Permiso
                                        Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modules as $moduleName => $actions)
                                    <tr
                                        class="border-b border-gray-100 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition duration-150">
                                        <td class="p-3 text-sm text-gray-600">{{ $moduleName }}</td>
                                        @foreach(['leer', 'editar', 'insertar', 'eliminar'] as $action)
                                            <td class="p-3 text-center align-middle">
                                                @if($actions[$action])
                                                    <label class="inline-flex relative items-center cursor-pointer">
                                                        <input type="checkbox" name="permissions[{{ $moduleName }}][{{ $action }}]"
                                                            value="1" class="sr-only peer" {{ old("permissions.{$moduleName}.{$action}") ? 'checked' : '' }}>
                                                        <div
                                                            class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500 shadow-inner">
                                                        </div>
                                                    </label>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>

                <!-- Actions -->
                <div
                    class="flex justify-end bg-[#e6fcf5] -mx-8 -mb-8 p-4 border-t border-gray-200 mt-8 rounded-b-lg shadow-inner">
                    <button type="submit"
                        class="bg-[#1f2937] hover:bg-black text-white px-5 py-2 rounded-md shadow flex items-center transition focus:outline-none font-medium">
                        Guardar <i class="fas fa-lock ml-2 text-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const curpInput = document.getElementById('curp');
            const nameInput = document.getElementById('name');
            const lastname1Input = document.getElementById('lastname');
            const lastname2Input = document.getElementById('lastname2');
            const statusText = document.getElementById('curp-status');
            const resetBtn = document.getElementById('reset-btn');
            const usernameInput = document.getElementById('username');
            const adscriptionSelect = document.getElementById('adscription');
            const plantelSelect = document.getElementById('plantel_id');
            const plantelContainer = document.getElementById('plantel_container');

            // Pasamos la colección de planteles de PHP a un objeto JS
            const todosLosPlanteles = @json($planteles);

            let userEditedUsername = false;

            usernameInput.addEventListener('input', function () {
                userEditedUsername = true;
            });

            adscriptionSelect.addEventListener('change', function() {
            const seleccion = this.value;
            
            // Limpiar opciones anteriores
            plantelSelect.innerHTML = '<option value="">» SELECCIONA EL PLANTEL</option>';

            if (seleccion) {
                // Filtramos los planteles que coincidan con la clasificación
                const filtrados = todosLosPlanteles.filter(p => p.clasificacion === seleccion);

                if (filtrados.length > 0) {
                    filtrados.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id;
                        option.textContent = p.name;
                        plantelSelect.appendChild(option);
                    });
                    plantelContainer.classList.remove('hidden');
                } else {
                    plantelContainer.classList.add('hidden');
                }
            } else {
                plantelContainer.classList.add('hidden');
            }
            });

            function updateUsername() {
                if (userEditedUsername) return;
                let name = nameInput.value.trim().toUpperCase();
                let last1 = lastname1Input.value.trim().toUpperCase();
                let last2 = lastname2Input.value.trim().toUpperCase();

                let generated = '';
                if (name.length > 0) generated += name.charAt(0);
                if (last1.length > 0) generated += last1.replace(/\s+/g, '');
                if (last2.length > 0) generated += last2.charAt(0);

                usernameInput.value = generated;
            }

            nameInput.addEventListener('input', updateUsername);
            lastname1Input.addEventListener('input', updateUsername);
            lastname2Input.addEventListener('input', updateUsername);

            let debounceTimer;

            curpInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const curpVal = this.value.trim().toUpperCase();

                statusText.classList.add('hidden');
                statusText.classList.remove('text-green-600', 'text-red-600');

                if (curpVal.length === 18) {
                    // start ajax
                    statusText.textContent = "Buscando CURP...";
                    statusText.classList.remove('hidden');
                    statusText.classList.add('text-gray-500');

                    debounceTimer = setTimeout(() => {
                        fetch(`/users/search-curp/${curpVal}`)
                            .then(response => response.json())
                            .then(data => {
                                statusText.classList.remove('text-gray-500');
                                if (data.success) {
                                    // Auto-fill fields
                                    nameInput.value = data.data.name;
                                    lastname1Input.value = data.data.lastname;
                                    lastname2Input.value = data.data.lastname2;
                                    updateUsername();

                                    const sourceType = data.data.source === 'instructor' ? 'Instructor' : 'Alumno';
                                    statusText.textContent = `✓ Datos recuperados desde el registro de ${sourceType}`;
                                    statusText.classList.add('text-green-600');

                                    // Optional visual feedback to fields
                                    nameInput.classList.add('bg-green-50');
                                    lastname1Input.classList.add('bg-green-50');
                                    lastname2Input.classList.add('bg-green-50');
                                } else {
                                    // Clear auto-filled fields just in case
                                    nameInput.value = '';
                                    lastname1Input.value = '';
                                    lastname2Input.value = '';

                                    statusText.textContent = `✗ ${data.message}`;
                                    statusText.classList.add('text-red-600');

                                    // remove visual feedback
                                    nameInput.classList.remove('bg-green-50');
                                    lastname1Input.classList.remove('bg-green-50');
                                    lastname2Input.classList.remove('bg-green-50');
                                }
                            })
                            .catch(err => {
                                statusText.classList.remove('text-gray-500');
                                statusText.textContent = '✗ Error al verificar la CURP.';
                                statusText.classList.add('text-red-600');
                            });
                    }, 500);
                }
            });

            resetBtn.addEventListener('click', function () {
                statusText.classList.add('hidden');
                nameInput.classList.remove('bg-green-50');
                lastname1Input.classList.remove('bg-green-50');
                lastname2Input.classList.remove('bg-green-50');
            });
        });
    </script>
@endpush