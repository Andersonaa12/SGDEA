<?php

namespace App\Http\Controllers\Expediente;

use App\Http\Controllers\Controller;
use App\Models\Expediente\Expediente;
use App\Models\Expediente\ExpedienteLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpedienteLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // This might not be used directly, as loans are nested under expedientes
        $loans = ExpedienteLoan::with(['expediente', 'user', 'creator'])->paginate(10);
        return view('expediente.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Expediente $expediente)
    {
        $users = User::all();
        return view('expediente.loans.create', compact('expediente', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Expediente $expediente)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'reason' => 'nullable|string',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['expediente_id'] = $expediente->id;
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $loan = ExpedienteLoan::create($validated);

        return redirect()->route('expedientes.show', $expediente)->with('success', 'Préstamo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpedienteLoan $loan)
    {
        $loan->load(['expediente', 'user', 'creator', 'updater']);
        return view('expediente.loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpedienteLoan $loan)
    {
        $users = User::all();
        return view('expediente.loans.edit', compact('loan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpedienteLoan $loan)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'reason' => 'nullable|string',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['updated_by'] = Auth::id();

        $loan->update($validated);

        return redirect()->route('loans.show', $loan)->with('success', 'Préstamo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpedienteLoan $loan)
    {
        $loan->delete();
        return redirect()->route('expedientes.show', $loan->expediente_id)->with('success', 'Préstamo eliminado exitosamente.');
    }
}