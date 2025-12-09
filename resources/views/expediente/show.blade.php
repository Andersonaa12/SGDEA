<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Expediente: {{ $expediente->number }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('expedientes.index') }}" class="hover:text-indigo-600">Expedientes</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">{{ $expediente->number }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-pink-700 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold">{{ $expediente->number }}</h1>
                            <p class="text-2xl mt-2 opacity-95">{{ $expediente->subject }}</p>
                            <p class="mt-3 text-indigo-100">
                                Apertura: {{ $expediente->opening_date->format('d/m/Y') }} 
                                @if($expediente->closing_date) • Cierre: {{ $expediente->closing_date->format('d/m/Y') }} @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-6 py-3 rounded-full text-lg font-bold
                                {{ $expediente->status == 'abierto' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($expediente->status) }}
                            </span>
                            <p class="mt-3 text-indigo-100 text-lg font-medium">{{ ucfirst($expediente->phase) }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">
                    <!-- Información principal -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                            <p class="text-sm font-medium text-indigo-700">Serie Documental</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->serie->code ?? '—' }} - {{ $expediente->serie->name ?? 'Sin serie' }}
                            </p>
                        </div>
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                            <p class="text-sm font-medium text-indigo-700">Sección / Subsección</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->section?->name ?? '—' }} @if($expediente->subsection) / {{ $expediente->subsection->name }} @endif
                            </p>
                        </div>
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                            <p class="text-sm font-medium text-indigo-700">Documentos</p>
                            <p class="text-4xl font-bold text-indigo-700 mt-2">{{ $expediente->documents->count() }}</p>
                        </div>
                    </div>

                    @if($expediente->detail)
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <p class="font-semibold text-gray-700">Detalle del Expediente</p>
                            <p class="mt-3 text-gray-800 leading-relaxed">{{ $expediente->detail }}</p>
                        </div>
                    @endif

                    <!-- Documentos, Historial, Préstamos, etc. puedes añadirlos aquí con el mismo estilo premium -->

                    <div class="flex gap-4 mt-12 pt-8 border-t">
                        <a href="{{ route('expedientes.edit', $expediente) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Expediente
                        </a>
                        <a href="{{ route('expedientes.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>