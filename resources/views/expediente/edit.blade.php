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

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-4">
        
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('expedientes.update', $expediente) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nombre del Expediente <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $expediente->name) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Asunto <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="subject" id="subject" value="{{ old('subject', $expediente->subject) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="detail" class="block text-sm font-semibold text-gray-700 mb-2">Detalle</label>
                                    <textarea name="detail" id="detail" rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('detail', $expediente->detail) }}</textarea>
                                    @error('detail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="structure_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Estructura Organizacional <span class="text-red-500">*</span>
                                    </label>
                                    <select name="structure_id" id="structure_id" required
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Seleccionar estructura</option>
                                        @foreach($structures as $structure)
                                            <option value="{{ $structure->id }}" {{ old('structure_id', $expediente->structure_id) == $structure->id ? 'selected' : '' }}>
                                                {{ $structure->version }} - {{ $structure->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('structure_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="section_id" class="block text-sm font-semibold text-gray-700 mb-2">Sección <span class="text-red-500">*</span></label>
                                    <select name="section_id" id="section_id"
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Ninguna</option>
                                    </select>
                                    @error('section_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="subsection_id" class="block text-sm font-semibold text-gray-700 mb-2">Subsección <span class="text-red-500">*</span></label>
                                    <select name="subsection_id" id="subsection_id"
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Ninguna</option>
                                    </select>
                                    @error('subsection_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="serie_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Serie Documental (TRD) <span class="text-red-500">*</span>
                                    </label>
                                    <select name="serie_id" id="serie_id" required
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Seleccionar serie</option>
                                        @foreach($series as $serie)
                                            <option value="{{ $serie->id }}" {{ old('serie_id', $expediente->serie_id) == $serie->id ? 'selected' : '' }}>
                                                {{ $serie->code }} - {{ $serie->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('serie_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="subserie_id" class="block text-sm font-semibold text-gray-700 mb-2">Subserie</label>
                                    <select name="subserie_id" id="subserie_id"
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Ninguna</option>
                                    </select>
                                    @error('subserie_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="opening_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Fecha de Apertura <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="opening_date" id="opening_date" value="{{ old('opening_date', $expediente->opening_date) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    @error('opening_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="closing_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Cierre</label>
                                    <input type="date" name="closing_date" id="closing_date" value="{{ old('closing_date', $expediente->closing_date) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    @error('closing_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="support_type_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tipo de Soporte <span class="text-red-500">*</span>
                                    </label>
                                    <select name="support_type_id" id="support_type_id" required
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Seleccionar tipo</option>
                                        @foreach($supportTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('support_type_id', $expediente->support_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }} ({{ $type->short_description }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('support_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="phase_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Fase del Ciclo Vital <span class="text-red-500">*</span>
                                    </label>
                                    <select name="phase_id" id="phase_id" required
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Seleccionar fase</option>
                                        @foreach($phases as $phase)
                                            <option value="{{ $phase->id }}" {{ old('phase_id', $expediente->phase_id) == $phase->id ? 'selected' : '' }}>
                                                {{ ucfirst($phase->name) }} ({{ $phase->preservation_years }} años)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('phase_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Estado <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="status" required
                                            class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="open" {{ old('status', $expediente->status) == 'open' ? 'selected' : '' }}>Abierto</option>
                                        <option value="closed" {{ old('status', $expediente->status) == 'closed' ? 'selected' : '' }}>Cerrado</option>
                                        <option value="archived" {{ old('status', $expediente->status) == 'archived' ? 'selected' : '' }}>Archivado</option>
                                    </select>
                                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div id="physical-location-section" class="hidden space-y-6 mt-8 p-6 bg-amber-50 border-2 border-amber-300 rounded-xl">
                            <h3 class="text-lg font-bold text-amber-900 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                Ubicación Física del Expediente (Obligatorio para soportes físicos)
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="box" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Caja <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="box" id="box" value="{{ old('box', $expediente->currentLocation?->box) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    @error('box') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="folder" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Carpeta <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="folder" id="folder" value="{{ old('folder', $expediente->currentLocation?->folder) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                                    @error('folder') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tipo <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type" id="type" class="select2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" required>
                                        <option value="" disabled {{ old('type', $expediente->currentLocation?->type) ? '' : 'selected' }}>-- Seleccione tipo --</option>
                                        <option value="Legajo" {{ old('type', $expediente->currentLocation?->type) === 'Legajo' ? 'selected' : '' }}>Legajo</option>
                                        <option value="Tomo"   {{ old('type', $expediente->currentLocation?->type) === 'Tomo' ? 'selected' : '' }}>Tomo</option>
                                        <option value="Libro"  {{ old('type', $expediente->currentLocation?->type) === 'Libro' ? 'selected' : '' }}>Libro</option>
                                        <option value="Otros"  {{ old('type', $expediente->currentLocation?->type) === 'Otros' ? 'selected' : '' }}>Otros</option>
                                    </select>
                                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="volume_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Número de legajo
                                    </label>
                                    <input type="text" name="volume_number" id="volume_number" value="{{ old('volume_number', $expediente->currentLocation?->volume_number) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                                    @error('volume_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="folios_count" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Numero de Folios
                                    </label>
                                    <input type="number" name="folios_count" id="folios_count" value="{{ old('folios_count', $expediente->currentLocation?->folios_count) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                                    @error('folios_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="additional_details" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Detalles Adicionales
                                    </label>
                                    <textarea name="additional_details" id="additional_details" rows="2"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">{{ old('additional_details', $expediente->currentLocation?->additional_details) }}</textarea>
                                    @error('additional_details') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-8 mt-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">
                                <i class="fas fa-tags mr-2"></i> Metadatos Adicionales
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($metadataTypes as $type)
                                    @php
                                        $value = $currentMetadata[$type->id] ?? old("metadata.{$type->id}");
                                    @endphp

                                    <div>
                                        <label for="metadata_{{ $type->id }}" class="block text-sm font-semibold text-gray-700 mb-2">
                                            {{ $type->name }}
                                            @if($type->required)<span class="text-red-500">*</span>@endif
                                        </label>

                                        @if($type->input_type === 'select')
                                            <select name="metadata[{{ $type->id }}]" id="metadata_{{ $type->id }}"
                                                    class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    @if($type->required) required @endif>
                                                <option value="">-- Seleccionar --</option>
                                                @foreach($type->options as $option)
                                                    <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>
                                                        {{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif($type->input_type === 'number')
                                            <input type="number" name="metadata[{{ $type->id }}]" id="metadata_{{ $type->id }}"
                                                value="{{ $value }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                @if($type->required) required @endif>
                                        @else
                                            <input type="text" name="metadata[{{ $type->id }}]" id="metadata_{{ $type->id }}"
                                                value="{{ $value }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                @if($type->required) required @endif>
                                        @endif

                                        @error("metadata.{$type->id}")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endforeach
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2();

        // Toggle physical location
        function togglePhysicalLocation() {
            var selectedText = $('#support_type_id option:selected').text().toLowerCase();
            var selectedValue = $('#support_type_id').val();
            var isPhysical = selectedText.includes('físico') || selectedText.includes('híbrido') || selectedText.includes('physical') || selectedText.includes('hybrid');

            if (selectedValue && isPhysical) {
                $('#physical-location-section').removeClass('hidden');
                $('#box').prop('required', true);
                $('#folder').prop('required', true);
                $('#type').prop('required', true);
            } else {
                $('#physical-location-section').addClass('hidden');
                $('#box').prop('required', false);
                $('#folder').prop('required', false);
                $('#type').prop('required', false);
            }
        }

        $('#support_type_id').on('change', togglePhysicalLocation);
        togglePhysicalLocation(); // Initial check

        // Date handling
        var openingDateInput = $('#opening_date');
        var closingDateInput = $('#closing_date');

        function updateClosingDateMin() {
            if (openingDateInput.val()) {
                closingDateInput.attr('min', openingDateInput.val());
            } else {
                closingDateInput.attr('min', '');
            }
        }

        function setOpeningDateMax() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            openingDateInput.attr('max', `${year}-${month}-${day}`);
        }

        openingDateInput.on('change', updateClosingDateMin);
        updateClosingDateMin();
        setOpeningDateMax();
    });
</script>

<script>
    $(document).ready(function() {
        var oldStructure = '{{ old('structure_id', $expediente->structure_id) }}';
        var oldSection = '{{ old('section_id', $expediente->section_id) }}';
        var oldSubsection = '{{ old('subsection_id', $expediente->subsection_id) }}';
        var oldSerie = '{{ old('serie_id', $expediente->serie_id) }}';
        var oldSubserie = '{{ old('subserie_id', $expediente->subserie_id) }}';

        $('#structure_id').on('change', function() {
            var structureId = $(this).val();
            if (structureId) {
                $.ajax({
                    url: '/api/sections?structure_id=' + structureId,
                    type: 'GET',
                    success: function(data) {
                        $('#section_id').empty().append('<option value="">Ninguna</option>');
                        $.each(data, function(key, section) {
                            $('#section_id').append('<option value="' + section.id + '">' + section.code + ' - ' + section.name + '</option>');
                        });
                        if (oldSection) {
                            $('#section_id').val(oldSection).trigger('change');
                            oldSection = null; // Reset after setting
                        } else {
                            $('#section_id').trigger('change');
                        }
                    }
                });
            } else {
                $('#section_id').empty().append('<option value="">Ninguna</option>').trigger('change');
                $('#subsection_id').empty().append('<option value="">Ninguna</option>').trigger('change');
            }
        });

        $('#section_id').on('change', function() {
            var sectionId = $(this).val();
            if (sectionId) {
                $.ajax({
                    url: '/api/subsections?section_id=' + sectionId,
                    type: 'GET',
                    success: function(data) {
                        $('#subsection_id').empty().append('<option value="">Ninguna</option>');
                        $.each(data, function(key, subsection) {
                            $('#subsection_id').append('<option value="' + subsection.id + '">' + subsection.code + ' - ' + subsection.name + '</option>');
                        });
                        if (oldSubsection) {
                            $('#subsection_id').val(oldSubsection).trigger('change');
                            oldSubsection = null; // Reset after setting
                        }
                    }
                });
            } else {
                $('#subsection_id').empty().append('<option value="">Ninguna</option>').trigger('change');
            }
        });

        $('#serie_id').on('change', function() {
            var serieId = $(this).val();
            if (serieId) {
                $.ajax({
                    url: '/api/subseries?serie_id=' + serieId,
                    type: 'GET',
                    success: function(data) {
                        $('#subserie_id').empty().append('<option value="">Ninguna</option>');
                        $.each(data, function(key, subserie) {
                            $('#subserie_id').append('<option value="' + subserie.id + '">' + subserie.code + ' - ' + subserie.name + '</option>');
                        });
                        if (oldSubserie) {
                            $('#subserie_id').val(oldSubserie).trigger('change');
                            oldSubserie = null; // Reset after setting
                        }
                    }
                });
            } else {
                $('#subserie_id').empty().append('<option value="">Ninguna</option>').trigger('change');
            }
        });

        // Trigger initial loads if old values exist
        if (oldStructure) {
            $('#structure_id').val(oldStructure).trigger('change');
        }
        if (oldSerie) {
            $('#serie_id').val(oldSerie).trigger('change');
        }
    });
</script>