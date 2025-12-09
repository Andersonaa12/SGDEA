<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-amber-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">
                    Editar Subsección: {{ $subsection->code }} - {{ $subsection->name }}
                </h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('subsections.index') }}" class="hover:text-amber-600">Subsecciones</a>
                    <span class="mx-2">/</span>
                    <span class="text-amber-600 font-medium">Editar</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('subsections.update', $subsection) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Igual que create, pero con valores antiguos -->
                        <div>
                            <label for="section_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Sección Padre <span class="text-red-500">*</span>
                            </label>
                            <select name="section_id" id="section_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                                <option value="">Seleccionar sección</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ old('section_id', $subsection->section_id) == $section->id ? 'selected' : '' }}>
                                        {{ $section->code }} - {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">Código *</label>
                                <input type="text" name="code" id="code" value="{{ old('code', $subsection->code) }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $subsection->name) }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            </div>
                        </div>

                        <div>
                            <label for="physical_location" class="block text-sm font-semibold text-gray-700 mb-2">Ubicación Física</label>
                            <input type="text" name="physical_location" id="physical_location" value="{{ old('physical_location', $subsection->physical_location) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                        </div>

                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Actualizar Subsección
                            </button>
                            <a href="{{ route('subsections.show', $subsection) }}"
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