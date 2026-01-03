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
use App\Models\Expediente\MetadataType;
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
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;
use Exception;
use Illuminate\Support\Arr;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
        try {
            $stats = Expediente::query()
                ->selectRaw('phase_id, COUNT(*) as total')
                ->groupBy('phase_id')
                ->with('phase')
                ->get()
                ->keyBy('phase_id');

            $total_expedientes = Expediente::count();

            $in_management = $stats->get(Phase::where('code', Phase::CODE_MGMT)->first()?->id)?->total ?? 0;
            $in_central = $stats->get(Phase::where('code', Phase::CODE_CENT)->first()?->id)?->total ?? 0;
            $in_historical = $stats->get(Phase::where('code', Phase::CODE_HIST)->first()?->id)?->total ?? 0;

            $query = Expediente::with([
                'structure',
                'section',
                'subsection',
                'serie',
                'subserie',
                'creator',
                'currentLocation',
                'phase'
            ]);
            
            $search = $request->input('search');

            if ($search) {
                $terms = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);
                if (!empty($terms)) {
                    $query->where(function ($q) use ($terms) {
                        foreach ($terms as $term) {
                            $q->orWhere('number', 'like', "%{$term}%")
                            ->orWhere('subject', 'like', "%{$term}%")
                            ->orWhere('detail', 'like', "%{$term}%")
                            ->orWhere('metadata', 'like', "%{$term}%");
                        }
                    })->orWhereHas('documents', function ($dq) use ($terms) {
                        $dq->where(function ($dd) use ($terms) {
                            foreach ($terms as $term) {
                                $dd->orWhere('ocr_text', 'like', "%{$term}%")
                                ->orWhere('metadata', 'like', "%{$term}%")
                                ->orWhere('original_name', 'like', "%{$term}%")
                                ->orWhere('folio', 'like', "%{$term}%");
                            }
                        });
                    });
                }
            }
            
            if ($request->filled('phase')) {
                $phaseMap = [
                    'gestión' => Phase::CODE_MGMT,
                    'central' => Phase::CODE_CENT,
                    'historico' => Phase::CODE_HIST,
                ];
                $phaseCode = $phaseMap[$request->phase] ?? null;
                if ($phaseCode) {
                    $phase = Phase::where('code', $phaseCode)->first();
                    if ($phase) {
                        $query->where('phase_id', $phase->id);
                    }
                }
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $expedientes = $query->orderBy('id','desc')->paginate(15);

            $phases = Phase::active()->ordered()->get();

            $metadataTypes = MetadataType::active()->ordered()->get();

            return view('expediente.index', compact(
                'expedientes',
                'phases',
                'total_expedientes',
                'in_management',
                'in_central',
                'in_historical',
                'metadataTypes'
            ));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar la lista de expedientes: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $structures = OrganizationalStructure::active()->get();
        $sections = Section::all();
        $subsections = Subsection::all();
        $series = Serie::all();
        $subseries = Subserie::all();
        $supportTypes = SupportType::active()->get();
        $phases = Phase::active()->ordered()->get();
        $metadataTypes = MetadataType::active()->ordered()->get();

        return view('expediente.create', compact(
            'structures', 'sections', 'subsections', 'series', 'subseries',
            'supportTypes', 'phases', 'metadataTypes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'structure_id' => 'nullable|exists:organizational_structures,id',
            'section_id' => 'nullable|exists:sections,id',
            'subsection_id' => 'nullable|exists:subsections,id',
            'serie_id' => 'nullable|exists:series,id',
            'subserie_id' => 'nullable|exists:subseries,id',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'support_type_id' => 'required|exists:support_types,id',
            'phase_id' => 'required|exists:phases,id',
            'box' => 'nullable|string',
            'folder' => 'nullable|string',
            'type' => 'nullable|string',
            'volume_number' => 'nullable|integer',
            'folios_count' => 'nullable|integer',
            // Metadatos
            'metadata' => 'array',
            'metadata.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $expediente = Expediente::create([
                'name' => $validated['name'],
                'subject' => $validated['subject'],
                'detail' => $validated['detail'],
                'structure_id' => $validated['structure_id'],
                'section_id' => $validated['section_id'],
                'subsection_id' => $validated['subsection_id'],
                'serie_id' => $validated['serie_id'],
                'subserie_id' => $validated['subserie_id'],
                'opening_date' => $validated['opening_date'],
                'closing_date' => $validated['closing_date'],
                'support_type_id' => $validated['support_type_id'],
                'phase_id' => $validated['phase_id'],
                'status' => 'open',
                'version' => 1,
                'responsible_id' => Auth::id(),
            ]);

            $supportType = SupportType::find($validated['support_type_id']);
            if ($supportType->is_physical || $supportType->is_electronic && $supportType->is_physical) {
                if ($request->filled(['box', 'folder', 'type'])) {
                    ExpedienteLocation::create([
                        'expediente_id' => $expediente->id,
                        'box' => $request->box,
                        'folder' => $request->folder,
                        'type' => $request->type,
                        'volume_number' => $request->volume_number,
                        'folios_count' => $request->folios_count,
                    ]);
                }
            }

            $this->syncMetadata($expediente, $request->input('metadata', []));

            $this->logHistory($expediente, 'created', $validated);

            DB::commit();
            return redirect()->route('expedientes.show', $expediente)
                ->with('success', 'Expediente creado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear expediente: ' . $e->getMessage());
        }
    }

    public function edit(Expediente $expediente)
    {
        $structures = OrganizationalStructure::active()->get();
        $sections = Section::all();
        $subsections = Subsection::all();
        $series = Serie::all();
        $subseries = Subserie::all();
        $supportTypes = SupportType::active()->get();
        $phases = Phase::active()->ordered()->get();
        $metadataTypes = MetadataType::active()->ordered()->get();

        $currentMetadata = $expediente->metadata()->pluck('value', 'metadata_type_id')->toArray();

        return view('expediente.edit', compact(
            'expediente', 'structures', 'sections', 'subsections', 'series', 'subseries',
            'supportTypes', 'phases', 'metadataTypes', 'currentMetadata'
        ));
    }

    public function update(Request $request, Expediente $expediente)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'structure_id' => 'nullable|exists:organizational_structures,id',
            'section_id' => 'nullable|exists:sections,id',
            'subsection_id' => 'nullable|exists:subsections,id',
            'serie_id' => 'nullable|exists:series,id',
            'subserie_id' => 'nullable|exists:subseries,id',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'support_type_id' => 'required|exists:support_types,id',
            'phase_id' => 'required|exists:phases,id',
            'box' => 'nullable|string',
            'folder' => 'nullable|string',
            'type' => 'nullable|string',
            'metadata' => 'array',
            'metadata.*' => 'nullable|string',
        ]);
        DB::beginTransaction();
        try {
            $oldData = $expediente->toArray();

            $expediente->update([
                'name' => $validated['name'],
                'subject' => $validated['subject'],
                'detail' => $validated['detail'],
                'structure_id' => $validated['structure_id'],
                'section_id' => $validated['section_id'],
                'subsection_id' => $validated['subsection_id'],
                'serie_id' => $validated['serie_id'],
                'subserie_id' => $validated['subserie_id'],
                'opening_date' => $validated['opening_date'],
                'closing_date' => $validated['closing_date'],
                'support_type_id' => $validated['support_type_id'],
                'phase_id' => $validated['phase_id'],
                'updated_by' => Auth::id(),
            ]);

            $this->updatePhysicalLocation($expediente, $request);

            $this->syncMetadata($expediente, $request->input('metadata', []));

            $fieldsToDiff = Arr::except($validated, ['metadata', 'box', 'folder', 'type']);  // Excluye lo que se maneja aparte.
            $changes = array_diff_assoc($fieldsToDiff, Arr::only($oldData, array_keys($fieldsToDiff)));
            $this->logHistory($expediente, 'updated', ['changes' => $changes]);

            DB::commit();
            return redirect()->route('expedientes.show', $expediente)
                ->with('success', 'Expediente actualizado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    protected function syncMetadata(Expediente $expediente, array $metadataInput)
    {
        foreach ($metadataInput as $typeId => $value) {
            $type = MetadataType::find($typeId);
            if ($type) {
                $expediente = Expediente::find($expediente->id);
                $expediente->metadata()->updateOrCreate(
                    ['metadata_type_id' => $type->id],
                    ['value' => $value ?: null]
                );
            }
        }
    }

    protected function updatePhysicalLocation(Expediente $expediente, Request $request)
    {
        if ($request->filled(['box', 'folder', 'type'])) {
            $expediente->latestLocation()->updateOrCreate(
                ['expediente_id' => $expediente->id],
                [
                    'box' => $request->box,
                    'folder' => $request->folder,
                    'type' => $request->type,
                    'volume_number' => $request->volume_number,
                    'folios_count' => $request->folios_count,
                    'updated_by' => Auth::id(),
                ]
            );
        }
    }

    protected function logHistory($expediente, $event, $changes)
    {
        ExpedienteHistory::create([
            'expediente_id' => $expediente->id,
            'version' => $expediente->version,
            'changes' => $changes,
            'event' => $event,
            'user_id' => Auth::id(),
        ]);
    }


    public function show($id)
    {
        try {
            $expediente = Expediente::with([
                'parent', 'children', 'structure', 'section', 'subsection', 'serie', 'subserie',
                'documents.documentType', 'histories.user', 'loans.user', 'transfers', 'supportType',
                'phase', 'creator', 'updater', 'currentLocation.creator', 'locations.creator', 'metadataAll.metadataType'
            ])->findOrFail($id);

            $documentTypes = DocumentType::all();

            return view('expediente.show', compact('expediente', 'documentTypes'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el expediente: ' . $e->getMessage());
        }
    }
        public function destroy($id)
    {
        try {
            $expediente = Expediente::findOrFail($id);
            $oldValues = $expediente->toArray();
            $expediente->delete();

            $this->logHistory($expediente, 'deleted', $oldValues);

            return redirect()->route('expedientes.index')->with('success', 'Expediente eliminado exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('expedientes.index')->with('error', 'Error al eliminar el expediente: ' . $e->getMessage());
        }
    }

    public function addDocument(Request $request, $expedienteId)
    {
        $expediente = Expediente::findOrFail($expedienteId);

        $validator = Validator::make($request->all(), [
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'required|file|mimes:pdf,tiff|max:20480',
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
            $path = $file->store('documents', 'public'); 

            $mimeType = $file->getMimeType();
            if ($mimeType !== 'application/pdf' && $mimeType !== 'image/tiff') {
                $path = $this->convertToPdfA($path);
            }

            $ocrText = $this->applyOcr($path);

            $document = new Document();
            $document->expediente_id = $expediente->id;
            $document->document_type_id = $request->document_type_id;
            $document->file_path = $path;
            $document->original_name = $file->getClientOriginalName();
            $document->mime_type = $mimeType;
            $document->converted_from = null;
            $document->size = $file->getSize();
            $document->document_date = $request->document_date;
            $document->folio = $request->folio ?? $this->generateFolio($expediente);
            $document->analog = $request->analog ?? false;
            $document->physical_location = $request->physical_location;
            $document->ocr_applied = true;
            $document->ocr_text = $ocrText;
            $document->signed = false;
            $document->signature_provider = null; 
            $document->metadata = $request->metadata;
            $document->uploaded_by = Auth::id();
            $document->updated_by = Auth::id();
            $document->save();

            $this->logHistory($expediente, 'document_added', ['document_id' => $document->id]);

            return redirect()->route('expedientes.show', $expediente->id)->with('success', 'Documento agregado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al agregar documento: ' . $e->getMessage());
        }
    }

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

            $this->logHistory($expediente, 'loan_added', ['loan_id' => $loan->id]);

            return redirect()->route('expedientes.show', $expediente->id)->with('success', 'Préstamo registrado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar préstamo: ' . $e->getMessage());
        }
    }

    protected function convertToPdfA($path)
    {
        return $path; 
    }

    protected function applyOcr($path)
    {
        return 'Texto OCR extraído';
    }

    protected function generateFolio($expediente)
    {
        return $expediente->documents()->count() + 1;
    }
    public function history(Expediente $expediente)
    {
        // 1. Historial manual (expediente_histories)
        $manualHistory = ExpedienteHistory::where('expediente_id', $expediente->id)
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        // 2. Auditorías automáticas del expediente principal
        $expedienteAudits = $expediente->audits()
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        // 3. Auditorías de documentos relacionados
        $documentAudits = Audit::where('auditable_type', \App\Models\Expediente\Document::class)
            ->whereIn('auditable_id', $expediente->documents()->pluck('id'))
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        // 4. Auditorías de préstamos
        $loanAudits = Audit::where('auditable_type', \App\Models\Expediente\ExpedienteLoan::class)
            ->whereIn('auditable_id', $expediente->loans()->pluck('id'))
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        // 5. Auditorías de ubicaciones físicas
        $locationAudits = Audit::where('auditable_type', \App\Models\Expediente\ExpedienteLocation::class)
            ->whereIn('auditable_id', $expediente->locations()->pluck('id'))
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        // Unificar todo en una colección ordenada por fecha
        $allEvents = collect();

        // Eventos manuales
        foreach ($manualHistory as $entry) {
            $allEvents->push([
                'date'        => $entry->created_at,
                'user'        => $entry->user,
                'type'        => 'manual',
                'event'       => $entry->event,
                'description' => $this->formatManualEvent($entry),
                'changes'     => $entry->changes,
            ]);
        }

        // Auditorías del expediente
        foreach ($expedienteAudits as $audit) {
            $allEvents->push([
                'date'        => $audit->created_at,
                'user'        => $audit->user,
                'type'        => 'audit',
                'event'       => $audit->event,
                'description' => $this->formatAuditEvent($audit, 'Expediente'),
                'old_values'  => $audit->old_values,
                'new_values'  => $audit->new_values,
            ]);
        }

        // Auditorías de documentos
        foreach ($documentAudits as $audit) {
            $doc = $expediente->documents()->find($audit->auditable_id);
            $allEvents->push([
                'date'        => $audit->created_at,
                'user'        => $audit->user,
                'type'        => 'audit',
                'event'       => $audit->event,
                'description' => $this->formatAuditEvent($audit, 'Documento: ' . ($doc?->original_name ?? 'Eliminado')),
                'old_values'  => $audit->old_values,
                'new_values'  => $audit->new_values,
            ]);
        }

        // Auditorías de préstamos y ubicaciones (similar)
        foreach ($loanAudits as $audit) {
            $allEvents->push([
                'date'        => $audit->created_at,
                'user'        => $audit->user,
                'type'        => 'audit',
                'event'       => $audit->event,
                'description' => $this->formatAuditEvent($audit, 'Préstamo'),
                'old_values'  => $audit->old_values,
                'new_values'  => $audit->new_values,
            ]);
        }

        foreach ($locationAudits as $audit) {
            $allEvents->push([
                'date'        => $audit->created_at,
                'user'        => $audit->user,
                'type'        => 'audit',
                'event'       => $audit->event,
                'description' => $this->formatAuditEvent($audit, 'Ubicación física'),
                'old_values'  => $audit->old_values,
                'new_values'  => $audit->new_values,
            ]);
        }

        // Ordenar por fecha descendente
        $timeline = $allEvents->sortByDesc('date')->values();

        return view('expediente.history', compact('expediente', 'timeline'));
    }

    // Métodos auxiliares para formatear la descripción

    private function formatManualEvent(ExpedienteHistory $entry): string
    {
        return match ($entry->event) {
            'loan_added'     => 'Se registró un préstamo del expediente',
            'loan_returned'  => 'Se registró la devolución del expediente',
            'closed'         => 'El expediente fue cerrado',
            'reopened'       => 'El expediente fue reabierto',
            'phase_changed'  => 'Cambio de fase del expediente',
            default          => ucfirst(str_replace('_', ' ', $entry->event)),
        };
    }

    private function formatAuditEvent(Audit $audit, string $context): string
    {
        return match ($audit->event) {
            'created' => "$context creado",
            'updated' => "$context actualizado",
            'deleted' => "$context eliminado (soft delete)",
            'restored'=> "$context restaurado",
            default   => "$context - {$audit->event}",
        };
    }

}