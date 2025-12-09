<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-amber-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Subsección: {{ $subsection->code }} - {{ $subsection->name }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('subsections.index') }}" class="hover:text-amber-600">Subsecciones</a>
                    <span class="mx-2">/</span>
                    <span class="text-amber-600 font-medium">{{ $subsection->code }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-8 text-white">
                    <div class="flex items-center gap-6">
                        <div class="bg-white/20 backdrop-blur px-6 py-4 rounded-xl">
                            <p class="text-5xl font-bold">{{ $subsection->code }}</p>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold">{{ $subsection->name }}</h1>
                            <p class="text-amber-100 mt-2 text-lg">
                                Sección: {{ $subsection->section->name ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-medium">Ubicación Física</p>
                        <p class="text-xl font-semibold text-gray-800 mt-2">{{ $subsection->physical_location ?: 'No especificada' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Creado por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $subsection->creator->name ?? 'Usuario eliminado' }}</p>
                            <p class="text-xs text-gray-500">{{ $subsection->created_at?->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Última actualización</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $subsection->updater->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $subsection->updated_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($subsection->expedientes->count() > 0)
                        <div class="mt-12 border-t pt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                Expedientes Asociados ({{ $subsection->expedientes->count() }})
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($subsection->expedientes as $exp)
                                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-xl border border-amber-200 hover:shadow-lg transition transform hover:-translate-y-1">
                                        <p class="text-2xl font-bold text-amber-700">{{ $exp->code }}</p>
                                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ $exp->name }}</p>
                                        <div class="mt-4">
                                            <a href="{{ route('expedientes.show', $exp->id) }}" class="text-xs text-amber-600 hover:underline font-medium">
                                                Ver expediente →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-12 text-center py-12 bg-gray-50 rounded-xl">
                            <p class="text-gray-500 text-lg">No hay expedientes creados en esta subsección aún</p>
                        </div>
                    @endif

                    <div class="flex gap-4 mt-12 pt-8 border-t">
                        <a href="{{ route('subsections.edit', $subsection) }}"
                           class="px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Subsección
                        </a>
                        <a href="{{ route('subsections.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>