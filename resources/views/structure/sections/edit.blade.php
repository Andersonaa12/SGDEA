<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21h1.5m-1.5-3h1.5m-1.5-3h1.5m3-6H15m-1.5 3H15m-1.5 3H15" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Editar Sección: {{ $section->code }} - {{ $section->name }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('sections.index') }}" class="hover:text-teal-600">Secciones</a>
                    <span class="mx-2">/</span>
                    <span class="text-teal-600 font-medium">Editar</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-8">

                    <form action="{{ route('sections.update', $section) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="structure_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Estructura Organizacional <span class="text-red-500">*</span>
                            </label>
                            <select name="structure_id" id="structure_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                                <option value="">Seleccionar estructura</option>
                                @foreach ($structures as $structure)
                                    <option value="{{ $structure->id }}"
                                        {{ old('structure_id', $section->structure_id) == $structure->id ? 'selected' : '' }}>
                                        v{{ $structure->version }} - {{ $structure->start_date }}
                                    </option>
                                @endforeach
                            </select>
                            @error('structure_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Código <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code" id="code" value="{{ old('code', $section->code) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition" required>
                                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $section->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="physical_location" class="block text-sm font-semibold text-gray-700 mb-2">
                                Ubicación Física
                            </label>
                            <input type="text" name="physical_location" id="physical_location" value="{{ old('physical_location', $section->physical_location) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                            @error('physical_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="responsible_user_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Responsable
                            </label>
                            <select name="responsible_user_id" id="responsible_user_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                                <option value="">Ninguno</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('responsible_user_id', $section->responsible_user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('responsible_user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Actualizar Sección
                            </button>
                            <a href="{{ route('sections.show', $section) }}"
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