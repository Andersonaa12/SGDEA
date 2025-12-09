<?php

namespace App\Http\Controllers\Expediente;

use App\Http\Controllers\Controller;
use App\Models\Expediente\Expediente;
use App\Models\Expediente\ExpedienteHistory;
use App\Models\Expediente\ExpedienteLoan;
use App\Models\Expediente\Document;
use App\Models\Expediente\Phase;
use App\Models\Expediente\ExpedienteLocation;
use App\Models\Expediente\SupportType;
use App\Models\Structure\OrganizationalStructure;
use App\Models\Structure\Section;
use App\Models\Structure\Subsection;
use App\Models\Trd\Serie;
use App\Models\Trd\Subserie;
use App\Models\Trd\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class ExpedienteController extends Controller
{
    /**
     * Display a listing of the expedientes.
     */
    public function index(Request $request)
    {
        try {
            $query = Expediente::with(['structure', 'section', 'subsection', 'serie', 'subserie', 'creator', 'currentLocation']);

            // Filtros básicos
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('number', 'like', "%$search%")
                      ->orWhere('subject', 'like', "%$search%")
                      ->orWhere('detail', 'like', "%$search%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('phase_id')) {
                $query->where('phase_id', $request->phase_id);
            }

            $expedientes = $query->paginate(15);

            return view('expediente.index', compact('expedientes'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar la lista de expedientes: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new expediente.
     */
    public function create()
    {
        try {
            $structures = OrganizationalStructure::where('active', true)->get();
            $sections = Section::all();
            $subsections = Subsection::all();
            $series = Serie::all();
            $subseries = Subserie::all();
            $phases = Phase::active()->ordered()->get();
            $supportTypes = SupportType::active()->get();

            return view('expediente.create', compact('structures', 'sections', 'subsections', 'series', 'subseries', 'phases', 'supportTypes'));
        } catch (Exception $e) {
            return redirect()->route('expedientes.index')->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created expediente in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|unique:expedientes,number',
            'subject' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'parent_id' => 'nullable|exists:expedientes,id',
            'structure_id' => 'required|exists:organizational_structures,id',
            'section_id' => 'nullable|exists:sections,id',
            'subsection_id' => 'nullable|exists:subsections,id',
            'serie_id' => 'required|exists:series,id',
            'subserie_id' => 'nullable|exists:subseries,id',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'version' => 'nullable|integer',
            'status' => 'required|in:open,closed,archived',
            'metadata' => 'nullable|json',
            'support_type_id' => 'required|exists:support_types,id',
            'phase_id' => 'required|exists:phases,id',
            // Campos de ubicación física (condicionales en el código)
            'box' => 'nullable|string|max:50',
            'folder' => 'nullable|string|max:50',
            'type' => 'nullable|in:Tomo,Legajo,Libro,Otros',
            'volume_number' => 'nullable|string|max:20',
            'folios_count' => 'nullable|integer',
            'additional_details' => 'nullable|string',
        ], [
            'number.required' => 'El número es obligatorio.',
            'number.unique' => 'El número ya existe.',
            'subject.required' => 'El asunto es obligatorio.',
            'structure_id.required' => 'La estructura organizacional es obligatoria.',
            'serie_id.required' => 'La serie es obligatoria.',
            'opening_date.required' => 'La fecha de apertura es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'support_type_id.required' => 'El tipo de soporte es obligatorio.',
            'phase_id.required' => 'La fase es obligatoria.',
            'box.required' => 'La caja es obligatoria para expedientes físicos.',
            'folder.required' => 'La carpeta es obligatoria para expedientes físicos.',
            'type.required' => 'El tipo es obligatorio para expedientes físicos.',
        ]);

        // Validación condicional para ubicación física
        $supportType = SupportType::find($request->support_type_id);
        if ($supportType && $supportType->is_physical) {
            $validator->after(function ($validator) {
                if (!$validator->getData()['box'] || !$validator->getData()['folder'] || !$validator->getData()['type']) {
                    $validator->errors()->add('box', 'La caja es obligatoria para expedientes físicos.');
                    $validator->errors()->add('folder', 'La carpeta es obligatoria para expedientes físicos.');
                    $validator->errors()->add('type', 'El tipo es obligatorio para expedientes físicos.');
                }
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $expediente = new Expediente();
            $expediente->number = $request->number;
            $expediente->subject = $request->subject;
            $expediente->detail = $request->detail;
            $expediente->parent_id = $request->parent_id;
            $expediente->structure_id = $request->structure_id;
            $expediente->section_id = $request->section_id;
            $expediente->subsection_id = $request->subsection_id;
            $expediente->serie_id = $request->serie_id;
            $expediente->subserie_id = $request->subserie_id;
            $expediente->opening_date = $request->opening_date;
            $expediente->closing_date = $request->closing_date;
            $expediente->version = 1; // Versión inicial
            $expediente->status = $request->status;
            $expediente->metadata = $request->metadata;
            $expediente->support_type_id = $request->support_type_id;
            $expediente->phase_id = $request->phase_id;
            $expediente->created_by = Auth::id();
            $expediente->updated_by = Auth::id();
            $expediente->save();

            // Guardar ubicación física si es físico o híbrido
            if ($request->filled('box') && $request->filled('folder') && $request->filled('type')) {
                ExpedienteLocation::create([
                    'expediente_id' => $expediente->id,
                    'box' => $request->box,
                    'folder' => $request->folder,
                    'type' => $request->type,
                    'volume_number' => $request->volume_number,
                    'folios_count' => $request->folios_count,
                    'additional_details' => $request->additional_details,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                // Registrar en historial
                /* $this->logHistory($expediente, 'location_assigned', [
                    'box' => $request->box,
                    'folder' => $request->folder,
                    'type' => $request->type,
                ]); */
            }

            // Registrar creación en historial
            $this->logHistory($expediente, 'created', []);

            return redirect()->route('expedientes.index')->with('success', 'Expediente creado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el expediente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified expediente.
     */
    public function show($id)
    {
        try {
            $expediente = Expediente::with(['parent', 'children', 'structure', 'section', 'subsection', 'serie', 'subserie', 'documents', 'histories', 'loans', 'creator', 'updater', 'phase', 'supportType', 'currentLocation'])->findOrFail($id);

            return view('expediente.show', compact('expediente'));
        } catch (Exception $e) {
            return redirect()->route('expedientes.index')->with('error', 'Error al mostrar el expediente: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified expediente.
     */
    public function edit($id)
    {
        try {
            $expediente = Expediente::with('currentLocation')->findOrFail($id);
            $structures = OrganizationalStructure::where('active', true)->get();
            $sections = Section::all();
            $subsections = Subsection::all();
            $series = Serie::all();
            $subseries = Subserie::all();
            $phases = Phase::active()->ordered()->get();
            $supportTypes = SupportType::active()->get();

            return view('expediente.edit', compact('expediente', 'structures', 'sections', 'subsections', 'series', 'subseries', 'phases', 'supportTypes'));
        } catch (Exception $e) {
            return redirect()->route('expedientes.index')->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified expediente in storage.
     */
    public function update(Request $request, $id)
    {
        $expediente = Expediente::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'number' => ['required', Rule::unique('expedientes')->ignore($expediente->id)],
            'subject' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'parent_id' => 'nullable|exists:expedientes,id',
            'structure_id' => 'required|exists:organizational_structures,id',
            'section_id' => 'nullable|exists:sections,id',
            'subsection_id' => 'nullable|exists:subsections,id',
            'serie_id' => 'required|exists:series,id',
            'subserie_id' => 'nullable|exists:subseries,id',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'version' => 'nullable|integer',
            'status' => 'required|in:open,closed,archived',
            'metadata' => 'nullable|json',
            'support_type_id' => 'required|exists:support_types,id',
            'phase_id' => 'required|exists:phases,id',
            // Campos de ubicación física
            'box' => 'nullable|string|max:50',
            'folder' => 'nullable|string|max:50',
            'type' => 'nullable|in:Tomo,Legajo,Libro,Otros',
            'volume_number' => 'nullable|string|max:20',
            'folios_count' => 'nullable|integer',
            'additional_details' => 'nullable|string',
        ], [
            'number.required' => 'El número es obligatorio.',
            'number.unique' => 'El número ya existe.',
            'subject.required' => 'El asunto es obligatorio.',
            'structure_id.required' => 'La estructura organizacional es obligatoria.',
            'serie_id.required' => 'La serie es obligatoria.',
            'opening_date.required' => 'La fecha de apertura es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'support_type_id.required' => 'El tipo de soporte es obligatorio.',
            'phase_id.required' => 'La fase es obligatoria.',
            'box.required' => 'La caja es obligatoria para expedientes físicos.',
            'folder.required' => 'La carpeta es obligatoria para expedientes físicos.',
            'type.required' => 'El tipo es obligatorio para expedientes físicos.',
        ]);

        // Validación condicional para ubicación física
        $supportType = SupportType::find($request->support_type_id);
        if ($supportType && $supportType->is_physical) {
            $validator->after(function ($validator) {
                if (!$validator->getData()['box'] || !$validator->getData()['folder'] || !$validator->getData()['type']) {
                    $validator->errors()->add('box', 'La caja es obligatoria para expedientes físicos.');
                    $validator->errors()->add('folder', 'La carpeta es obligatoria para expedientes físicos.');
                    $validator->errors()->add('type', 'El tipo es obligatorio para expedientes físicos.');
                }
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $oldValues = $expediente->toArray();
            $expediente->number = $request->number;
            $expediente->subject = $request->subject;
            $expediente->detail = $request->detail;
            $expediente->parent_id = $request->parent_id;
            $expediente->structure_id = $request->structure_id;
            $expediente->section_id = $request->section_id;
            $expediente->subsection_id = $request->subsection_id;
            $expediente->serie_id = $request->serie_id;
            $expediente->subserie_id = $request->subserie_id;
            $expediente->opening_date = $request->opening_date;
            $expediente->closing_date = $request->closing_date;
            $expediente->status = $request->status;
            $expediente->metadata = $request->metadata;
            $expediente->support_type_id = $request->support_type_id;
            $expediente->phase_id = $request->phase_id;
            $expediente->updated_by = Auth::id();
            $expediente->version += 1;
            $expediente->save();

            // Actualizar o crear ubicación física si es físico o híbrido
            if ($request->filled('box') && $request->filled('folder') && $request->filled('type')) {
                $locationData = [
                    'box' => $request->box,
                    'folder' => $request->folder,
                    'type' => $request->type,
                    'volume_number' => $request->volume_number,
                    'folios_count' => $request->folios_count,
                    'additional_details' => $request->additional_details,
                    'updated_by' => Auth::id(),
                ];

                if ($expediente->currentLocation) {
                    $expediente->currentLocation->update($locationData);
                } else {
                    $locationData['expediente_id'] = $expediente->id;
                    $locationData['created_by'] = Auth::id();
                    ExpedienteLocation::create($locationData);
                }

                // Registrar en historial
                $this->logHistory($expediente, 'location_updated', $locationData);
            }

            // Registrar cambios generales en historial
            $changes = array_diff_assoc($expediente->toArray(), $oldValues);
            $this->logHistory($expediente, 'updated', $changes);

            return redirect()->route('expedientes.index')->with('success', 'Expediente actualizado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el expediente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified expediente from storage.
     */
    public function destroy($id)
    {
        try {
            $expediente = Expediente::findOrFail($id);
            $oldValues = $expediente->toArray();
            $expediente->delete();

            // Registrar en historial (aunque borrado suave)
            $this->logHistory($expediente, 'deleted', $oldValues);

            return redirect()->route('expedientes.index')->with('success', 'Expediente eliminado exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('expedientes.index')->with('error', 'Error al eliminar el expediente: ' . $e->getMessage());
        }
    }

    // Métodos adicionales para documentos, préstamos e historial

    /**
     * Agregar documento a expediente
     */
    public function addDocument(Request $request, $expedienteId)
    {
        $expediente = Expediente::findOrFail($expedienteId);

        $validator = Validator::make($request->all(), [
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'required|file|mimes:pdf,tiff|max:20480', // 20MB max
            'document_date' => 'required|date',
            'folio' => 'nullable|integer',
            'analog' => 'boolean',
            'physical_location' => 'nullable|string|required_if:analog,1',
            'metadata' => 'nullable|json',
        ], [
            'document_type_id.required' => 'El tipo de documento es obligatorio.',
            'file.required' => 'El archivo es obligatorio.',
            'file.mimes' => 'El archivo debe ser PDF o TIFF.',
            'file.max' => 'El archivo no debe exceder 20MB.',
            'document_date.required' => 'La fecha del documento es obligatoria.',
            'physical_location.required_if' => 'La ubicación física es obligatoria si es análogo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('file');
            $path = $file->store('documents', 'public'); // Almacenar en storage/public/documents

            // Validar y convertir si es necesario (simulado, implementar lógica real si se necesita)
            $mimeType = $file->getMimeType();
            if ($mimeType !== 'application/pdf' && $mimeType !== 'image/tiff') {
                // Lógica de conversión (usar librerías como Imagick o similar)
                // Por ahora, asumir que se convierte a PDF/A
                $path = $this->convertToPdfA($path); // Función placeholder
            }

            // Aplicar OCR si es PDF (placeholder)
            $ocrText = $this->applyOcr($path); // Función placeholder

            $document = new Document();
            $document->expediente_id = $expediente->id;
            $document->document_type_id = $request->document_type_id;
            $document->file_path = $path;
            $document->original_name = $file->getClientOriginalName();
            $document->mime_type = $mimeType;
            $document->converted_from = null; // Asumir null por ahora
            $document->size = $file->getSize();
            $document->document_date = $request->document_date;
            $document->folio = $request->folio ?? $this->generateFolio($expediente);
            $document->analog = $request->analog ?? false;
            $document->physical_location = $request->physical_location;
            $document->ocr_applied = true; // Asumir aplicado
            $document->ocr_text = $ocrText;
            $document->signed = false; // Inicial
            $document->signature_provider = null; // Inicial
            $document->metadata = $request->metadata;
            $document->uploaded_by = Auth::id();
            $document->updated_by = Auth::id();
            $document->save();

            // Registrar en historial del expediente
            $this->logHistory($expediente, 'document_added', ['document_id' => $document->id]);

            return redirect()->route('expedientes.show', $expediente->id)->with('success', 'Documento agregado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al agregar documento: ' . $e->getMessage());
        }
    }

    /**
     * Agregar préstamo a expediente
     */
    public function addLoan(Request $request, $expedienteId)
    {
        $expediente = Expediente::findOrFail($expedienteId);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'reason' => 'required|string',
            'status' => 'required|in:prestado,devuelto',
            'notes' => 'nullable|string',
        ], [
            'user_id.required' => 'El usuario es obligatorio.',
            'loan_date.required' => 'La fecha de préstamo es obligatoria.',
            'reason.required' => 'La razón es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $loan = new ExpedienteLoan();
            $loan->expediente_id = $expediente->id;
            $loan->user_id = $request->user_id;
            $loan->loan_date = $request->loan_date;
            $loan->return_date = $request->return_date;
            $loan->reason = $request->reason;
            $loan->status = $request->status;
            $loan->notes = $request->notes;
            $loan->created_by = Auth::id();
            $loan->updated_by = Auth::id();
            $loan->save();

            // Registrar en historial
            $this->logHistory($expediente, 'loan_added', ['loan_id' => $loan->id]);

            return redirect()->route('expedientes.show', $expediente->id)->with('success', 'Préstamo registrado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar préstamo: ' . $e->getMessage());
        }
    }

    // Función helper para log de historial
    protected function logHistory($expediente, $event, $changes)
    {
        $history = new ExpedienteHistory();
        $history->expediente_id = $expediente->id;
        $history->version = $expediente->version;
        $history->changes = json_encode($changes);
        $history->event = $event;
        $history->user_id = Auth::id();
        $history->save();
    }

    // Placeholder para conversión a PDF/A
    protected function convertToPdfA($path)
    {
        // Implementar con Ghostscript o similar
        return $path; // Retornar path convertido
    }

    // Placeholder para OCR
    protected function applyOcr($path)
    {
        // Implementar con Tesseract o similar
        return 'Texto OCR extraído';
    }

    // Generar folio consecutivo
    protected function generateFolio($expediente)
    {
        return $expediente->documents()->count() + 1;
    }
}