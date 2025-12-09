<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Expediente: {{ $expediente->number }}</h2>
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
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-5xl font-bold">{{ $expediente->number }}</h1>
                            <p class="text-2xl mt-2 opacity-95">{{ $expediente->subject }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-bold
                                @if($expediente->status === 'open') bg-green-100 text-green-800
                                @elseif($expediente->status === 'closed') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($expediente->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Fase</p>
                            <p class="text-2xl font-bold">{{ ucfirst($expediente->phase?->name ?? '—') }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Soporte</p>
                            <p class="text-2xl font-bold">{{ $expediente->supportType?->short_description ?? '—' }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Documentos</p>
                            <p class="text-4xl font-bold">{{ $expediente->documents->count() }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Versión</p>
                            <p class="text-4xl font-bold">{{ $expediente->version }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 text-sm">
                        <div>
                            <p class="text-indigo-200">Apertura: <span class="font-bold text-white">{{ $expediente->opening_date ?? '—' }}</span></p>
                            @if($expediente->closing_date)
                                <p class="text-indigo-200 mt-2">Cierre: <span class="font-bold text-white">{{ $expediente->closing_date }}</span></p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-indigo-200">Creado por: <span class="font-bold text-white">{{ $expediente->creator?->name ?? 'Sistema' }}</span></p>
                            <p class="text-indigo-200 mt-1">Actualizado: <span class="font-bold text-white">{{ $expediente->updated_at }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    @if($expediente->detail)
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="font-bold text-gray-800 mb-3">Detalle del Expediente</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $expediente->detail }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                            <p class="text-sm font-medium text-indigo-700">Serie / Subserie</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->serie?->code ?? '—' }} @if($expediente->subserie) / {{ $expediente->subserie->code }} @endif
                            </p>
                        </div>
                        <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
                            <p class="text-sm font-medium text-purple-700">Sección / Subsección</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->section?->name ?? '—' }} @if($expediente->subsection) / {{ $expediente->subsection->name }} @endif
                            </p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                            <p class="text-sm font-medium text-green-700">Estructura Organizacional</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->structure?->version ?? '—' }}
                            </p>
                        </div>
                    </div>

                    @if($expediente->supportType?->is_physical)
                        @if($expediente->currentLocation)
                            <div class="bg-amber-50 p-6 rounded-xl border border-amber-300">
                                <h4 class="font-bold text-amber-900 mb-3">Ubicación Física Actual</h4>
                                <p class="text-gray-800">
                                    {{ $expediente->currentLocation->full_location }}
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Asignada el {{ $expediente->currentLocation->created_at->format('d/m/Y') }}
                                    @if($expediente->currentLocation->creator)
                                        por {{ $expediente->currentLocation->creator->name }}
                                    @endif
                                </p>
                            </div>
                        @else
                            <p class="text-gray-500 italic">Sin ubicación física asignada</p>
                        @endif
                    @endif

                    <div class="flex gap-4 pt-8 border-t">
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