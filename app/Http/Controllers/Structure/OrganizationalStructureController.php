<?php
namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructureController extends Controller
{
    public function index()
    {
        $structures = OrganizationalStructure::with('creator', 'updater')->latest()->paginate(10);
        return view('structure.organizational-structures.index', compact('structures'));
    }

    public function create()
    {
        return view('structure.organizational-structures.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50|unique:organizational_structures,version',
            'description' => 'nullable|string|max:5000',
            'approval_file' => 'nullable|file|mimes:pdf|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'active' => 'sometimes|in:on',
        ], [
            'version.required' => 'La versión es obligatoria.',
            'version.unique' => 'Ya existe una estructura con esta versión.',
            'start_date.required' => 'La fecha inicial es obligatoria.',
            'end_date.after_or_equal' => 'La fecha final debe ser igual o posterior a la inicial.',
            'approval_file.mimes' => 'El archivo debe ser un PDF.',
            'approval_file.max' => 'El archivo no puede pesar más de 10MB.',
        ]);

        try {
            $structure = new OrganizationalStructure();

            $structure->version = $validated['version'];
            $structure->description = $validated['description'];
            $structure->start_date = $validated['start_date'];
            $structure->end_date = $validated['end_date'] ?? null;
            $structure->active = $request->has('active');
            $structure->created_by = Auth::id();
            $structure->updated_by = Auth::id();

            if ($request->hasFile('approval_file')) {
                $structure->approval_file = $request->file('approval_file')->store('structure/approvals', 'public');
            }

            $structure->save();

            return redirect()->route('organizational-structures.index')
                ->with('success', 'Estructura organizacional creada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear estructura organizacional: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear la estructura organizacional. Inténtalo de nuevo.');
        }
    }

    public function show($id)
    {
        $structure = OrganizationalStructure::with(['sections', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

        return view('structure.organizational-structures.show', compact('structure'));
    }

    public function edit($id)
    {
        $structure = OrganizationalStructure::with(['sections', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        return view('structure.organizational-structures.edit', compact('structure'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50',
            'description' => 'nullable|string|max:5000',
            'approval_file' => 'nullable|file|mimes:pdf|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'active' => 'sometimes|in:on',
        ], [
            'version.unique' => 'Ya existe otra estructura con esta versión.',
            'end_date.after_or_equal' => 'La fecha final debe ser igual o posterior a la inicial.',
        ]);

        try {
            $organizationalStructure = OrganizationalStructure::with(['sections', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
            $organizationalStructure->version = $validated['version'];
            $organizationalStructure->description = $validated['description'];
            $organizationalStructure->start_date = $validated['start_date'];
            $organizationalStructure->end_date = $validated['end_date'] ?? null;
            $organizationalStructure->active = $request->has('active');
            $organizationalStructure->updated_by = Auth::id();

            if ($request->hasFile('approval_file')) {
                if ($organizationalStructure->approval_file && Storage::disk('public')->exists($organizationalStructure->approval_file)) {
                    Storage::disk('public')->delete($organizationalStructure->approval_file);
                }
                $organizationalStructure->approval_file = $request->file('approval_file')->store('structure/approvals', 'public');
            }

            $organizationalStructure->save();

            return redirect()->route('organizational-structures.index')
                ->with('success', 'Estructura organizacional actualizada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar estructura organizacional: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar la estructura organizacional.');
        }
    }

    public function destroy($id)
    {
        try {
            $organizationalStructure = OrganizationalStructure::with(['sections', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

            if ($organizationalStructure->approval_file && Storage::disk('public')->exists($organizationalStructure->approval_file)) {
                Storage::disk('public')->delete($organizationalStructure->approval_file);
            }

            $organizationalStructure->delete();

            return redirect()->route('organizational-structures.index')
                ->with('success', 'Estructura organizacional eliminada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al eliminar estructura organizacional: ' . $e->getMessage());

            return back()->with('error', 'No se pudo eliminar la estructura organizacional. Puede estar en uso.');
        }
    }
}