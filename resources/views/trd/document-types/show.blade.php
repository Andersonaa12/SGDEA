<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.125 1.125 0 0 1-1.125-1.125V6" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Detalles del Tipo de Documento
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('subseries.index') }}" class="hover:text-purple-600">Subseries</a>
                    <span class="mx-2">/</span>
                    <span class="text-green-600 font-medium">{{ $documentType->code }} - {{ $documentType->name }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-4">
                                <span class="text-5xl font-bold opacity-90">{{ $documentType->code }}</span>
                                <div>
                                    <h1 class="text-3xl font-bold">{{ $documentType->name }}</h1>
                                    <p class="text-green-100 mt-1">
                                        Subserie: {{ $documentType->subserie->name ?? '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            @if($documentType->requires_signature)
                                <span class="px-5 py-3 bg-red-100 text-red-800 rounded-full text-lg font-bold">
                                    Requiere Firma
                                </span>
                            @endif
                            @if($documentType->analog)
                                <span class="px-5 py-3 bg-orange-100 text-orange-800 rounded-full text-lg font-bold">
                                    Análogo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">
                    <!-- Jerarquía -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-200">
                            <p class="text-sm font-semibold text-indigo-700">TRD</p>
                            <p class="text-xl font-bold text-indigo-800 mt-2">
                                v{{ $documentType->subserie->serie->trd->version ?? '?' }}
                            </p>
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <p class="text-sm font-semibold text-blue-700">Serie</p>
                            <p class="text-xl font-bold text-blue-800 mt-2">
                                {{ $documentType->subserie->serie->code ?? '?' }}
                            </p>
                        </div>
                        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                            <p class="text-sm font-semibold text-purple-700">Subserie</p>
                            <p class="text-xl font-bold text-purple-800 mt-2">
                                {{ $documentType->subserie->code ?? '?' }}
                            </p>
                        </div>
                    </div>

                    <!-- Metadatos -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Metadatos Requeridos</p>
                        <pre class="mt-4 p-4 bg-white rounded-lg border text-sm font-mono overflow-x-auto">
{{ json_encode($documentType->required_metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>

                    <!-- Formatos -->
                    <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-200">
                        <p class="text-sm font-semibold text-emerald-700 uppercase tracking-wider">Formatos Permitidos</p>
                        <div class="flex flex-wrap gap-3 mt-4">
                            @foreach(explode(',', $documentType->allowed_formats) as $format)
                                <span class="px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-bold">
                                    .{{ trim($format) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Auditoría -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Creado por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">
                                {{ $documentType->creator->name ?? 'Usuario eliminado' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Última actualización</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">
                                {{ $documentType->updater->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-12 pt-8 border-t">
                        <a href="{{ route('document-types.edit', $documentType->id) }}"
                           class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Tipo de Documento
                        </a>
                        <a href="{{ route('document-types.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>