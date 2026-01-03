<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Usuario: {{ $user->name }}</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('users.index') }}" class="hover:text-indigo-600">Usuarios</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">{{ $user->name }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-5xl font-bold">{{ $user->name }}</h1>
                            <p class="text-2xl mt-2 opacity-95">{{ $user->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-bold
                                {{ $user->active ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $user->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Identificación</p>
                            <p class="text-2xl font-bold">{{ $user->identification ?? '—' }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Teléfono</p>
                            <p class="text-2xl font-bold">{{ $user->phone ?? '—' }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Posición</p>
                            <p class="text-2xl font-bold">{{ $user->position ?? '—' }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                            <p class="text-indigo-200 text-sm">Sección Principal</p>
                            <p class="text-2xl font-bold">{{ $user->section?->name ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 text-sm">
                        <div>
                            <p class="text-indigo-200">Creado: <span class="font-bold text-white">{{ $user->created_at }}</span></p>
                            <p class="text-indigo-200 mt-2">Actualizado: <span class="font-bold text-white">{{ $user->updated_at }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                            <h3 class="font-bold text-indigo-900 mb-3">Roles</h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                @foreach ($user->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                                @if ($user->roles->isEmpty())
                                    <li class="italic">Ninguno</li>
                                @endif
                            </ul>
                        </div>

                        <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
                            <h3 class="font-bold text-purple-900 mb-3">Permisos Directos</h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                @foreach ($user->getDirectPermissions() as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                                @if ($user->getDirectPermissions()->isEmpty())
                                    <li class="italic">Ninguno</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                            <h3 class="font-bold text-green-900 mb-3">Secciones Asignadas</h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                @foreach ($user->sections as $section)
                                    <li>{{ $section->name }} (Rol: {{ $section->pivot->role_in_section ?? 'N/A' }})</li>
                                @endforeach
                                @if ($user->sections->isEmpty())
                                    <li class="italic">Ninguna</li>
                                @endif
                            </ul>
                        </div>

                        <div class="bg-amber-50 p-6 rounded-xl border border-amber-200">
                            <h3 class="font-bold text-amber-900 mb-3">Subsecciones Asignadas</h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                @foreach ($user->subsections as $subsection)
                                    <li>{{ $subsection->name }} (Rol: {{ $subsection->pivot->role_in_subsection ?? 'N/A' }})</li>
                                @endforeach
                                @if ($user->subsections->isEmpty())
                                    <li class="italic">Ninguna</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-8 border-t">
                        <a href="{{ route('users.edit', $user) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Usuario
                        </a>
                        <a href="{{ route('users.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>