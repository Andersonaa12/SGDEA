<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Detalles de Estructura Organizacional – Versión {{ $structure->version }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('organizational-structures.index') }}" class="hover:text-indigo-600">Estructuras</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Versión {{ $structure->version }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold">Estructura Organizacional</h1>
                            <p class="text-indigo-100 mt-1">Versión {{ $structure->version }} • Vigente desde {{ $structure->start_date }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold
                                {{ $structure->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $structure->active ? 'ACTIVA' : 'INACTIVA' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Fecha de Inicio</p>
                            <p class="text-2xl font-bold text-green-600 mt-2">{{ $structure->start_date }}</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Fecha de Fin</p>
                            <p class="text-2xl font-bold {{ $structure->end_date ? 'text-red-600' : 'text-gray-500' }} mt-2">
                                {{ $structure->end_date ?? 'Indefinido' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Secciones Definidas</p>
                            <p class="text-2xl font-bold text-indigo-700 mt-2">{{ $structure->sections->count() }}</p>
                        </div>
                    </div>

                    @if($structure->description)
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
                            <p class="text-sm font-semibold text-indigo-900 mb-2">Descripción</p>
                            <p class="text-indigo-800 leading-relaxed">{{ $structure->description }}</p>
                        </div>
                    @endif

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-blue-900">Documento de Aprobación</p>
                                @if($structure->approval_file)
                                    <p class="text-blue-700 mt-2">
                                        <a href="{{ Storage::url($structure->approval_file) }}" target="_blank"
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Creado por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $structure->creator->name ?? 'Usuario eliminado' }}</p>
                            <p class="text-xs text-gray-500">{{ $structure->created_at?->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Última actualización por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $structure->updater->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $structure->updated_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($structure->sections->count() > 0)
                        <div class="mt-12 border-t pt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                Secciones Asociadas ({{ $structure->sections->count() }})
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($structure->sections as $section)
                                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200 hover:shadow-lg transition transform hover:-translate-y-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-2xl font-bold text-indigo-700">{{ $section->code }}</p>
                                                <p class="text-lg font-semibold text-gray-800 mt-1">{{ $section->name }}</p>
                                            </div>
                                        </div>
                                        @if($section->description)
                                            <p class="text-sm text-gray-600 mt-3 line-clamp-2">{{ $section->description }}</p>
                                        @endif
                                        <div class="mt-4">
                                            <a href="{{ route('sections.show', $section->id) }}"
                                               class="text-xs text-indigo-600 hover:underline font-medium">
                                                Ver detalles
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-12 text-center py-12 bg-gray-50 rounded-xl">
                            <p class="text-gray-500 text-lg">No hay secciones definidas en esta estructura aún.</p>
                        </div>
                    @endif

                    <div class="flex gap-4 mt-12 pt-8 border-t">
                        <a href="{{ route('organizational-structures.edit', $structure) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Estructura
                        </a>
                        <a href="{{ route('organizational-structures.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>