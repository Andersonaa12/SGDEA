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
                    Subsecciones Organizacionales
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <span class="text-amber-600 font-medium">Subsecciones</span>
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
                            Listado de Subsecciones ({{ $subsections->total() }})
                        </h3>
                        <a href="{{ route('subsections.create') }}"
                           class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nueva Subsección
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-amber-50 to-orange-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Sección Padre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Expedientes</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($subsections as $sub)
                                    <tr class="hover:bg-amber-50 transition">
                                        <td class="px-6 py-4 font-bold text-amber-700">{{ $sub->code }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $sub->name }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $sub->section->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                {{ $sub->expedientes->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('subsections.show', $sub) }}" class="text-amber-600 hover:text-amber-800 font-medium">Ver</a>
                                                <a href="{{ route('subsections.edit', $sub) }}" class="text-green-600 hover:text-green-800 font-medium">Editar</a>
                                                <form action="{{ route('subsections.destroy', $sub) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Eliminar esta subsección y todos sus expedientes?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-16 text-gray-500">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                                <p class="text-xl">No hay subsecciones creadas aún</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $subsections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>