<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 3a6 6 0 0 1-9.75 5.25C4.82 15.438 3 12.729 3 9.75 3 6.423 5.423 4 8.75 4a6 6 0 0 1 6.75 5.25Zm-6 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Permiso: {{ $permission->name }}</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('users.permissions.index') }}" class="hover:text-indigo-600">Permisos</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">{{ $permission->name }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-5xl font-bold">{{ $permission->name }}</h1>
                            <p class="text-2xl mt-2 opacity-95">Guard Name: {{ $permission->guard_name ?? 'web' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 text-sm">
                        <div>
                            <p class="text-indigo-200">Creado: <span class="font-bold text-white">{{ $permission->created_at }}</span></p>
                            <p class="text-indigo-200 mt-2">Actualizado: <span class="font-bold text-white">{{ $permission->updated_at }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Panel adicional para info relacionada, si aplica (e.g., roles que lo usan), pero como no hay data, mantener simple -->
                    <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                        <h3 class="font-bold text-indigo-900 mb-3">Detalles del Permiso</h3>
                        <p class="text-gray-700">Este permiso se usa para controlar accesos específicos en el sistema. Asegúrate de asignarlo correctamente a roles o usuarios.</p>
                    </div>

                    <div class="flex gap-4 pt-8 border-t">
                        <a href="{{ route('users.permissions.edit', $permission) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Permiso
                        </a>
                        <a href="{{ route('users.permissions.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>