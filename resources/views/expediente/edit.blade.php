<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Editar Expediente: {{ $expediente->number }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('expedientes.index') }}" class="hover:text-indigo-600">Expedientes</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Editar {{ $expediente->number }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-8">

                    <form action="{{ route('expedientes.update', $expediente) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <!-- Columna izquierda -->
                            <div class="space-y-6">
                                <div>
                                    <label for="number" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Número del Expediente <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="number" id="number" value="{{ old('number', $expediente->number) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Asunto <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="subject" id="subject" value="{{ old('subject', $expediente->subject) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="detail" class="block text-sm font-semibold text-gray-700 mb-2">Detalle</label>
                                    <textarea name="detail" id="detail" rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('detail', $expediente->detail) }}</textarea>
                                </div>

                                <div>
                                    <label for="opening_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Fecha de Apertura <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="opening_date" id="opening_date" value="{{ old('opening_date', $expediente->opening_date?->format('Y-m-d')) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('opening_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="closing_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha Cierre</label>
                                    <input type="date" name="closing_date" id="closing_date" value="{{ old('closing_date', $expediente->closing_date?->format('Y-m-d')) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="space-y-6">
                                <div>
                                    <label for="structure_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Estructura Organizacional <span class="text-red-500">*</span>
                                    </label>
                                    <select name="structure_id" id="structure_id" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach($structures as $structure)
                                            <option value="{{ $structure->id }}" {{ old('structure_id', $expediente->structure_id) == $structure->id ? 'selected' : '' }}>
                                                v{{ $structure->version }} - {{ $structure->description ?? 'Sin descripción' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="section_id" class="block text-sm font-semibold text-gray-700 mb-2">Sección</label>
                                    <select name="section_id" id="section_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Ninguna</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id', $expediente->section_id) == $section->id ? 'selected' : '' }}>
                                                {{ $section->code }} - {{ $section->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="subsection_id" class="block text-sm font-semibold text-gray-700 mb-2">Subsección</label>
                                    <select name="subsection_id" id="subsection_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Ninguna</option>
                                        @foreach($subsections as $subsection)
                                            <option value="{{ $subsection->id }}" {{ old('subsection_id', $expediente->subsection_id) == $subsection->id ? 'selected' : '' }}>
                                                {{ $subsection->code }} - {{ $subsection->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="serie_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Serie Documental <span class="text-red-500">*</span>
                                    </label>
                                    <select name="serie_id" id="serie_id" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach($series as $serie)
                                            <option value="{{ $serie->id }}" {{ old('serie_id', $expediente->serie_id) == $serie->id ? 'selected' : '' }}>
                                                {{ $serie->code }} - {{ $serie->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="subserie_id" class="block text-sm font-semibold text-gray-700 mb-2">Subserie</label>
                                    <select name="subserie_id" id="subserie_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Ninguna</option>
                                        @foreach($subseries as $subserie)
                                            <option value="{{ $subserie->id }}" {{ old('subserie_id', $expediente->subserie_id) == $subserie->id ? 'selected' : '' }}>
                                                {{ $subserie->code }} - {{ $subserie->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t">
                            <div>
                                <label for="phase" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fase <span class="text-red-500">*</span>
                                </label>
                                <select name="phase" id="phase" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    <option value="gestión" {{ old('phase', $expediente->phase) == 'gestión' ? 'selected' : '' }}>Gestión</option>
                                    <option value="central" {{ old('phase', $expediente->phase) == 'central' ? 'selected' : '' }}>Central</option>
                                    <option value="historico" {{ old('phase', $expediente->phase) == 'historico' ? 'selected' : '' }}>Histórico</option>
                                </select>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Estado <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    <option value="abierto" {{ old('status', $expediente->status) == 'abierto' ? 'selected' : '' }}>Abierto</option>
                                    <option value="cerrado" {{ old('status', $expediente->status) == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                                </select>
                            </div>

                            <div class="flex items-center space-x-3 pt-8">
                                <input type="checkbox" name="physical" id="physical" value="1" {{ old('physical', $expediente->physical) ? 'checked' : '' }}
                                       class="w-6 h-6 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="physical" class="text-lg font-medium text-gray-700 cursor-pointer">Expediente Físico</label>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-8 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Actualizar Expediente
                            </button>
                            <a href="{{ route('expedientes.show', $expediente) }}"
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