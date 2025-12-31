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
use Smalot\PdfParser\Parser;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['expediente', 'documentType', 'uploader'])->paginate(10);
        return view('expediente.documents.index', compact('documents'));
    }

    public function create(Expediente $expediente)
    {
        $documentTypes = DocumentType::all();
        return view('expediente.documents.create', compact('expediente', 'documentTypes'));
    }

    public function store(Request $request, Expediente $expediente)
    {
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:20480',
            'document_date' => 'nullable|date',
            'folio' => 'nullable|string',
            'analog' => 'nullable|accepted',
            'physical_location' => 'nullable|string',
            'ocr_applied' => 'nullable|accepted',
            'ocr_text' => 'nullable|string',
            'signed' => 'nullable|accepted',
            'signature_provider' => 'nullable|string',
            'metadata_keys.*' => 'nullable|string',
            'metadata_values.*' => 'nullable|string',
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
        $validated['analog'] = $request->has('analog');
        $validated['ocr_applied'] = $request->has('ocr_applied');
        $validated['signed'] = $request->has('signed');

        $metadata = [];
        if ($request->has('metadata_keys')) {
            foreach ($request->input('metadata_keys') as $index => $key) {
                if ($key) {
                    $metadata[$key] = $request->input('metadata_values')[$index] ?? '';
                }
            }
        }
        $validated['metadata'] = $metadata;

        // Extraer texto del PDF si ocr_applied está activo y es un PDF
        if ($validated['ocr_applied'] && isset($validated['mime_type']) && $validated['mime_type'] === 'application/pdf' && isset($validated['file_path'])) {
            $validated['ocr_text'] = $this->extractPdfText(Storage::disk('public')->path($validated['file_path']));
        }

        $document = Document::create($validated);

        return redirect()->route('documents.show',  $document)->with('success', 'Documento cargado exitosamente.');
    }

    public function show(Document $document)
    {
        $document = Document::find($document->id);
       
        $document->load(['expediente', 'documentType', 'uploader', 'updater']);
         
        return view('expediente.documents.show', compact('document'));
    }

    
    public function edit(Document $document)
    {
        $document = Document::find($document->id);
        $documentTypes = DocumentType::all();
        return view('expediente.documents.edit', compact('document', 'documentTypes'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:20480',
            'document_date' => 'nullable|date',
            'folio' => 'nullable|string',
            'analog' => 'nullable|accepted',
            'physical_location' => 'nullable|string',
            'ocr_applied' => 'nullable|accepted',
            'ocr_text' => 'nullable|string',
            'signed' => 'nullable|accepted',
            'signature_provider' => 'nullable|string',
            'metadata_keys.*' => 'nullable|string',
            'metadata_values.*' => 'nullable|string',
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
        $validated['analog'] = $request->has('analog');
        $validated['ocr_applied'] = $request->has('ocr_applied');
        $validated['signed'] = $request->has('signed');

        // Process metadata
        $metadata = [];
        if ($request->has('metadata_keys')) {
            foreach ($request->input('metadata_keys') as $index => $key) {
                if ($key) {
                    $metadata[$key] = $request->input('metadata_values')[$index] ?? '';
                }
            }
        }
        $validated['metadata'] = $metadata;

        // Extraer texto del PDF si ocr_applied está activo y es un PDF
        $currentMimeType = isset($validated['mime_type']) ? $validated['mime_type'] : $document->mime_type;
        $currentFilePath = isset($validated['file_path']) ? $validated['file_path'] : $document->file_path;
        if ($validated['ocr_applied'] && $currentMimeType === 'application/pdf' && $currentFilePath) {
            $validated['ocr_text'] = $this->extractPdfText(Storage::disk('public')->path($currentFilePath));
        } elseif (!$validated['ocr_applied']) {
            $validated['ocr_text'] = null; // Limpiar ocr_text si ocr_applied se desactiva
        }

        $document->update($validated);

        return redirect()->route('documents.show', $document)->with('success', 'Documento actualizado exitosamente.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $expedienteId = $document->expediente_id;
        $document->delete();
        return redirect()->route('expedientes.show', $expedienteId)->with('success', 'Documento eliminado exitosamente.');
    }

    private function extractPdfText(string $filePath): string
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);

            return $text;
        } catch (\Exception $e) {
            \Log::error('Error al extraer texto de PDF: ' . $e->getMessage());
            return '';
        }
    }
}