<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Editar TRD: Versión {{ $trd->version }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('trds.index') }}" class="hover:text-indigo-600">TRDs</a>
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

                    <form action="{{ route('trds.update', $trd->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Versión -->
                        <div>
                            <label for="version" class="block text-sm font-semibold text-gray-700 mb-2">
                                Versión de la TRD <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="version" id="version" value="{{ old('version', $trd->version) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   min="1" required>
                            @error('version') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Fechas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="approval_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de Aprobación <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="approval_date" id="approval_date" value="{{ old('approval_date', $trd->approval_date) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('approval_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="valid_from" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Vigente Desde <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="valid_from" id="valid_from" value="{{ old('valid_from', $trd->valid_from) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('valid_from') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="valid_to" class="block text-sm font-semibold text-gray-700 mb-2">
                                Vigente Hasta (opcional)
                            </label>
                            <input type="date" name="valid_to" id="valid_to" value="{{ old('valid_to', $trd->valid_to) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('valid_to') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Archivo de Aprobación -->
                        <div>
                            <label for="approval_file" class="block text-sm font-semibold text-gray-700 mb-2">
                                Archivo de Aprobación (PDF)
                            </label>
                            <input type="file" name="approval_file" id="approval_file" accept=".pdf"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">

                            @if($trd->approval_file)
                                <div class="mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-sm text-green-800">
                                        <strong>Archivo actual:</strong>
                                        <a href="{{ Storage::url($trd->approval_file) }}" target="_blank" class="underline hover:text-green-900">
                                            Ver PDF actual
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @error('approval_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Estado Activo -->
                        <div>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="active" id="active"
                                       {{ old('active', $trd->active) ? 'checked' : '' }}
                                       class="w-6 h-6 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <span class="text-lg font-medium text-gray-700">TRD Activa</span>
                            </label>
                            <p class="text-sm text-gray-600 mt-1">
                                @if($trd->active)
                                    Esta TRD está actualmente vigente
                                @else
                                    Esta TRD está inactiva
                                @endif
                            </p>
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Actualizar TRD
                            </button>
                            <a href="{{ route('trds.show', $trd->id) }}"
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