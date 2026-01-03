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
                    Crear Nueva Subserie
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
                    <span class="mx-2">/</span>
                    <span class="text-purple-600 font-medium">Crear Subserie</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('subseries.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Serie Padre -->
                        <div>
                            <label for="serie_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Serie Padre <span class="text-red-500">*</span>
                            </label>
                            <select name="serie_id" id="serie_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                                <option value="">-- Seleccione una serie --</option>
                                @foreach($series as $serie)
                                    <option value="{{ $serie->id }}" {{ old('serie_id') == $serie->id ? 'selected' : '' }}>
                                        {{ $serie->code }} - {{ $serie->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('serie_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Código y Nombre -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Código de Subserie <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code" id="code" value="{{ old('code') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 uppercase"
                                       placeholder="Ej: 01.01" maxlength="10" required>
                                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre de la Subserie <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                       placeholder="Ej: Correspondencia Recibida" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Descripción (opcional)
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                      placeholder="Descripción detallada de los documentos que agrupa esta subserie...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Crear Subserie
                            </button>
                            <a href="{{ route('subseries.index') }}"
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