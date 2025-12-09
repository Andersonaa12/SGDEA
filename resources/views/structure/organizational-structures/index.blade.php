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
                    Estructuras Organizacionales
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <span class="text-indigo-600 font-medium">Estructuras</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">
                            Listado de Estructuras ({{ $structures->total() }})
                        </h3>
                        <a href="{{ route('organizational-structures.create') }}"
                           class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nueva Estructura
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Versión</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Inicio</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Fin</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Secciones</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($structures as $structure)
                                    <tr class="hover:bg-indigo-50 transition">
                                        <td class="px-6 py-4 font-bold text-indigo-700">v{{ $structure->version }}</td>
                                        <td class="px-6 py-4 text-sm text-green-700 font-medium">{{ $structure->start_date }}</td>
                                        <td class="px-6 py-4 text-sm {{ $structure->end_date ? 'text-red-700' : 'text-gray-500' }}">
                                            {{ $structure->end_date ?? 'Indefinido' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold
                                                {{ $structure->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $structure->active ? 'ACTIVA' : 'INACTIVA' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                                {{ $structure->sections->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('organizational-structures.show', $structure) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                                <a href="{{ route('organizational-structures.edit', $structure) }}" class="text-green-600 hover:text-green-800 font-medium">Editar</a>
                                                <form action="{{ route('organizational-structures.destroy', $structure) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Eliminar esta estructura organizacional?')">
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
                                                <p class="text-xl">No hay estructuras organizacionales creadas aún</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $structures->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>