<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.825 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.75h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Gestión de Roles
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <span class="text-indigo-600 font-medium">Roles</span>
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
                            Listado de Roles ({{ $roles->total() }})
                        </h3>
                        <a href="{{ route('users.roles.create') }}"
                           class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            + Nuevo Rol
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($roles as $role)
                                    <tr class="hover:bg-indigo-50 transition">
                                        <td class="px-6 py-4 font-bold text-indigo-700">{{ $role->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $role->name }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('users.roles.show', $role) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                                <a href="{{ route('users.roles.edit', $role) }}" class="text-green-600 hover:text-green-800 font-medium">Editar</a>
                                                <form action="{{ route('users.roles.destroy', $role) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('¿Estás seguro?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-16 text-gray-500">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                                <p class="text-xl">No se encontraron roles</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>