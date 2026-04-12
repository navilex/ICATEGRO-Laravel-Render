@extends('layouts.app')

@section('title', 'Reporte Alumnos Grupos - ICATEGRO')

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden pb-8 max-w-5xl mx-auto mt-8">
        <!-- Header -->
        <div class="bg-[#d4b996] p-6 text-center shadow-sm">
            <h1 class="text-3xl font-bold text-gray-800 uppercase flex items-center justify-center">
                <span class="text-green-600 text-3xl mr-3 shadow-sm bg-white rounded flex items-center justify-center w-10 h-10">
                    <i class="fas fa-file-excel"></i>
                </span>
                REPORTE ALUMNOS GRUPOS
            </h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-8">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reportes.alumnos-grupos.generar') }}" method="POST" class="px-8 mt-12">
            @csrf

            <!-- Generar de Section -->
            <div class="mt-8 relative flex items-center justify-center">
                <div class="absolute w-full z-0 px-8">
                    <div class="border-t-2 border-gray-400"></div>
                </div>
                <div class="bg-gradient-to-b from-gray-500 to-gray-700 text-white px-6 py-1.5 rounded-full font-bold z-10 shadow border-2 border-white shadow-gray-400">
                    Generar de
                </div>
            </div>

            <div class="px-8 mt-10">
                @if($errors->has('planteles'))
                    <div class="text-red-600 font-bold mb-4 text-center bg-red-100 p-2 rounded shadow-sm border border-red-300">
                        {{ $errors->first('planteles') }}
                    </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($planteles as $plantel)
                        <label class="flex items-center cursor-pointer group">
                            <div class="relative flex-shrink-0">
                                <input type="checkbox" name="planteles[]" value="{{ $plantel->id }}" class="sr-only peer" {{ (is_array(old('planteles')) && in_array($plantel->id, old('planteles'))) ? 'checked' : '' }}>
                                <div
                                    class="w-10 h-5 bg-gray-200 border-2 border-gray-300 rounded-full peer peer-checked:bg-green-500 peer-checked:border-green-600 transition-colors shadow-inner">
                                </div>
                                <div
                                    class="absolute inset-y-0 left-0 w-5 h-5 bg-white border border-gray-300 rounded-full shadow transition-transform transform peer-checked:translate-x-full peer-checked:border-green-600">
                                </div>
                            </div>
                            <div
                                class="ml-3 text-gray-700 font-semibold uppercase text-xs tracking-wide group-hover:text-gray-900 transition-colors">
                                {{ $plantel->name }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button Section -->
            <div class="mt-16 bg-cyan-50 -mx-8 py-4 px-8 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded-md shadow outline-none transition flex items-center">
                    Generar Reporte <i class="fas fa-file-excel ml-2"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
