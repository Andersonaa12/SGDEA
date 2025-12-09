<?php

namespace App\Http\Controllers\Expediente;

use App\Http\Controllers\Controller;
use App\Models\Expediente\Document;
use App\Models\Expediente\Expediente;
use App\Models\Trd\DocumentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // This might not be used directly, as documents are nested under expedientes
        $documents = Document::with(['expediente', 'documentType', 'uploader'])->paginate(10);
        return view('expediente.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Expediente $expediente)
    {
        $documentTypes = DocumentType::all();
        return view('expediente.documents.create', compact('expediente', 'documentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Expediente $expediente)
    {
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:20480',
            'original_name' => 'nullable|string|max:255',
            'mime_type' => 'nullable|string',
            'converted_from' => 'nullable|string',
            'size' => 'nullable|integer',
            'document_date' => 'nullable|date',
            'folio' => 'nullable|string',
            'analog' => 'nullable|boolean',
            'physical_location' => 'nullable|string',
            'ocr_applied' => 'nullable|boolean',
            'ocr_text' => 'nullable|string',
            'signed' => 'nullable|boolean',
            'signature_provider' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $validated['file_path'] = $filePath;
            $validated['original_name'] = $request->file('file')->getClientOriginalName();
            $validated['mime_type'] = $request->file('file')->getMimeType();
            $validated['size'] = $request->file('file')->getSize();
        }

        $validated['expediente_id'] = $expediente->id;
        $validated['uploaded_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $document = Document::create($validated);

        return redirect()->route('expedientes.show', $expediente)->with('success', 'Documento agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document->load(['expediente', 'documentType', 'uploader', 'updater']);
        return view('expediente.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $documentTypes = DocumentType::all();
        return view('expediente.documents.edit', compact('document', 'documentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:20480',
            'original_name' => 'nullable|string|max:255',
            'mime_type' => 'nullable|string',
            'converted_from' => 'nullable|string',
            'size' => 'nullable|integer',
            'document_date' => 'nullable|date',
            'folio' => 'nullable|string',
            'analog' => 'nullable|boolean',
            'physical_location' => 'nullable|string',
            'ocr_applied' => 'nullable|boolean',
            'ocr_text' => 'nullable|string',
            'signed' => 'nullable|boolean',
            'signature_provider' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $filePath = $request->file('file')->store('documents', 'public');
            $validated['file_path'] = $filePath;
            $validated['original_name'] = $request->file('file')->getClientOriginalName();
            $validated['mime_type'] = $request->file('file')->getMimeType();
            $validated['size'] = $request->file('file')->getSize();
        }

        $validated['updated_by'] = Auth::id();

        $document->update($validated);

        return redirect()->route('documents.show', $document)->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        return redirect()->route('expedientes.show', $document->expediente_id)->with('success', 'Documento eliminado exitosamente.');
    }
}