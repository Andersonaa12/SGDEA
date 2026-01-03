<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-purple-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Subseries
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
                    <span class="mx-2">/</span>
                    <span class="text-purple-600 font-medium">Subseries</span>
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
                            Listado de Subseries ({{ $subseries->total() }})
                        </h3>
                        <a href="{{ route('subseries.create') }}"
                           class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nueva Subserie
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-50 to-pink-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-800 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-800 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-800 uppercase tracking-wider">Serie</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-800 uppercase tracking-wider">TRD</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-800 uppercase tracking-wider">Tipos Doc.</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($subseries as $subserie)
                                    <tr class="hover:bg-purple-50 transition">
                                        <td class="px-6 py-4 font-bold text-purple-700">{{ $subserie->code }}</td>
                                        <td class="px-6 py-4">{{ $subserie->name }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $subserie->serie->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            v{{ $subserie->serie->trd->version ?? '?' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                                {{ $subserie->documentTypes->count() > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $subserie->documentTypes->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('subseries.show', $subserie->id) }}" class="text-purple-600 hover:text-purple-800 font-medium">Ver</a>
                                                <a href="{{ route('subseries.edit', $subserie->id) }}" class="text-green-600 hover:text-green-800 font-medium">Editar</a>
                                                <form action="{{ route('subseries.destroy', $subserie->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Eliminar esta subserie?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12 text-gray-500">
                                            No hay subseries creadas aún.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $subseries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>