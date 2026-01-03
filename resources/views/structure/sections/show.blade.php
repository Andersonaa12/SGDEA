<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21h1.5m-1.5-3h1.5m-1.5-3h1.5m3-6H15m-1.5 3H15m-1.5 3H15" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Sección: {{ $section->code }} - {{ $section->name }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('sections.index') }}" class="hover:text-teal-600">Secciones</a>
                    <span class="mx-2">/</span>
                    <span class="text-teal-600 font-medium">{{ $section->code }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="bg-white/20 backdrop-blur px-6 py-4 rounded-xl">
                                <p class="text-5xl font-bold">{{ $section->code }}</p>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold">{{ $section->name }}</h1>
                                <p class="text-teal-100 mt-2 text-lg">
                                    Estructura v{{ $section->structure->version ?? '—' }} • {{ $section->structure->start_date ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Ubicación Física</p>
                            <p class="text-xl font-semibold text-gray-800 mt-2">{{ $section->physical_location ?: 'No especificada' }}</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Responsable</p>
                            <p class="text-xl font-bold text-teal-700 mt-2">{{ $section->responsible?->name ?? 'Sin responsable asignado' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Creado por</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $section->creator->name ?? 'Usuario eliminado' }}</p>
                            <p class="text-xs text-gray-500">{{ $section->created_at?->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Última actualización</p>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ $section->updater->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $section->updated_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($section->subsections->count() > 0)
                        <div class="mt-12 border-t pt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                Subsecciones ({{ $section->subsections->count() }})
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($section->subsections as $sub)
                                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-6 rounded-xl border border-teal-200 hover:shadow-lg transition transform hover:-translate-y-1">
                                        <p class="text-2xl font-bold text-teal-700">{{ $sub->code }}</p>
                                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ $sub->name }}</p>
                                        @if($sub->responsible)
                                            <p class="text-sm text-gray-600 mt-2">Responsable: {{ $sub->responsible->name }}</p>
                                        @endif
                                        <div class="mt-4">
                                            <a href="{{ route('subsections.show', $sub->id) }}" class="text-xs text-teal-600 hover:underline font-medium">
                                                Ver subsección →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-12 text-center py-12 bg-gray-50 rounded-xl">
                            <p class="text-gray-500 text-lg">No hay subsecciones creadas aún</p>
                        </div>
                    @endif

                    <div class="flex gap-4 mt-12 pt-8 border-t">
                        <a href="{{ route('sections.edit', $section) }}"
                           class="px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Sección
                        </a>
                        <a href="{{ route('sections.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>