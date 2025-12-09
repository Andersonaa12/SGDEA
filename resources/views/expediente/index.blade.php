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
                    Expedientes Documentales
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <span class="text-indigo-600 font-medium">Expedientes</span>
                </nav>
            </div>
        </div>
    </x-slot>
    {{-- Tabs --}}
    @include('expediente.components.tabs')
    <!-- Cards de Estadísticas -->
    @include('expediente.components.statistics')
    {{-- Expedientes --}}
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">
                            Listado de Expedientes ({{ $expedientes->total() }})
                        </h3>
                        <a href="{{ route('expedientes.create') }}"
                           class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nuevo Expediente
                        </a>
                    </div>

                    <!-- Búsqueda -->
                    <form method="GET" class="mb-8 bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Número, asunto o detalle..."
                                   class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <select name="phase" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">Todas las fases</option>
                                <option value="gestión" {{ request('phase') == 'gestión' ? 'selected' : '' }}>Gestión</option>
                                <option value="central" {{ request('phase') == 'central' ? 'selected' : '' }}>Central</option>
                                <option value="historico" {{ request('phase') == 'historico' ? 'selected' : '' }}>Histórico</option>
                            </select>
                            <select name="status" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">Todos los estados</option>
                                <option value="abierto" {{ request('status') == 'abierto' ? 'selected' : '' }}>Abierto</option>
                                <option value="cerrado" {{ request('status') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                            </select>
                            <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow transition">
                                Buscar
                            </button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 to-pink-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Número</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Asunto</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Fase</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Documentos</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($expedientes as $exp)
                                    <tr class="hover:bg-indigo-50 transition">
                                        <td class="px-6 py-4 font-bold text-indigo-700">{{ $exp->number }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ Str::limit($exp->subject, 50) }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $exp->phase == 'gestión' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($exp->phase == 'central' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800') }}">
                                                {{ ucfirst($exp->phase->name) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $exp->status == 'abierto' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($exp->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                                {{ $exp->documents->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('expedientes.show', $exp) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                                <a href="{{ route('expedientes.edit', $exp) }}" class="text-green-600 hover:text-green-800 font-medium">Editar</a>
                                                <form action="{{ route('expedientes.destroy', $exp) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Eliminar expediente y todos sus documentos?')">
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="text-xl">No se encontraron expedientes</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $expedientes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>