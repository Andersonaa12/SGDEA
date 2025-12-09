<?php
namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Subsection;
use App\Models\Structure\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubsectionController extends Controller
{
    public function index()
    {
        $subsections = Subsection::with('section', 'creator', 'updater')->latest()->paginate(10);
        return view('structure.subsections.index', compact('subsections'));
    }

    public function create()
    {
        $sections = Section::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('structure.subsections.create', compact('sections', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'code' => 'required|string|max:50|unique:subsections,code',
            'name' => 'required|string|max:255',
            'physical_location' => 'nullable|string|max:255',
        ], [
            'section_id.required' => 'Debe seleccionar una sección.',
            'code.unique' => 'Ya existe una subsección con este código.',
        ]);

        try {
            $subsection = new Subsection();

            $subsection->section_id = $validated['section_id'];
            $subsection->code = strtoupper(trim($validated['code']));
            $subsection->name = trim($validated['name']);
            $subsection->physical_location = $validated['physical_location'];
            $subsection->created_by = Auth::id();
            $subsection->updated_by = Auth::id();

            $subsection->save();

            return redirect()->route('subsections.index')
                ->with('success', 'Subsección creada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear subsección: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear la subsección.');
        }
    }

    public function show($id)
    {
        $subsection = Subsection::with(['section', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        return view('structure.subsections.show', compact('subsection'));
    }

    public function edit($id)
    {
        $sections = Section::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $subsection = Subsection::with(['section', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

        return view('structure.subsections.edit', compact('subsection', 'sections', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'physical_location' => 'nullable|string|max:255',
        ], [
            'code.unique' => 'Ya existe otra subsección con este código.',
        ]);

        try {
            $subsection = Subsection::findOrFail($id);

            $subsection->section_id = $validated['section_id'];
            $subsection->code = strtoupper(trim($validated['code']));
            $subsection->name = trim($validated['name']);
            $subsection->physical_location = $validated['physical_location'];
            $subsection->updated_by = Auth::id();

            $subsection->save();

            return redirect()->route('subsections.index')
                ->with('success', 'Subsección actualizada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar subsección: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar la subsección.');
        }
    }

    public function destroy($id)
    {
        try {
            $subsection = Subsection::findOrFail($id);
            $subsection->delete();

            return redirect()->route('subsections.index')
                ->with('success', 'Subsección eliminada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al eliminar subsección: ' . $e->getMessage());

            return back()->with('error', 'No se pudo eliminar la subsección. Puede estar en uso.');
        }
    }
}