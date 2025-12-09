<?php

namespace App\Http\Controllers\Expediente;

use App\Http\Controllers\Controller;
use App\Models\Expediente\Expediente;
use App\Models\Expediente\ExpedienteHistory;
use App\Models\Expediente\ExpedienteLoan;
use App\Models\Expediente\Document;
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
            $query = Expediente::with(['structure', 'section', 'subsection', 'serie', 'subserie', 'creator']);

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

            if ($request->filled('phase')) {
                $query->where('phase', $request->phase);
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

            return view('expediente.create', compact('structures', 'sections', 'subsections', 'series', 'subseries'));
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
            'structure_id' => 'required|exists:organizational_structures,id',
            'section_id' => 'nullable|exists:sections,id',
            'subsection_id' => 'nullable|exists:subsections,id',
            'serie_id' => 'required|exists:series,id',
            'subserie_id' => 'nullable|exists:subseries,id',
            'phase' => 'required|in:gestión,central,historico',
            'physical' => 'boolean',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'status' => 'required|in:abierto,cerrado',
            'metadata' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $expediente = new Expediente($request->all());
            $expediente->created_by = Auth::id();
            $expediente->updated_by = Auth::id();
            $expediente->version = 1; // Versión inicial
            $expediente->save();

            // Registrar en historial
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
            $expediente = Expediente::with(['parent', 'children', 'structure', 'section', 'subsection', 'serie', 'subserie', 'documents', 'histories', 'loans', 'creator', 'updater'])->findOrFail($id);

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
            $expediente = Expediente::findOrFail($id);
            $structures = OrganizationalStructure::where('active', true)->get();
            $sections = Section::all();
            $subsections = Subsection::all();
            $series = Serie::all();
            $subseries = Subserie::all();

            return view('expediente.edit', compact('expediente', 'structures', 'sections', 'subsections', 'series', 'subseries'));
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
            'structure_id' => 'required|exists:organizational_structures,id',
            'section_id' => 'nullable|exists:sections,id',
            'subsection_id' => 'nullable|exists:subsections,id',
            'serie_id' => 'required|exists:series,id',
            'subserie_id' => 'nullable|exists:subseries,id',
            'phase' => 'required|in:gestión,central,historico',
            'physical' => 'boolean',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'status' => 'required|in:abierto,cerrado',
            'metadata' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $oldValues = $expediente->toArray();
            $expediente->update($request->all());
            $expediente->updated_by = Auth::id();
            $expediente->version += 1;
            $expediente->save();

            // Registrar en historial
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

            $document = new Document([
                'expediente_id' => $expediente->id,
                'document_type_id' => $request->document_type_id,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $mimeType,
                'size' => $file->getSize(),
                'document_date' => $request->document_date,
                'folio' => $request->folio ?? $this->generateFolio($expediente),
                'analog' => $request->analog ?? false,
                'physical_location' => $request->physical_location,
                'ocr_applied' => true, // Asumir aplicado
                'ocr_text' => $ocrText,
                'signed' => false, // Inicial
                'metadata' => $request->metadata,
                'uploaded_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $loan = new ExpedienteLoan($request->all());
            $loan->expediente_id = $expediente->id;
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
        $history = new ExpedienteHistory([
            'expediente_id' => $expediente->id,
            'version' => $expediente->version,
            'changes' => json_encode($changes),
            'event' => $event,
            'user_id' => Auth::id(),
        ]);
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