<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round"  d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-3xl text-gray-800">{{ $document->original_name ?? 'Documento sin nombre' }}</h2>
                <nav class="flex text-sm text-gray-600 mt-2">
                    <a href="{{ route('expedientes.show', $document->expediente) }}" class="hover:text-indigo-600 font-medium">Expediente {{ $document->expediente->number }}</a>
                    <span class="mx-3">/</span>
                    <span class="text-indigo-600 font-semibold">Detalle del Documento</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
                <!-- Cabecera con gradiente -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-10 text-white">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-3">{{ $document->original_name ?? 'Documento sin nombre' }}</h1>
                    
                    <p class="text-lg mt-2 opacity-80">Subido el {{ $document->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="p-8 lg:p-12">
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
                        <!-- Columna izquierda: Detalles básicos -->
                        <div class="xl:col-span-1">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-indigo-600 pb-2">Detalles del Documento</h3>
                            <dl class="space-y-5">
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Fecha del Documento</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->document_date ? \Carbon\Carbon::parse($document->document_date)->format('d/m/Y') : '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Folio</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->folio ?? '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Ubicación Física</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->physical_location ?? '—' }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Análogo</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900 flex items-center gap-2">
                                        @if($document->analog)
                                            <!-- Check verde -->
                                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <!-- Cruz roja -->
                                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">OCR Aplicado</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900 flex items-center gap-2">
                                        @if($document->ocr_applied)
                                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Firmado</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900 flex items-center gap-2">
                                        @if($document->signed)
                                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Proveedor de Firma</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->signature_provider ?? '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Tamaño</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->size ? number_format($document->size / 1024, 2) . ' KB' : '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Tipo MIME</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->mime_type ?? '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Tipo</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->documentType?->name ?? '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Creado Por</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $document->uploader?->name ?? '—' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Columna central: Visualización del documento (más grande) -->
                        <div class="xl:col-span-2 order-first xl:order-none">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-indigo-600 pb-2">Vista Previa del Documento</h3>

                            @if($document->file_path)
                                <div class="flex justify-center mb-6">
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Descargar Archivo
                                    </a>
                                </div>

                                <div class="bg-gray-100 rounded-xl shadow-inner p-4">
                                    @if(in_array($document->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']))
                                        <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->original_name }}" class="mx-auto max-w-full h-auto rounded-lg shadow-lg">
                                    @elseif($document->mime_type === 'application/pdf')
                                        <iframe src="{{ Storage::url($document->file_path) }}#toolbar=1&navpanes=0&scrollbar=1" 
                                                class="w-full h-screen min-h-96 lg:min-h-screen rounded-lg shadow-lg border-0"
                                                frameborder="0"></iframe>
                                    @else
                                        <div class="text-center py-20">
                                            <p class="text-xl text-gray-600">Vista previa no disponible para este tipo de archivo.</p>
                                            <p class="text-sm text-gray-500 mt-2">Puedes descargarlo para visualizarlo.</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-center text-gray-500 italic text-lg">No hay archivo adjunto.</p>
                            @endif

                            <!-- Texto OCR (si existe) -->
                            
                        </div>
                        
                    </div>
                    @if($document->ocr_applied && $document->ocr_text)
                        <div class="mt-10">
                            <h4 class="text-xl font-bold text-gray-800 mb-4">Texto Extraído (OCR)</h4>
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 max-h-96 overflow-y-auto">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $document->ocr_text }}</p>
                            </div>
                        </div>
                    @endif
                    <!-- Sección de Metadatos en tabla -->
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-indigo-600 pb-2">Metadatos</h3>

                        @if(!empty($document->metadata) && is_array($document->metadata))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-300 bg-white shadow-md rounded-lg">
                                    <thead class="bg-indigo-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-sm font-bold text-indigo-800 uppercase tracking-wider">Clave</th>
                                            <th class="px-6 py-4 text-left text-sm font-bold text-indigo-800 uppercase tracking-wider">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($document->metadata as $key => $value)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-700 break-words">{{ $value ?: '—' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 italic text-lg">No hay metadatos definidos.</p>
                        @endif
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-wrap gap-4 pt-10 border-t-2 mt-12">
                        <a href="{{ route('documents.edit', $document) }}" 
                           class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-lg rounded-lg shadow-lg transition transform hover:scale-105">
                            Editar Documento
                        </a>
                        <a href="{{ route('expedientes.show', $document->expediente) }}" 
                           class="px-8 py-4 bg-gray-600 hover:bg-gray-700 text-white font-bold text-lg rounded-lg shadow transition">
                            Volver al Expediente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>