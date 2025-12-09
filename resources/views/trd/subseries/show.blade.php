<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-purple-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Detalles de Subserie
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
                    <span class="mx-2">/</span>
                    <span class="text-purple-600 font-medium">{{ $subserie->code }} - {{ $subserie->name }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-4">
                                <span class="text-5xl font-bold opacity-90">{{ $subserie->code }}</span>
                                <div>
                                    <h1 class="text-3xl font-bold">{{ $subserie->name }}</h1>
                                    <p class="text-purple-100 mt-1">
                                        Serie: {{ $subserie->serie->name ?? '—' }} ({{ $subserie->serie->code ?? '' }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">

                    @if($subserie->description)
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Descripción</p>
                            <p class="text-gray-800 mt-3 leading-relaxed">{{ $subserie->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Serie Padre</p>
                            <p class="text-xl font-bold text-purple-700 mt-1">
                                {{ $subserie->serie->code }} - {{ $subserie->serie->name }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">TRD</p>
                            <p class="text-lg font-semibold text-indigo-700 mt-1">
                                Versión {{ $subserie->serie->trd->version ?? '—' }}
                            </p>
                        </div>
                    </div>

                    <!-- Tipos de Documento -->
                    @if($subserie->documentTypes->count() > 0)
                        <div class="mt-12 border-t pt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                Tipos de Documento ({{ $subserie->documentTypes->count() }})
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($subserie->documentTypes as $docType)
                                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 p-6 rounded-xl border border-pink-200 hover:shadow-xl transition transform hover:-translate-y-2">
                                        <p class="text-2xl font-bold text-pink-700">{{ $docType->code }}</p>
                                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ $docType->name }}</p>
                                        @if($docType->requires_signature)
                                            <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                                                Requiere Firma
                                            </span>
                                        @endif
                                        <div class="mt-4">
                                            <a href="{{ route('document-types.show', $docType->id) }}"
                                               class="text-xs text-pink-600 hover:text-pink-800 font-medium underline">
                                                Ver tipo de documento →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-12 text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                            <p class="text-xl text-gray-600">No hay tipos de documento definidos aún</p>
                            <a href="{{ route('document-types.create') }}" class="mt-4 inline-block text-purple-600 hover:underline font-medium">
                                Crear primer tipo de documento
                            </a>
                        </div>
                    @endif

                    <!-- Auditoría -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Creado por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $subserie->creator->name ?? 'Usuario eliminado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Última actualización</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $subserie->updater->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-12 pt-8 border-t">
                        <a href="{{ route('subseries.edit', $subserie->id) }}"
                           class="px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Subserie
                        </a>
                        <a href="{{ route('subseries.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>