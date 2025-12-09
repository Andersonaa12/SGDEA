<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.125 1.125 0 0 1-1.125-1.125V6" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Tipos de Documento
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('subseries.index') }}" class="hover:text-purple-600">Subseries</a>
                    <span class="mx-2">/</span>
                    <span class="text-green-600 font-medium">Tipos de Documento</span>
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
                            Listado de Tipos de Documento ({{ $documentTypes->total() }})
                        </h3>
                        <a href="{{ route('document-types.create') }}"
                           class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nuevo Tipo de Documento
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-green-50 to-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Subserie</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">TRD</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Firma</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Análogo</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documentTypes as $doc)
                                    <tr class="hover:bg-green-50 transition">
                                        <td class="px-6 py-4 font-bold text-green-700">{{ $doc->code }}</td>
                                        <td class="px-6 py-4">{{ $doc->name }}</td>
                                        <td class="px-6 py-4 text-sm text-purple-700">
                                            {{ $doc->subserie->code ?? '—' }} - {{ $doc->subserie->name ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-indigo-700">
                                            v{{ $doc->subserie->serie->trd->version ?? '?' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($doc->requires_signature)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                    Requiere
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($doc->analog)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                                    Sí
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">Digital</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('document-types.show', $doc->id) }}" class="text-green-600 hover:text-green-800 font-medium">Ver</a>
                                                <a href="{{ route('document-types.edit', $doc->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Editar</a>
                                                <form action="{{ route('document-types.destroy', $doc->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Eliminar este tipo de documento?')">
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
                                                <p class="text-xl">No hay tipos de documento definidos aún</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $documentTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>