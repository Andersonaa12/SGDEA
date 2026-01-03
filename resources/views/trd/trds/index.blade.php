<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Tablas de Retención Documental
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <span class="text-indigo-600 font-medium">TRDs</span>
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
                            Listado de TRDs ({{ $trds->total() }})
                        </h3>
                        <a href="{{ route('trds.create') }}"
                           class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nueva TRD
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Versión</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Aprobación</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Vigente Desde</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Hasta</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Series</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($trds as $trd)
                                    <tr class="hover:bg-indigo-50 transition">
                                        <td class="px-6 py-4 font-bold text-indigo-700">v{{ $trd->version }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $trd->approval_date }}</td>
                                        <td class="px-6 py-4 text-sm text-green-700 font-medium">
                                            {{ $trd->valid_from }}
                                        </td>
                                        <td class="px-6 py-4 text-sm {{ $trd->valid_to ? 'text-red-700' : 'text-gray-500' }}">
                                            {{ $trd->valid_to ?? 'Indefinido' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold
                                                {{ $trd->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $trd->active ? 'ACTIVA' : 'INACTIVA' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                                {{ $trd->series->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('trds.show', $trd->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                                <a href="{{ route('trds.edit', $trd->id) }}" class="text-green-600 hover:text-green-800 font-medium">Editar</a>
                                                <form action="{{ route('trds.destroy', $trd->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Eliminar esta TRD?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-16 text-gray-500">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="text-xl">No hay TRDs creadas aún</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $trds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>