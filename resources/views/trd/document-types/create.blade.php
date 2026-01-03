<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6 6h.008v.008H14.25V15m-6-3.75h.008v.008H8.25V15m6-6h.008v.008H14.25V9" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Crear Nuevo Tipo de Documento
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('subseries.index') }}" class="hover:text-purple-600">Subseries</a>
                    <span class="mx-2">/</span>
                    <span class="text-green-600 font-medium">Crear Tipo</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('document-types.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Subserie -->
                        <div>
                            <label for="subserie_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Subserie <span class="text-red-500">*</span>
                            </label>
                            <select name="subserie_id" id="subserie_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">-- Seleccione una subserie --</option>
                                @foreach($subseries as $sub)
                                    <option value="{{ $sub->id }}" {{ old('subserie_id') == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->code }} - {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subserie_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Código y Nombre -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Código <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code" id="code" value="{{ old('code') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 uppercase" required>
                                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Metadatos JSON -->
                        <div>
                            <label for="required_metadata" class="block text-sm font-semibold text-gray-700 mb-2">
                                Metadatos Requeridos (JSON) <span class="text-red-500">*</span>
                            </label>
                            <textarea name="required_metadata" id="required_metadata" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 font-mono text-sm">{{ old('required_metadata', '[]') }}</textarea>
                            <p class="text-xs text-gray-500 mt-2">Ejemplo: [{"key":"radicado","label":"Número de Radicado","type":"text"}]</p>
                            @error('required_metadata') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Checkboxes -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <label class="flex items-center space-x-4 cursor-pointer">
                                <input type="checkbox" name="analog" id="analog" {{ old('analog') ? 'checked' : '' }}
                                       class="w-6 h-6 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                                <span class="text-lg font-medium text-gray-700">Documento Análogo</span>
                            </label>
                            <label class="flex items-center space-x-4 cursor-pointer">
                                <input type="checkbox" name="requires_signature" id="requires_signature" {{ old('requires_signature') ? 'checked' : '' }}
                                       class="w-6 h-6 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <span class="text-lg font-medium text-gray-700">Requiere Firma</span>
                            </label>
                        </div>

                        <!-- Formatos -->
                        <div>
                            <label for="allowed_formats" class="block text-sm font-semibold text-gray-700 mb-2">
                                Formatos Permitidos <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="allowed_formats" id="allowed_formats" value="{{ old('allowed_formats', 'tiff,pdf/a') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                            <p class="text-xs text-gray-500 mt-2">Separados por coma: tiff,pdf/a,jpg</p>
                            @error('allowed_formats') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Crear Tipo de Documento
                            </button>
                            <a href="{{ route('document-types.index') }}"
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