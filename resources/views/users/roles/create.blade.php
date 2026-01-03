<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.825 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.75h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Crear Nuevo Rol</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('users.roles.index') }}" class="hover:text-indigo-600">Roles</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Crear</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('users.roles.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <!-- Columna Izquierda -->
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nombre <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="guard_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Guard Name (opcional)
                                    </label>
                                    <input type="text" name="guard_name" id="guard_name" value="{{ old('guard_name') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('guard_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Permisos</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach ($permissions as $permission)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-indigo-600">
                                                <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-8 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Crear Rol
                            </button>
                            <a href="{{ route('users.roles.index') }}"
                               class="px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>