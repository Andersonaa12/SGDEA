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
                    Secciones Organizacionales
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <span class="text-teal-600 font-medium">Secciones</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">
                            Listado de Secciones ({{ $sections->total() }})
                        </h3>
                        <a href="{{ route('sections.create') }}"
                           class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nueva Sección
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-teal-50 to-cyan-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-teal-800 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-teal-800 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-teal-800 uppercase tracking-wider">Estructura</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-teal-800 uppercase tracking-wider">Responsable</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-teal-800 uppercase tracking-wider">Subsecciones</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-teal-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($sections as $section)
                                    <tr class="hover:bg-teal-50 transition">
                                        <td class="px-6 py-4 font-bold text-teal-700">{{ $section->code }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $section->name }}</td>
                                        <td class="px-6 py-4 text-sm">v{{ $section->structure->version ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $section->responsible?->name ?? 'Sin asignar' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800">
                                                {{ $section->subsections->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('sections.show', $section) }}" class="text-teal-600 hover:text-teal-800 font-medium">Ver</a>
                                                <a href="{{ route('sections.edit', $section) }}" class="text-green-600 hover:text-green-800 font-medium">Editar</a>
                                                <form action="{{ route('sections.destroy', $section) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Eliminar esta sección y sus subsecciones?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-16 text-gray-500">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2m-6 0h6" />
                                                </svg>
                                                <p class="text-xl">No hay secciones creadas aún</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $sections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>