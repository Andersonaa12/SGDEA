<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <div class="flex-shrink-0">
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-10 h-10 text-indigo-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-col">
                <h2 class="text-3xl font-extrabold text-gray-900">Expediente: {{ $expediente->number }}</h2>
                <nav class="flex text-sm text-gray-500 mt-1">
                    <a href="{{ route('expedientes.index') }}" class="hover:text-indigo-600">Expedientes</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-semibold">{{ $expediente->number }}</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <div class="px-8 pt-6">
                        <nav class="flex space-x-8" aria-label="Tabs">
                            <button onclick="showTab('informacion')" id="informacion-button"
                                    class="tab-button py-3 px-1 border-b-2 font-medium text-sm flex items-center gap-2 border-indigo-600 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                </svg>
                                Información
                            </button>
                            <button onclick="showTab('hojas-control')" id="hojas-control-button"
                                    class="tab-button py-3 px-1 border-b-2 font-medium text-sm flex items-center gap-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                Hojas de Control ({{ $expediente->documents->count() }})
                            </button>
                            <button onclick="showTab('cargar-documentos')" id="cargar-documentos-button"
                                    class="tab-button py-3 px-1 border-b-2 font-medium text-sm flex items-center gap-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                                </svg>
                                Cargar Documentos
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab: Información -->
                <div id="informacion" class="tab-content p-8">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white rounded-2xl mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h1 class="text-5xl font-extrabold">{{ $expediente->number }}</h1>
                                <p class="text-2xl mt-2 opacity-95">{{ $expediente->subject }}</p>
                            </div>
                            <div>
                                <span class="inline-block px-6 py-3 rounded-full text-lg font-bold
                                    {{ $expediente->status === 'open' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $expediente->status == 'open' ? 'Abierto' : 'Cerrado' }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                            <div class="bg-white/20 backdrop-blur-lg p-6 rounded-xl">
                                <p class="text-indigo-100 text-sm">Fase</p>
                                <p class="text-2xl font-bold">{{ ucfirst($expediente->phase?->name ?? '—') }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-lg p-6 rounded-xl">
                                <p class="text-indigo-100 text-sm">Soporte</p>
                                <p class="text-2xl font-bold">{{ $expediente->supportType?->short_description ?? '—' }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-lg p-6 rounded-xl">
                                <p class="text-indigo-100 text-sm">Documentos</p>
                                <p class="text-4xl font-bold">{{ $expediente->documents->count() }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-lg p-6 rounded-xl">
                                <p class="text-indigo-100 text-sm">Versión</p>
                                <p class="text-4xl font-bold">{{ $expediente->version ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Resto de información (se mantiene igual pero con mejor estilo) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-2xl border border-blue-200 shadow-sm">
                            <p class="text-sm font-medium text-blue-700">Sección / Subsección</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->section?->name ?? '—' }} @if($expediente->subsection) / {{ $expediente->subsection->name }} @endif
                            </p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-2xl border border-green-200 shadow-sm">
                            <p class="text-sm font-medium text-green-700">Estructura Organizacional</p>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                {{ $expediente->structure?->version ?? '—' }}
                            </p>
                        </div>
                        @if($expediente->supportType?->is_physical && $expediente->currentLocation)
                            <div class="bg-amber-50 p-6 rounded-2xl border border-amber-300 shadow-sm">
                                <p class="text-sm font-medium text-amber-700">Ubicación Física</p>
                                <p class="text-xl font-bold text-gray-800 mt-2">
                                    {{ $expediente->currentLocation->full_location }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm mb-8">
                        <h4 class="font-bold text-gray-800 mb-4">Metadatos Adicionales</h4>
                        @if($expediente->metadataAll?->count())
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($expediente->metadataAll as $meta)
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <dt class="text-sm font-medium text-gray-600">{{ $meta->metadataType->name }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $meta->value ?: '—' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        @else
                            <p class="text-gray-500 italic">No hay metadatos definidos</p>
                        @endif
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('expedientes.edit', $expediente) }}"
                           class="inline-flex items-center gap-3 px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                            Editar Expediente
                        </a>
                        <a href="{{ route('expedientes.index') }}"
                           class="inline-flex items-center gap-3 px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-xl shadow-md transition-all hover:shadow-lg">
                            Volver al Listado
                        </a>
                    </div>
                </div>

                <!-- Tab: Hojas de Control -->
                <div id="hojas-control" class="tab-content p-8 hidden">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Hojas de Control (Documentos Cargados)</h3>

                    @if($expediente->documents->isEmpty())
                        <div class="text-center py-16 bg-gray-50 rounded-2xl">
                            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-xl text-gray-500">No hay documentos cargados aún</p>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-2xl shadow-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tipo</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Folio</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tamaño</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Firmado</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">OCR</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Ubicación</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($expediente->documents as $document)
                                        <tr class="hover:bg-indigo-50 transition-colors">
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $document->id }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $document->documentType?->name ?? '—' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700 truncate max-w-xs">{{ $document->original_name ?? '—' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $document->folio ?? '—' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $document->document_date ?? '—' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $document->size ? number_format($document->size / 1024, 2) . ' KB' : '—' }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $document->signed ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                                    {{ $document->signed ? 'Sí' : 'No' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $document->ocr_applied ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-600' }}">
                                                    {{ $document->ocr_applied ? 'Sí' : 'No' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $document->physical_location ?? '—' }}</td>
                                            <td class="px-6 py-4 text-sm space-x-3">
                                                <a href="{{ route('documents.show', $document) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Ver</a>
                                                <a href="{{ route('documents.edit', $document) }}" class="text-emerald-600 hover:text-emerald-900 font-medium">Editar</a>
                                                <button type="button" class="delete-document-btn text-red-600 hover:text-red-900 font-medium" data-form-id="delete-form-{{ $document->id }}">Eliminar</button>
                                                <form id="delete-form-{{ $document->id }}" action="{{ route('documents.destroy', $document) }}" method="POST" class="hidden">
                                                    @csrf @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Tab: Cargar Documentos -->
                <div id="cargar-documentos" class="tab-content p-8 hidden">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8">Cargar Nuevo Documento</h3>
                    <form action="{{ route('expedientes.documents.store', $expediente) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label for="document_type_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tipo de Documento <span class="text-red-600">*</span>
                                </label>
                                <select id="document_type_id" name="document_type_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($documentTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('document_type_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="document_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha del Documento</label>
                                <input type="date" id="document_date" name="document_date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                                @error('document_date') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label for="folio" class="block text-sm font-semibold text-gray-700 mb-2">Folio</label>
                                <input type="text" id="folio" name="folio" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                                @error('folio') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="physical_location" class="block text-sm font-semibold text-gray-700 mb-2">Ubicación Física</label>
                                <input type="text" id="physical_location" name="physical_location" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                                @error('physical_location') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-8">
                            <label for="file" class="block text-sm font-semibold text-gray-700 mb-2">
                                Archivo <span class="text-red-600">*</span>
                            </label>
                            <input type="file" id="file" name="file" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('file') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="analog" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <span class="text-sm font-medium text-gray-700">Análogo</span>
                            </label>
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="ocr_applied" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <span class="text-sm font-medium text-gray-700">OCR Aplicado</span>
                            </label>
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="signed" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <span class="text-sm font-medium text-gray-700">Firmado</span>
                            </label>
                        </div>

                        <div class="mb-8">
                            <label for="ocr_text" class="block text-sm font-semibold text-gray-700 mb-2">Texto OCR (opcional)</label>
                            <textarea id="ocr_text" name="ocr_text" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow"></textarea>
                        </div>

                        <div class="mb-8">
                            <label for="signature_provider" class="block text-sm font-semibold text-gray-700 mb-2">Proveedor de Firma</label>
                            <input type="text" id="signature_provider" name="signature_provider" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Metadatos Adicionales</label>
                            <div id="metadata-container" class="space-y-4">
                                <div class="flex gap-4 metadata-pair">
                                    <input type="text" name="metadata_keys[]" placeholder="Clave" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500">
                                    <input type="text" name="metadata_values[]" placeholder="Valor" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500">
                                    <button type="button" onclick="removeMetadata(this)" class="px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-bold transition">-</button>
                                </div>
                            </div>
                            <button type="button" onclick="addMetadata()" class="mt-4 text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Agregar metadato
                            </button>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all hover:shadow-xl hover:-translate-y-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                                </svg>
                                Cargar Documento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');

            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('border-indigo-600', 'text-indigo-600');
                btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            const activeBtn = document.getElementById(tabId + '-button');
            activeBtn.classList.add('border-indigo-600', 'text-indigo-600');
            activeBtn.classList.remove('border-transparent', 'text-gray-500');
        }

        function addMetadata() {
            const container = document.getElementById('metadata-container');
            const div = document.createElement('div');
            div.className = 'flex gap-4 metadata-pair';
            div.innerHTML = `
                <input type="text" name="metadata_keys[]" placeholder="Clave" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500">
                <input type="text" name="metadata_values[]" placeholder="Valor" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500">
                <button type="button" onclick="removeMetadata(this)" class="px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-bold transition">-</button>
            `;
            container.appendChild(div);
        }

        function removeMetadata(btn) {
            btn.parentElement.remove();
        }

        // SweetAlert2 para eliminar documento
        document.querySelectorAll('.delete-document-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const formId = this.getAttribute('data-form-id');
                const form = document.getElementById(formId);

                Swal.fire({
                    title: '¿Eliminar este documento?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>