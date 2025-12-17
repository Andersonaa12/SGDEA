<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm0-6c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm0-6c0 1.125.75 2.25 2.25 2.25s2.25-1.125 2.25-2.25-.75-2.25-2.25-2.25-2.25 1.125-2.25 2.25Zm5.25 12.75h1.5A2.25 2.25 0 0 0 18 15.75v-.833m2 1V6a2.25 2.25 0 0 0-2.25-2.25H15M18 18.75a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v10.5A2.25 2.25 0 0 0 6 18.75h1.5m-6 4.5h16.5" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Documento: {{ $document->original_name ?? 'Documento sin nombre' }}</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('expedientes.show', $document->expediente) }}" class="hover:text-indigo-600">Expediente {{ $document->expediente->number }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Documento</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden p-8">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white rounded-t-xl mb-8">
                    <h1 class="text-4xl font-bold mb-4">{{ $document->original_name ?? 'Documento sin nombre' }}</h1>
                    <p class="text-xl opacity-95">Tipo: {{ $document->documentType?->name ?? '—' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Detalles del Documento</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Fecha del Documento</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->document_date ? $document->document_date : '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Folio</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->folio ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Ubicación Física</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->physical_location ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Análogo</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->analog ? 'Sí' : 'No' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">OCR Aplicado</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->ocr_applied ? 'Sí' : 'No' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Texto OCR</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->ocr_text ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Firmado</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->signed ? 'Sí' : 'No' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Proveedor de Firma</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->signature_provider ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Tamaño</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->size ? number_format($document->size / 1024, 2) . ' KB' : '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Tipo MIME</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->mime_type ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Archivo</h3>
                        @if($document->file_path)
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">Descargar Archivo</a>
                            @if(in_array($document->mime_type, ['image/jpeg', 'image/png', 'image/gif']))
                                <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->original_name }}" class="mt-4 max-w-full h-auto rounded-lg shadow-md">
                            @elseif($document->mime_type === 'application/pdf')
                                <iframe src="{{ Storage::url($document->file_path) }}" class="mt-4 w-full h-96 rounded-lg shadow-md"></iframe>
                            @endif
                        @else
                            <p class="text-gray-500 italic">No hay archivo adjunto.</p>
                        @endif

                        <h3 class="text-2xl font-bold text-gray-800 mt-8 mb-4">Metadatos</h3>
                        @if(!empty($document->metadata))
                            <dl class="space-y-4">
                                @foreach($document->metadata as $key => $value)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">{{ $key }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $value ?: '—' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        @else
                            <p class="text-gray-500 italic">No hay metadatos definidos.</p>
                        @endif
                    </div>
                </div>

                <div class="flex gap-4 pt-8 border-t mt-8">
                    <a href="{{ route('documents.edit', $document) }}" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                        Editar Documento
                    </a>
                    <a href="{{ route('expedientes.show', $document->expediente) }}" class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition">
                        Volver al Expediente
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>