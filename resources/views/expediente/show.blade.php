<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Expediente: {{ $expediente->number }}</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('expedientes.index') }}" class="hover:text-indigo-600">Expedientes</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">{{ $expediente->number }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-start">
                        <div class="bg-white p-2 rounded-lg flex gap-1 text-sm" style="width: fit-content;">
                            <button
                                onclick="showTab('informacion')"
                                class="tab-button px-4 py-2 text-xs font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center gap-2 text-black bg-gray-100"
                                id="informacion-button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                </svg>
                                Información
                            </button>
                            <button
                                onclick="showTab('hojas-control')"
                                class="tab-button px-4 py-2 text-xs font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center gap-2 text-gray-600 hover:text-gray-900"
                                id="hojas-control-button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm0-6c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm0-6c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm5.25 12.75h1.5A2.25 2.25 0 0 0 18 15.75v-.833m2 1V6a2.25 2.25 0 0 0-2.25-2.25H15M18 18.75a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v10.5A2.25 2.25 0 0 0 6 18.75h1.5m-6 4.5h16.5" />
                                </svg>
                                Hojas de Control ({{ $expediente->documents->count() }})
                            </button>
                            <button
                                onclick="showTab('cargar-documentos')"
                                class="tab-button px-4 py-2 text-xs font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center gap-2 text-gray-600 hover:text-gray-900"
                                id="cargar-documentos-button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                                </svg>
                                Cargar Documentos
                            </button>
                        </div>
                    </div>
                </div>

                <div id="informacion" class="p-6 tab-content">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white rounded-t-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h1 class="text-5xl font-bold">{{ $expediente->number }}</h1>
                                <p class="text-2xl mt-2 opacity-95">{{ $expediente->subject }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-bold
                                    @if($expediente->status === 'open') bg-green-100 text-green-800
                                    @elseif($expediente->status === 'closed') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($expediente->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                            <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                                <p class="text-indigo-200 text-sm">Fase</p>
                                <p class="text-2xl font-bold">{{ ucfirst($expediente->phase?->name ?? '—') }}</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                                <p class="text-indigo-200 text-sm">Soporte</p>
                                <p class="text-2xl font-bold">{{ $expediente->supportType?->short_description ?? '—' }}</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                                <p class="text-indigo-200 text-sm">Documentos</p>
                                <p class="text-4xl font-bold">{{ $expediente->documents->count() }}</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur p-5 rounded-xl">
                                <p class="text-indigo-200 text-sm">Versión</p>
                                <p class="text-4xl font-bold">{{ $expediente->version ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional sections from original -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-200 shadow-sm">
                            <p class="text-sm font-medium text-blue-700">Sección / Subsección</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->section?->name ?? '—' }} @if($expediente->subsection) / {{ $expediente->subsection->name }} @endif
                            </p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-xl border border-green-200 shadow-sm">
                            <p class="text-sm font-medium text-green-700">Estructura Organizacional</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->structure?->version ?? '—' }}
                            </p>
                        </div>
                    </div>

                    @if($expediente->supportType?->is_physical)
                        @if($expediente->currentLocation)
                            <div class="bg-amber-50 p-6 rounded-xl border border-amber-300 shadow-sm">
                                <h4 class="font-bold text-amber-900 mb-3">Ubicación Física Actual</h4>
                                <p class="text-gray-800">
                                    {{ $expediente->currentLocation->full_location }}
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Asignada el {{ $expediente->currentLocation->created_at }}
                                    @if($expediente->currentLocation->creator)
                                        por {{ $expediente->currentLocation->creator->name }}
                                    @endif
                                </p>
                            </div>
                        @else
                            <p class="text-gray-500 italic">Sin ubicación física asignada</p>
                        @endif
                    @endif
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <h4 class="font-semibold text-gray-800 mb-4">Metadatos Adicionales</h4>
                        @if($expediente->metadataAll)
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($expediente->metadataAll as $meta)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">{{ $meta->metadataType->name }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $meta->value ?: '—' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        @else
                            <p class="text-gray-500 italic">No hay metadatos definidos</p>
                        @endif
                    </div>

                    <div class="flex gap-4 pt-8 border-t">
                        <a href="{{ route('expedientes.edit', $expediente) }}"
                           class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Expediente
                        </a>
                        <a href="{{ route('expedientes.index') }}"
                           class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                            Volver al Listado
                        </a>
                    </div>
                </div>

               <div id="hojas-control" class="p-6 tab-content hidden">
                    <h3 class="text-2xl font-bold text-gray-800">
                        Hojas de Control (Documentos Cargados)
                    </h3>

                    @if($expediente->documents->isEmpty())
                        <p class="text-gray-500 italic">No hay documentos cargados aún.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="in-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-blue-50 to-cyan-50">
                                    <tr>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">ID</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Tipo</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Nombre Original</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Folio</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Fecha Documento</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Tamaño</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Firmado</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">OCR</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Ubicación Física</th>
                                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($expediente->documents as $document)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 border-b text-sm text-gray-900">
                                                {{ $document->id }}
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm text-gray-900">
                                                {{ $document->documentType?->name ?? '—' }}
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm text-gray-900">
                                                {{ $document->original_name ?? '—' }}
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm text-gray-900">
                                                {{ $document->folio ?? '—' }}
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm text-gray-900">
                                                {{ $document->document_date ?? '—' }}
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm text-gray-900">
                                                {{ $document->size ? number_format($document->size / 1024, 2) . ' KB' : '—' }}
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm">
                                                @if($document->signed)
                                                    <span class="text-green-600 font-semibold">Sí</span>
                                                @else
                                                    <span class="text-gray-500">No</span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm">
                                                @if($document->ocr_applied)
                                                    <span class="text-indigo-600 font-semibold">Aplicado</span>
                                                @else
                                                    <span class="text-gray-500">No</span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm text-gray-900">
                                                {{ $document->physical_location ?? '—' }}
                                            </td>

                                            <td class="px-6 py-4 border-b text-sm whitespace-nowrap">
                                                <a href="{{ route('documents.show', $document) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                    Ver
                                                </a>

                                                <a href="{{ route('documents.edit', $document) }}"
                                                class="text-green-600 hover:text-green-900 ml-4">
                                                    Editar
                                                </a>

                                                <form action="{{ route('documents.destroy', $document) }}"
                                                    method="POST"
                                                    class="inline ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900"
                                                            onclick="return confirm('¿Seguro que desea eliminar este documento?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>


                <div id="cargar-documentos" class="p-6 tab-content hidden">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Cargar Nuevo Documento</h3>
                    <form action="{{ route('expedientes.documents.store', $expediente) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="document_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                                <select id="document_type_id" name="document_type_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach($documentTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('document_type_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="document_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha del Documento</label>
                                <input type="date" id="document_date" name="document_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('document_date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="folio" class="block text-sm font-medium text-gray-700 mb-1">Folio</label>
                                <input type="text" id="folio" name="folio" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('folio') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="physical_location" class="block text-sm font-medium text-gray-700 mb-1">Ubicación Física</label>
                                <input type="text" id="physical_location" name="physical_location" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('physical_location') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Archivo</label>
                            <input type="file" id="file" name="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('file') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="flex items-center">
                                <input id="analog" name="analog" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="analog" class="ml-2 block text-sm text-gray-700">Análogo</label>
                                @error('analog') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex items-center">
                                <input id="ocr_applied" name="ocr_applied" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="ocr_applied" class="ml-2 block text-sm text-gray-700">OCR Aplicado</label>
                                @error('ocr_applied') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex items-center">
                                <input id="signed" name="signed" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="signed" class="ml-2 block text-sm text-gray-700">Firmado</label>
                                @error('signed') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="ocr_text" class="block text-sm font-medium text-gray-700 mb-1">Texto OCR</label>
                            <textarea id="ocr_text" name="ocr_text" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            @error('ocr_text') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="signature_provider" class="block text-sm font-medium text-gray-700 mb-1">Proveedor de Firma</label>
                            <input type="text" id="signature_provider" name="signature_provider" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('signature_provider') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metadatos (Clave-Valor)</label>
                            <div id="metadata-container" class="space-y-4">
                                <!-- Initial metadata field -->
                                <div class="flex gap-4 metadata-pair">
                                    <input type="text" name="metadata_keys[]" placeholder="Clave" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <input type="text" name="metadata_values[]" placeholder="Valor" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="button" onclick="removeMetadata(this)" class="text-red-600 hover:text-red-900">-</button>
                                </div>
                            </div>
                            <button type="button" onclick="addMetadata()" class="mt-2 text-indigo-600 hover:text-indigo-900 text-sm">Agregar Metadato</button>
                            @error('metadata') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">Cargar Documento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }

            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('text-black', 'bg-gray-100');
                button.classList.add('text-gray-600', 'hover:text-gray-900');
            });

            const activeButton = document.getElementById(tabId + '-button');
            if (activeButton) {
                activeButton.classList.add('text-black', 'bg-gray-100');
                activeButton.classList.remove('text-gray-600', 'hover:text-gray-900');
            }
        }

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