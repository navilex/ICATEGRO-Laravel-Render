<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ICATEGRO')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Unified Menu Bar -->
    <nav class="bg-red-800 text-white shadow-lg relative z-50">
        <div class="w-full px-2 md:px-4 py-2 relative">
            <div class="flex flex-nowrap items-center justify-between gap-2">

                <!-- Left: User Info -->
                <div class="flex items-center space-x-2 whitespace-nowrap min-w-max">
                    <i class="fas fa-user-circle text-2xl"></i>
                    <div class="flex flex-col leading-tight">
                        <span class="font-bold text-sm uppercase">{{ Auth::user()->name }}</span>
                        <span class="text-xs uppercase opacity-90">{{ Auth::user()->lastname }}</span>
                    </div>
                </div>

                <!-- Center: Navigation Links -->
                <div class="flex flex-nowrap items-center justify-center gap-1 flex-grow hide-scrollbar">
                    <a href="{{ route('dashboard') }}"
                        class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition whitespace-nowrap">Principal</a>

                    <!-- Alumnos Dropdown -->
                    <div class="relative group">
                        <button
                            class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition flex items-center focus:outline-none whitespace-nowrap">
                            Alumnos <i class="fas fa-caret-down ml-1 text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-48 bg-white rounded shadow-lg hidden group-hover:block z-50 border border-gray-200">
                            <a href="{{ route('students.create') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Registrar
                                alumno</a>
                            <a href="{{ route('students.index') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Lista
                                de alumnos</a>
                        </div>
                    </div>

                    <div class="relative group">
                        <button
                            class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition flex items-center focus:outline-none whitespace-nowrap">
                            Grupos <i class="fas fa-caret-down ml-1 text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-48 bg-white rounded shadow-lg hidden group-hover:block z-50 border border-gray-200 overflow-hidden">
                            <a href="{{ route('grupos.create') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Registrar
                                grupo</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Lista
                                de grupos</a>
                        </div>
                    </div>

                    <div class="relative group">
                        <button
                            class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition flex items-center focus:outline-none whitespace-nowrap">
                            Empresas / Instituciones <i class="fas fa-caret-down ml-1 text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-48 bg-white rounded shadow-lg hidden group-hover:block z-50 border border-gray-200">
                            <a href="{{ route('companies.create') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Registrar
                                empresa/Institución</a>
                            <a href="{{ route('companies.index') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Lista
                                de empresas/Instituciones</a>
                        </div>
                    </div>

                    <div class="relative group">
                        <button
                            class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition flex items-center focus:outline-none whitespace-nowrap">
                            Instructores <i class="fas fa-caret-down ml-1 text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-48 bg-white rounded shadow-lg hidden group-hover:block z-50 border border-gray-200">
                            <a href="{{ route('instructores.create') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Registrar
                                instructor</a>
                            <a href="{{ route('instructores.index') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Lista
                                de instructores</a>
                        </div>
                    </div>
                    <div class="relative group">
                        <button type="button"
                            class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition flex items-center focus:outline-none whitespace-nowrap">
                            Convenios <i class="fas fa-caret-down ml-1 text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-48 bg-white rounded shadow-lg hidden group-hover:block z-50 border border-gray-200">
                            <a href="{{ route('convenios.create') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Registrar
                                Convenio</a>
                            <a href="{{ route('convenios.index') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Lista
                                de convenios</a>
                        </div>
                    </div>
                    <div class="relative group">
                        <button type="button"
                            class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition flex items-center focus:outline-none whitespace-nowrap">
                            Usuarios <i class="fas fa-caret-down ml-1 text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-48 bg-white rounded shadow-lg hidden group-hover:block z-50 border border-gray-200">
                            <a href="{{ route('users.create') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-100">Registrar
                                usuario</a>
                            <a href="{{ route('users.index') }}"
                                class="block px-4 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Listado
                                de usuarios</a>
                        </div>
                    </div>
                    <a href="#"
                        class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition whitespace-nowrap">Reportes</a>
                    <div class="relative group">
                        <button type="button"
                            class="px-2 py-2 text-sm font-bold rounded hover:bg-red-700 transition flex items-center focus:outline-none whitespace-nowrap">
                            Catálogos <i class="fas fa-caret-down ml-1 text-xs"></i>
                        </button>
                        <div
                            class="absolute right-0 mt-1 w-80 bg-white rounded shadow-lg hidden group-hover:block z-50 border border-gray-200">

                            <!-- Oferta Educativa -->
                            <div class="px-4 py-2 text-sm font-bold text-gray-900 bg-gray-100 border-b border-gray-200">
                                Oferta educativa
                            </div>
                            <a href="{{ route('ofertas-educativas.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-100">Registrar
                                nueva Oferta Educativa</a>
                            <a href="{{ route('campos-formacion.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-100">Registrar
                                Campos de Formación Profesional</a>
                            <a href="{{ route('especialidades-ocupacionales.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-100">Registrar
                                Especialidades Ocupacionales</a>
                            <a href="{{ route('cursos.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-100">Registrar
                                Cursos</a>
                            <a href="{{ route('cursos-icategro.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-100">Registrar
                                Cursos - ICATEGRO</a>
                            <a href="{{ route('consulta-oferta.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-200">Consultar
                                Oferta Educativa</a>

                            <!-- Planteles -->
                            <div class="px-4 py-2 text-sm font-bold text-gray-900 bg-gray-100 border-b border-gray-200">
                                Planteles
                            </div>
                            <a href="{{ route('planteles.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition border-b border-gray-100">Registrar
                                Plantel</a>
                            <a href="{{ route('consulta-planteles.index') }}"
                                class="block px-6 py-2 text-sm text-gray-800 hover:bg-red-800 hover:text-white font-semibold transition">Consultar
                                Planteles</a>
                        </div>
                    </div>
                </div>

                <!-- Right: Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center bg-red-900 hover:bg-red-950 text-white px-4 py-2 rounded text-sm font-bold transition shadow-sm border border-red-700">
                        <i class="fas fa-sign-out-alt mr-2"></i> Salir
                    </button>
                </form>

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6 mt-8">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h4 class="font-bold text-white mb-2">Usuario Conectado</h4>
                <p class="text-sm">Nombre: {{ Auth::user()->name }} {{ Auth::user()->lastname }}</p>
                <p class="text-sm">Adscripción: {{ Auth::user()->adscription ?? 'No definida' }}</p>
                <p class="text-sm">Rol: Administrador (Demo)</p>
            </div>
            <div class="text-right flex flex-col justify-end">
                <p class="text-sm">&copy; {{ date('Y') }} ICATEGRO. Todos los derechos reservados.</p>
                <p class="text-xs text-gray-500 mt-1">Versión 1.0.0</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>