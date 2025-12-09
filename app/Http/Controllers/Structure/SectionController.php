<?php
namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Section;
use App\Models\Structure\OrganizationalStructure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('structure', 'responsible', 'creator', 'updater')->latest()->paginate(10);
        return view('structure.sections.index', compact('sections'));
    }

    public function create()
    {
        $structures = OrganizationalStructure::active()->get();
        $users = User::orderBy('name')->get();
        return view('structure.sections.create', compact('structures', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'structure_id' => 'required|exists:organizational_structures,id',
            'code' => 'required|string|max:50|unique:sections,code',
            'name' => 'required|string|max:255',
            'physical_location' => 'nullable|string|max:255',
            'responsible_user_id' => 'nullable|exists:users,id',
        ], [
            'structure_id.required' => 'Debe seleccionar una estructura organizacional.',
            'code.unique' => 'Ya existe una sección con este código.',
        ]);

        try {
            $section = new Section();

            $section->structure_id = $validated['structure_id'];
            $section->code = strtoupper(trim($validated['code']));
            $section->name = trim($validated['name']);
            $section->physical_location = $validated['physical_location'];
            $section->responsible_user_id = $validated['responsible_user_id'];
            $section->created_by = Auth::id();
            $section->updated_by = Auth::id();

            $section->save();

            return redirect()->route('sections.index')
                ->with('success', 'Sección creada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear sección: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear la sección.');
        }
    }

    public function show($id)
    {
        $section = Section::with(['structure', 'responsible', 'subsections', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        return view('structure.sections.show', compact('section'));
    }

    public function edit($id)
    {
        $structures = OrganizationalStructure::active()->get();
        $users = User::orderBy('name')->get();
        $section = Section::with(['structure', 'responsible', 'subsections', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

        return view('structure.sections.edit', compact('section', 'structures', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'structure_id' => 'required|exists:organizational_structures,id',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'physical_location' => 'nullable|string|max:255',
            'responsible_user_id' => 'nullable|exists:users,id',
        ], [
            'code.unique' => 'Ya existe otra sección con este código.',
        ]);

        try {
            $section = Section::findOrFail($id);

            $section->structure_id = $validated['structure_id'];
            $section->code = strtoupper(trim($validated['code']));
            $section->name = trim($validated['name']);
            $section->physical_location = $validated['physical_location'];
            $section->responsible_user_id = $validated['responsible_user_id'];
            $section->updated_by = Auth::id();

            $section->save();

            return redirect()->route('sections.index')
                ->with('success', 'Sección actualizada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar sección: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar la sección.');
        }
    }

    public function destroy($id)
    {
        try {
            $section = Section::findOrFail($id);
            $section->delete();

            return redirect()->route('sections.index')
                ->with('success', 'Sección eliminada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al eliminar sección: ' . $e->getMessage());

            return back()->with('error', 'No se pudo eliminar la sección. Puede estar en uso.');
        }
    }
}