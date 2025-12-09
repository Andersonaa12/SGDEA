<?php

namespace App\Http\Controllers\Trd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Trd\DocumentType;
use App\Models\Trd\Subserie;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::with('subserie.serie.trd', 'creator', 'updater')
            ->latest()
            ->paginate(10);

        return view('trd.document-types.index', compact('documentTypes'));
    }

    public function create()
    {
        $subseries = Subserie::with('serie.trd')
            ->orderBy('name')
            ->get();

        return view('trd.document-types.create', compact('subseries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subserie_id' => 'required|exists:subseries,id',
            'code' => 'required|string|max:30|unique:document_types,code',
            'name' => 'required|string|max:255',
            'required_metadata'  => 'required|json',
            'analog' => 'sometimes|in:on',
            'requires_signature' => 'sometimes|in:on',
            'allowed_formats' => 'required|string|max:255',
        ], [
            'subserie_id.required' => 'Debe seleccionar una subserie.',
            'subserie_id.exists' => 'La subserie seleccionada no es válida.',
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Ya existe un tipo de documento con este código.',
            'code.max' => 'El código no puede exceder los 30 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'required_metadata.required' => 'Los metadatos requeridos son obligatorios.',
            'required_metadata.json'     => 'El formato de metadatos debe ser JSON válido.',
            'allowed_formats.required'   => 'Debe especificar los formatos permitidos.',
        ]);

        try {
            $documentType = new DocumentType();

            $documentType->subserie_id = $validated['subserie_id'];
            $documentType->code = strtoupper(trim($validated['code']));
            $documentType->name = trim($validated['name']);
            $documentType->required_metadata  = json_decode($validated['required_metadata'], true); // Aseguramos array
            $documentType->analog = $request->has('analog');
            $documentType->requires_signature = $request->has('requires_signature');
            $documentType->allowed_formats = strtolower(trim($validated['allowed_formats']));
            $documentType->created_by = Auth::id();
            $documentType->updated_by = Auth::id();

            $documentType->save();

            return redirect()->route('document-types.index')
                ->with('success', 'Tipo de documento creado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear tipo de documento: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear el tipo de documento.');
        }
    }

    public function show( $id)
    {
        $documentType = DocumentType::with(['subserie.serie.trd', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        return view('trd.document-types.show', compact('documentType'));
    }

    public function edit($id)
    {
        $subseries = Subserie::with('serie.trd')
            ->orderBy('name')
            ->get();
            
        $documentType = DocumentType::with(['subserie.serie.trd', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

        return view('trd.document-types.edit', compact('documentType', 'subseries'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'subserie_id' => 'required|exists:subseries,id',
            'code' => 'required|string|max:30',
            'name' => 'required|string|max:255',
            'required_metadata' => 'required|json',
            'analog' => 'sometimes|in:on',
            'requires_signature' => 'sometimes|in:on',
            'allowed_formats' => 'required|string|max:255',
        ], [
            'code.unique'        => 'Ya existe otro tipo de documento con este código.',
            'required_metadata.json' => 'El JSON de metadatos no es válido.',
        ]);

        try {
            $documentType = DocumentType::with(['subserie.serie.trd', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

            $documentType->subserie_id = $validated['subserie_id'];
            $documentType->code = strtoupper(trim($validated['code']));
            $documentType->name = trim(string: $validated['name']);
            $documentType->required_metadata  = json_decode($validated['required_metadata'], true);
            $documentType->analog = $request->has('analog');
            $documentType->requires_signature = $request->has('requires_signature');
            $documentType->allowed_formats = strtolower(trim($validated['allowed_formats']));
            $documentType->updated_by = Auth::id();

            $documentType->save();

            return redirect()->route('document-types.index')
                ->with('success', 'Tipo de documento actualizado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar tipo de documento: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar el tipo de documento.');
        }
    }

    public function destroy($id)
    {
        try {
            $documentType = DocumentType::with(['subserie.serie.trd', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

            $documentType->delete();

            return redirect()->route('document-types.index')
                ->with('success', 'Tipo de documento eliminado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al eliminar tipo de documento: ' . $e->getMessage());

            return back()
                ->with('error', 'No se pudo eliminar el tipo de documento. Puede estar en uso por documentos del expediente.');
        }
    }
}