<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v-1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Detalles de Serie
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">{{ $serie->code }} - {{ $serie->name }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">

                <!-- Header de la Serie -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-4">
                                <span class="text-5xl font-bold opacity-90">{{ $serie->code }}</span>
                                <div>
                                    <h1 class="text-3xl font-bold">{{ $serie->name }}</h1>
                                    <p class="text-indigo-100 mt-1">
                                        TRD Versión {{ $serie->trd->version ?? '—' }}
                                        @if($serie->trd)
                                            • Vigente desde {{ $serie->trd->valid_from }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            @php
                                $dispColor = match($serie->final_disposition) {
                                    'CT' => 'bg-green-100 text-green-800',
                                    'E'  => 'bg-red-100 text-red-800',
                                    'S'  => 'bg-yellow-100 text-yellow-800',
                                    'M'  => 'bg-blue-100 text-blue-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                $dispLabel = match($serie->final_disposition) {
                                    'CT' => 'Conservación Total',
                                    'E'  => 'Eliminación',
                                    'S'  => 'Selección',
                                    'M'  => 'Microfilmación',
                                    default => 'Desconocida'
                                };
                            @endphp
                            <span class="inline-flex items-center px-5 py-3 rounded-full text-lg font-bold {{ $dispColor }}">
                                {{ $serie->final_disposition }} — {{ $dispLabel }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">

                    <!-- Tiempos de Retención -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-xl border border-green-200">
                            <p class="text-sm font-semibold text-green-700 uppercase tracking-wider">Años en Gestión</p>
                            <p class="text-5xl font-bold text-green-600 mt-3">{{ $serie->retention_management_years }}</p>
                            <p class="text-green-600 mt-2">Tiempo en oficina productora</p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-8 rounded-xl border border-blue-200">
                            <p class="text-sm font-semibold text-blue-700 uppercase tracking-wider">Años en Central</p>
                            <p class="text-5xl font-bold text-blue-600 mt-3">{{ $serie->retention_central_years }}</p>
                            <p class="text-blue-600 mt-2">Tiempo en archivo central</p>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if($serie->description)
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Descripción de la Serie</p>
                            <p class="text-gray-800 mt-3 leading-relaxed">{{ $serie->description }}</p>
                        </div>
                    @endif

                    <!-- Procedimiento de Disposición -->
                    @if($serie->disposition_procedure)
                        <div class="bg-amber-50 p-6 rounded-lg border border-amber-200">
                            <p class="text-sm font-semibold text-amber-700 uppercase tracking-wider">Procedimiento de Disposición Final</p>
                            <p class="text-gray-800 mt-3 leading-relaxed">{{ $serie->disposition_procedure }}</p>
                        </div>
                    @endif

                    <!-- Auditoría -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Creado por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">
                                {{ $serie->creator->name ?? 'Usuario eliminado' }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $serie->created_at?->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Última actualización por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">
                                {{ $serie->updater->name ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $serie->updated_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Subseries -->
                    @if($serie->subseries->count() > 0)
                        <div class="mt-12 border-t pt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                Subseries Asociadas ({{ $serie->subseries->count() }})
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($serie->subseries as $subserie)
                                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-200 hover:shadow-xl transition transform hover:-translate-y-2">
                                        <div class="flex items-start justify-between mb-3">
                                            <p class="text-2xl font-bold text-purple-700">{{ $subserie->code }}</p>
                                            @if($subserie->documentTypes->count() > 0)
                                                <span class="text-xs bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-medium">
                                                    {{ $subserie->documentTypes->count() }} tipo{{ $subserie->documentTypes->count() !== 1 ? 's' : '' }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-lg font-semibold text-gray-800">{{ $subserie->name }}</p>
                                        @if($subserie->description)
                                            <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $subserie->description }}</p>
                                        @endif
                                        <div class="mt-4">
                                            <a href="{{ route('subseries.show', $subserie->id) }}"
                                               class="text-xs text-purple-600 hover:text-purple-800 font-medium underline">
                                                Ver subserie →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-12 text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2m-6 0h6" />
                            </svg>
                            <p class="text-xl text-gray-600">No hay subseries definidas aún</p>
                            <a href="{{ route('subseries.create') }}" class="mt-4 inline-block text-indigo-600 hover:underline font-medium">
                                Crear primera subserie
                            </a>
                        </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="flex gap-4 mt-12 pt-8 border-t border-gray-200">
                        <a href="{{ route('series.edit', $serie->id) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Serie
                        </a>
                        <a href="{{ route('series.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>