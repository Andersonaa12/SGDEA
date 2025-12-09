<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Detalles de TRD – Versión {{ $trd->version }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Versión {{ $trd->version }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold">Tabla de Retención Documental</h1>
                            <p class="text-indigo-100 mt-1">Versión {{ $trd->version }} • Vigente desde {{ $trd->valid_from }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold
                                {{ $trd->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $trd->active ? 'ACTIVA' : 'INACTIVA' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">

                    <!-- Información Principal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Fecha de Aprobación</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">
                                {{ $trd->approval_date }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Vigente Desde</p>
                            <p class="text-2xl font-bold text-green-600 mt-2">
                                {{ $trd->valid_from }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Vigente Hasta</p>
                            <p class="text-2xl font-bold {{ $trd->valid_to ? 'text-red-600' : 'text-gray-500' }} mt-2">
                                {{ $trd->valid_to ?? 'Indefinido' }}
                            </p>
                        </div>
                    </div>

                    <!-- Archivo de Aprobación -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-blue-900">Documento de Aprobación</p>
                                @if($trd->approval_file)
                                    <p class="text-blue-700 mt-2">
                                        <a href="{{ Storage::url($trd->approval_file) }}" target="_blank"
                                           class="inline-flex items-center gap-2 underline hover:text-blue-900 font-medium">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Ver PDF de aprobación
                                        </a>
                                    </p>
                                @else
                                    <p class="text-gray-500 mt-2 italic">No se ha cargado documento de aprobación</p>
                                @endif
                            </div>
                            <div class="text-blue-600">
                                <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Auditoría -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Creado por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">
                                {{ $trd->creator->name ?? 'Usuario eliminado' }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $trd->created_at?->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Última actualización por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">
                                {{ $trd->updater->name ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $trd->updated_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Series Asociadas -->
                    @if($trd->series->count() > 0)
                        <div class="mt-12 border-t pt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                Series Definidas ({{ $trd->series->count() }})
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($trd->series as $serie)
                                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200 hover:shadow-lg transition transform hover:-translate-y-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-2xl font-bold text-indigo-700">{{ $serie->code }}</p>
                                                <p class="text-lg font-semibold text-gray-800 mt-1">{{ $serie->name }}</p>
                                            </div>
                                            <span class="text-xs bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full font-medium">
                                                {{ $serie->subseries->count() }} subserie{{ $serie->subseries->count() !== 1 ? 's' : '' }}
                                            </span>
                                        </div>
                                        @if($serie->description)
                                            <p class="text-sm text-gray-600 mt-3 line-clamp-2">{{ $serie->description }}</p>
                                        @endif
                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('series.show', $serie->id) }}"
                                               class="text-xs text-indigo-600 hover:underline font-medium">
                                                Ver detalles →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-12 text-center py-12 bg-gray-50 rounded-xl">
                            <p class="text-gray-500 text-lg">No hay series definidas aún en esta TRD.</p>
                            <a href="{{ route('series.create') }}" class="mt-4 inline-block text-indigo-600 hover:underline font-medium">
                                Crear primera serie
                            </a>
                        </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="flex gap-4 mt-12 pt-8 border-t">
                        <a href="{{ route('trds.edit', $trd->id) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar TRD
                        </a>
                        <a href="{{ route('trds.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>