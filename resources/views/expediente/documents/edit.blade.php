<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm0-6c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm0-6c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm5.25 12.75h1.5A2.25 2.25 0 0 0 18 15.75v-.833m2 1V6a2.25 2.25 0 0 0-2.25-2.25H15M18 18.75a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v10.5A2.25 2.25 0 0 0 6 18.75h1.5m-6 4.5h16.5" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Editar Documento: {{ $document->original_name ?? 'Documento sin nombre' }}</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('expedientes.show', $document->expediente) }}" class="hover:text-indigo-600">Expediente {{ $document->expediente->number }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Editar Documento</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden p-8">
                <h3 class="text-2xl font-bold mb-6 text-gray-800">Editar Documento</h3>
                <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="document_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                            <select id="document_type_id" name="document_type_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}" {{ $document->document_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('document_type_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="document_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha del Documento</label>
                            <input type="date" id="document_date" name="document_date" value="{{ $document->document_date }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('document_date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="folio" class="block text-sm font-medium text-gray-700 mb-1">Folio</label>
                            <input type="text" id="folio" name="folio" value="{{ $document->folio }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('folio') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="physical_location" class="block text-sm font-medium text-gray-700 mb-1">Ubicación Física</label>
                            <input type="text" id="physical_location" name="physical_location" value="{{ $document->physical_location }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('physical_location') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Archivo Nuevo (opcional)</label>
                        <input type="file" id="file" name="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @if($document->file_path)
                            <p class="text-sm text-gray-600 mt-2">Archivo actual: <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">{{ $document->original_name }}</a></p>
                        @endif
                        @error('file') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center">
                            <input id="analog" name="analog" type="checkbox" {{ $document->analog ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="analog" class="ml-2 block text-sm text-gray-700">Análogo</label>
                            @error('analog') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center">
                            <input id="ocr_applied" name="ocr_applied" type="checkbox" {{ $document->ocr_applied ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="ocr_applied" class="ml-2 block text-sm text-gray-700">OCR Aplicado</label>
                            @error('ocr_applied') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center">
                            <input id="signed" name="signed" type="checkbox" {{ $document->signed ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="signed" class="ml-2 block text-sm text-gray-700">Firmado</label>
                            @error('signed') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    {{-- <div>
                        <label for="ocr_text" class="block text-sm font-medium text-gray-700 mb-1">Texto OCR</label>
                        <textarea id="ocr_text" name="ocr_text" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $document->ocr_text }}</textarea>
                        @error('ocr_text') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div> --}}
                    <div>
                        <label for="signature_provider" class="block text-sm font-medium text-gray-700 mb-1">Proveedor de Firma</label>
                        <input type="text" id="signature_provider" name="signature_provider" value="{{ $document->signature_provider }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('signature_provider') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metadatos (Clave-Valor)</label>
                        <div id="metadata-container" class="space-y-4">
                            @foreach($document->metadata ?? [] as $key => $value)
                                <div class="flex gap-4 metadata-pair">
                                    <input type="text" name="metadata_keys[]" value="{{ $key }}" placeholder="Clave" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <input type="text" name="metadata_values[]" value="{{ $value }}" placeholder="Valor" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="button" onclick="removeMetadata(this)" class="text-red-600 hover:text-red-900">-</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addMetadata()" class="mt-2 text-indigo-600 hover:text-indigo-900 text-sm">Agregar Metadato</button>
                        @error('metadata') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('documents.show', $document) }}" class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">Cancelar</a>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">Actualizar Documento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addMetadata() {
            const container = document.getElementById('metadata-container');
            const pair = document.createElement('div');
            pair.classList.add('flex', 'gap-4', 'metadata-pair');
            pair.innerHTML = `
                <input type="text" name="metadata_keys[]" placeholder="Clave" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <input type="text" name="metadata_values[]" placeholder="Valor" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <button type="button" onclick="removeMetadata(this)" class="text-red-600 hover:text-red-900">-</button>
            `;
            container.appendChild(pair);
        }

        function removeMetadata(button) {
            button.parentElement.remove();
        }
    </script>
</x-app-layout>