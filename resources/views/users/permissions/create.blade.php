<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 3a6 6 0 0 1-9.75 5.25C4.82 15.438 3 12.729 3 9.75 3 6.423 5.423 4 8.75 4a6 6 0 0 1 6.75 5.25Zm-6 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Crear Nuevo Permiso</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('users.permissions.index') }}" class="hover:text-indigo-600">Permisos</a>
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
                    <form action="{{ route('users.permissions.store') }}" method="POST" class="space-y-8">
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

                            <!-- Columna Derecha (vacía para balance, o agregar info si es necesario) -->
                            <div class="space-y-6">
                                <!-- Puedes agregar una nota o tip aquí para mejorar UX -->
                                <div class="bg-indigo-50 p-4 rounded-lg">
                                    <p class="text-sm text-indigo-700">Consejo: El nombre del permiso debe ser único y descriptivo, como 'editar-expedientes'.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-8 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Crear Permiso
                            </button>
                            <a href="{{ route('users.permissions.index') }}"
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