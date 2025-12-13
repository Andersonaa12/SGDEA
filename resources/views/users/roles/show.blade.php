<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.825 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.75h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Rol: {{ $role->name }}</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('users.roles.index') }}" class="hover:text-indigo-600">Roles</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">{{ $role->name }}</span>
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
                            <h1 class="text-5xl font-bold">{{ $role->name }}</h1>
                            <p class="text-2xl mt-2 opacity-95">Guard Name: {{ $role->guard_name ?? 'web' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 text-sm">
                        <div>
                            <p class="text-indigo-200">Creado: <span class="font-bold text-white">{{ $role->created_at }}</span></p>
                            <p class="text-indigo-200 mt-2">Actualizado: <span class="font-bold text-white">{{ $role->updated_at }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                        <h3 class="font-bold text-indigo-900 mb-3">Permisos Asignados</h3>
                        <ul class="list-disc pl-5 space-y-1 text-gray-700">
                            @foreach ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                            @if ($role->permissions->isEmpty())
                                <li class="italic">Ninguno</li>
                            @endif
                        </ul>
                    </div>

                    <div class="flex gap-4 pt-8 border-t">
                        <a href="{{ route('users.roles.edit', $role) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Rol
                        </a>
                        <a href="{{ route('users.roles.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>