<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Editar Estructura Organizacional: Versión {{ $structure->version }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('organizational-structures.index') }}" class="hover:text-indigo-600">Estructuras</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Editar</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-8">

                    <form action="{{ route('organizational-structures.update', $structure) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="version" class="block text-sm font-semibold text-gray-700 mb-2">
                                Versión <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="version" id="version" value="{{ old('version', $structure->version) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            @error('version') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('description', $structure->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de Inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $structure->start_date) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de Fin (opcional)
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $structure->end_date) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="approval_file" class="block text-sm font-semibold text-gray-700 mb-2">
                                Archivo de Aprobación (PDF)
                            </label>
                            <input type="file" name="approval_file" id="approval_file" accept=".pdf"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">

                            @if($structure->approval_file)
                                <div class="mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-sm text-green-800">
                                        <strong>Archivo actual:</strong>
                                        <a href="{{ Storage::url($structure->approval_file) }}" target="_blank" class="underline hover:text-green-900">
                                            Ver PDF actual
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @error('approval_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="active" id="active"
                                       {{ old('active', $structure->active) ? 'checked' : '' }}
                                       class="w-6 h-6 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <span class="text-lg font-medium text-gray-700">Estructura Activa</span>
                            </label>
                            <p class="text-sm text-gray-600 mt-1">
                                @if($structure->active) Esta estructura está actualmente vigente @else Esta estructura está inactiva @endif
                            </p>
                        </div>

                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Actualizar Estructura
                            </button>
                            <a href="{{ route('organizational-structures.show', $structure) }}"
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