<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v-1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Editar Serie: {{ $serie->code }} - {{ $serie->name }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('series.index') }}" class="hover:text-indigo-600">Series</a>
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

                    <form action="{{ route('series.update', $serie) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Copia exactamente el formulario del create.blade.php -->
                        <!-- Aquí va todo el formulario que ya tienes en create, solo cambia old() por old(..., $serie->campo) -->

                        <!-- TRD -->
                        <div>
                            <label for="trd_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                TRD Activa <span class="text-red-500">*</span>
                            </label>
                            <select name="trd_id" id="trd_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Seleccione una TRD --</option>
                                @foreach ($trds as $trd)
                                    <option value="{{ $trd->id }}" {{ old('trd_id', $serie->trd_id) == $trd->id ? 'selected' : '' }}>
                                        {{ $trd->version }} (Vigente: {{ $trd->valid_from }} @if($trd->valid_to) → {{ $trd->valid_to }} @endif)
                                    </option>
                                @endforeach
                            </select>
                            @error('trd_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Código y Nombre -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Código <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code" id="code" value="{{ old('code', $serie->code) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase"
                                       placeholder="Ej: 01" maxlength="10" required>
                                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre de la Serie <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $serie->name) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Ej: Correspondencia" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Descripción (opcional)
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Descripción general de los documentos que agrupa esta serie...">{{ old('description', $serie->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tiempos de Retención -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="retention_management_years" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Años en Gestión <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="retention_management_years" id="retention_management_years"
                                       value="{{ old('retention_management_years', $serie->retention_management_years) }}" min="0" max="99"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('retention_management_years') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="retention_central_years" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Años en Central <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="retention_central_years" id="retention_central_years"
                                       value="{{ old('retention_central_years', $serie->retention_central_years) }}" min="0" max="99"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('retention_central_years') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Disposición Final (radio buttons) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Disposición Final <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                @php
                                    $options = [
                                        'CT' => ['label' => 'Conservación Total', 'desc' => 'Se conserva permanentemente', 'color' => 'green'],
                                        'E'  => ['label' => 'Eliminación', 'desc' => 'Se destruye al finalizar el tiempo de retención', 'color' => 'red'],
                                        'S'  => ['label' => 'Selección / Muestreo', 'desc' => 'Se conserva solo una muestra representativa', 'color' => 'yellow'],
                                        'M'  => ['label' => 'Microfilmación o Digitalización', 'desc' => 'Se elimina el físico tras digitalizar con valor probatorio', 'color' => 'blue'],
                                    ];
                                @endphp

                                @foreach($options as $value => $opt)
                                    <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ old('final_disposition', $serie->final_disposition) == $value ? 'ring-2 ring-indigo-500 border-indigo-500' : '' }}">
                                        <input type="radio" name="final_disposition" value="{{ $value }}"
                                               {{ old('final_disposition', $serie->final_disposition) == $value ? 'checked' : '' }} required class="mt-1">
                                        <div class="ml-4">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-{{ $opt['color'] }}-600">{{ $value }}</span>
                                                <span class="font-semibold">{{ $opt['label'] }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ $opt['desc'] }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('final_disposition') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Procedimiento -->
                        <div>
                            <label for="disposition_procedure" class="block text-sm font-semibold text-gray-700 mb-2">
                                Procedimiento de Disposición (opcional)
                            </label>
                            <textarea name="disposition_procedure" id="disposition_procedure" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Ej: Acta de eliminación firmada por comité archivístico...">{{ old('disposition_procedure', $serie->disposition_procedure) }}</textarea>
                            @error('disposition_procedure') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4 pt-6">
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Actualizar Serie
                            </button>
                            <a href="{{ route('series.show', $serie) }}"
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