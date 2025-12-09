<?php

namespace App\Http\Controllers\Trd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Trd\Trd;

class TrdController extends Controller
{
    public function index()
    {
        $trds = Trd::with('creator', 'updater')->latest()->paginate(10);
        return view('trd.trds.index', compact('trds'));
    }

    public function create()
    {
        return view('trd.trds.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50|unique:trds,version',
            'approval_date' => 'required|date',
            'valid_from' => 'required|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'approval_file' => 'nullable|file|mimes:pdf|max:10240',
            'active' => 'sometimes|in:on',
        ], [
            'version.required' => 'La versión es obligatoria.',
            'version.unique'   => 'Ya existe una TRD con esta versión.',
            'approval_date.required' => 'La fecha de aprobación es obligatoria.',
            'valid_from.required' => 'La fecha de vigencia inicial es obligatoria.',
            'valid_to.after_or_equal' => 'La fecha final debe ser igual o posterior a la inicial.',
            'approval_file.mimes' => 'El archivo debe ser un PDF.',
            'approval_file.max'   => 'El archivo no puede pesar más de 10MB.',
        ]);

        try {
            $trd = new Trd();

            $trd->version       = $validated['version'];
            $trd->approval_date = $validated['approval_date'];
            $trd->valid_from = $validated['valid_from'];
            $trd->valid_to = $validated['valid_to'] ?? null;
            $trd->active = $request->has('active');
            $trd->created_by = Auth::id();
            $trd->updated_by = Auth::id();

            if ($request->hasFile('approval_file')) {
                $trd->approval_file = $request->file('approval_file')
                    ->store('trd/approvals', 'public');
            }

            $trd->save();

            return redirect()->route('trds.index')
                ->with('success', 'TRD creada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear TRD: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear la TRD. Inténtalo de nuevo.');
        }
    }

    public function show(Trd $trd)
    {
        $trd->load('series', 'creator', 'updater');
        return view('trd.trds.show', compact('trd'));
    }

    public function edit(Trd $trd)
    {
        return view('trd.trds.edit', compact('trd'));
    }

    public function update(Request $request, Trd $trd)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50|unique:trds,version,' . $trd->id,
            'approval_date' => 'required|date',
            'valid_from' => 'required|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'approval_file' => 'nullable|file|mimes:pdf|max:10240',
            'active' => 'sometimes|in:on',
        ], [
            'version.required' => 'La versión es obligatoria.',
            'version.unique' => 'Ya existe otra TRD con esta versión.',
            'approval_date.required' => 'La fecha de aprobación es obligatoria.',
            'valid_from.required' => 'La fecha de vigencia inicial es obligatoria.',
            'valid_to.after_or_equal' => 'La fecha final debe ser igual o posterior a la inicial.',
            'approval_file.mimes' => 'El archivo debe ser un PDF.',
            'approval_file.max'   => 'El archivo no puede pesar más de 10MB.',
        ]);

        try {
            $trd->version = $validated['version'];
            $trd->approval_date = $validated['approval_date'];
            $trd->valid_from = $validated['valid_from'];
            $trd->valid_to = $validated['valid_to'] ?? null;
            $trd->active = $request->has('active');
            $trd->updated_by = Auth::id();

            if ($request->hasFile('approval_file')) {
                if ($trd->approval_file && Storage::disk('public')->exists($trd->approval_file)) {
                    Storage::disk('public')->delete($trd->approval_file);
                }
                $trd->approval_file = $request->file('approval_file')
                    ->store('trd/approvals', 'public');
            }

            $trd->save();

            return redirect()->route('trds.index')
                ->with('success', 'TRD actualizada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar TRD: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar la TRD.');
        }
    }

    public function destroy(Trd $trd)
    {
        try {
            if ($trd->approval_file && Storage::disk('public')->exists($trd->approval_file)) {
                Storage::disk('public')->delete($trd->approval_file);
            }

            $trd->delete();

            return redirect()->route('trds.index')
                ->with('success', 'TRD eliminada exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar la TRD. Puede estar en uso.');
        }
    }
}