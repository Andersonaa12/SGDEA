<?php

namespace App\Http\Controllers\Trd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Trd\Serie;
use App\Models\Trd\Trd;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::with('trd', 'creator', 'updater')
            ->latest()
            ->paginate(10);

        return view('trd.series.index', compact('series'));
    }

    public function create()
    {
        $trds = Trd::active()->orderBy('version', 'desc')->get();
        return view('trd.series.create', compact('trds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trd_id' => 'required|exists:trds,id',
            'code' => 'required|string|max:20|unique:series,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'retention_management_years'=> 'required|integer|min:0|max:99',
            'retention_central_years' => 'required|integer|min:0|max:99',
            'final_disposition' => 'required|in:CT,E,S,M',
            'disposition_procedure' => 'nullable|string|max:2000',
        ], [
            'trd_id.required' => 'Debe seleccionar una TRD activa.',
            'trd_id.exists' => 'La TRD seleccionada no existe.',
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Ya existe una serie con este código.',
            'code.max' => 'El código no puede tener más de 20 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'retention_management_years.required' => 'Los años de gestión son obligatorios.',
            'retention_management_years.max'       => 'Máximo 99 años en gestión.',
            'retention_central_years.required'     => 'Los años en central son obligatorios.',
            'final_disposition.required' => 'Debe seleccionar una disposición final.',
            'final_disposition.in' => 'Disposición final no válida.',
        ]);

        try {
            $serie = new Serie();

            $serie->trd_id = $validated['trd_id'];
            $serie->code = strtoupper(trim($validated['code']));
            $serie->name = trim($validated['name']);
            $serie->description = $validated['description'];
            $serie->retention_management_years= $validated['retention_management_years'];
            $serie->retention_central_years = $validated['retention_central_years'];
            $serie->final_disposition = $validated['final_disposition'];
            $serie->disposition_procedure = $validated['disposition_procedure'];
            $serie->created_by = Auth::id();
            $serie->updated_by = Auth::id();

            $serie->save();

            return redirect()->route('series.index')
                ->with('success', 'Serie creada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear serie: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear la serie. Inténtalo de nuevo.');
        }
    }

    public function show($id)
    {
        $serie = Serie::with(['trd', 'subseries', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

        return view('trd.series.show', compact('serie'));
    }

    public function edit($id)
    {
        $trds = Trd::active()->orderBy('version', 'desc')->get();
        $serie = Serie::with(['trd', 'subseries', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        return view('trd.series.edit', compact('serie', 'trds'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'trd_id' => 'required|exists:trds,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'retention_management_years'=> 'required|integer|min:0|max:99',
            'retention_central_years' => 'required|integer|min:0|max:99',
            'final_disposition' => 'required|in:CT,E,S,M',
            'disposition_procedure' => 'nullable|string|max:2000',
        ], [
            'trd_id.required' => 'Debe seleccionar una TRD activa.',
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Ya existe otra serie con este código.',
            'name.required' => 'El nombre es obligatorio.',
            'final_disposition.in' => 'Disposición final no válida.',
        ]);
        $serie = Serie::with(['trd', 'subseries', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);
        try {
            $serie->trd_id = $validated['trd_id'];
            $serie->code = strtoupper(trim($validated['code']));
            $serie->name = trim($validated['name']);
            $serie->description = $validated['description'];
            $serie->retention_management_years = $validated['retention_management_years'];
            $serie->retention_central_years = $validated['retention_central_years'];
            $serie->final_disposition = $validated['final_disposition'];
            $serie->disposition_procedure = $validated['disposition_procedure'];
            $serie->updated_by = Auth::id();

            $serie->save();

            return redirect()->route('series.index')
                ->with('success', 'Serie actualizada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar serie: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar la serie.');
        }
    }

    public function destroy(Serie $id)
    {
        try {
            $serie = Serie::with(['trd', 'subseries', 'creator', 'updater'])
                    ->withTrashed()
                    ->findOrFail($id);

            $serie->delete();

            return redirect()->route('series.index')
                ->with('success', 'Serie eliminada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al eliminar serie: ' . $e->getMessage());

            return back()
                ->with('error', 'No se pudo eliminar la serie. Es posible que tenga subseries o documentos asociados.');
        }
    }
}