<?php

namespace App\Http\Controllers\Trd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Trd\Subserie;
use App\Models\Trd\Serie;

class SubserieController extends Controller
{
    public function index()
    {
        $subseries = Subserie::with('serie', 'creator', 'updater')
            ->latest()
            ->paginate(10);

        return view('trd.subseries.index', compact('subseries'));
    }

    public function create()
    {
        $series = Serie::orderBy('name')->get();
        return view('trd.subseries.create', compact('series'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serie_id' => 'required|exists:series,id',
            'code' => 'required|string|max:50|unique:subseries,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'serie_id.required' => 'Debe seleccionar una serie.',
            'serie_id.exists' => 'La serie seleccionada no es válida.',
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Ya existe una subserie con este código.',
            'name.required' => 'El nombre es obligatorio.',
            'description.max'   => 'La descripción no puede exceder los 1000 caracteres.',
        ]);

        try {
            $subserie = new Subserie();

            $subserie->serie_id = $validated['serie_id'];
            $subserie->code = strtoupper(trim($validated['code']));
            $subserie->name = trim($validated['name']);
            $subserie->description = $validated['description'];
            $subserie->created_by = Auth::id();
            $subserie->updated_by = Auth::id();

            $subserie->save();

            return redirect()->route('subseries.index')
                ->with('success', 'Subserie creada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear subserie: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear la subserie.');
        }
    }

    public function show( $id)
    {
        $subserie = SubSerie::with(['serie', 'documentTypes', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        return view('trd.subseries.show', compact('subserie'));
    }

    public function edit($id)
    {
        $series = Serie::orderBy('name')->get();
         $subserie = SubSerie::with(['serie', 'documentTypes', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        return view('trd.subseries.edit', compact('subserie', 'series'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'serie_id' => 'required|exists:series,id',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'serie_id.required' => 'Debe seleccionar una serie.',
            'serie_id.exists' => 'La serie seleccionada no es válida.',
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Ya existe otra subserie con este código.',
            'name.required' => 'El nombre es obligatorio.',
            'description.max' => 'La descripción no puede exceder los 1000 caracteres.',
        ]);

        try {
            $subserie = SubSerie::with(['serie', 'documentTypes', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

            $subserie->serie_id = $validated['serie_id'];
            $subserie->code = strtoupper(trim($validated['code']));
            $subserie->name = trim($validated['name']);
            $subserie->description = $validated['description'];
            $subserie->updated_by  = Auth::id();

            $subserie->save();

            return redirect()->route('subseries.index')
                ->with('success', 'Subserie actualizada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar subserie: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar la subserie.');
        }
    }

    public function destroy($id)
    {
        try {
            $subserie = SubSerie::with(['serie', 'documentTypes', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

            $subserie->delete();

            return redirect()->route('subseries.index')
                ->with('success', 'Subserie eliminada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al eliminar subserie: ' . $e->getMessage());

            return back()
                ->with('error', 'No se pudo eliminar la subserie. Es posible que tenga documentos asociados.');
        }
    }
}