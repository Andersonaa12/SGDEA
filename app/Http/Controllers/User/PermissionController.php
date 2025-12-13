<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        dd(
        'Usuario autenticado: ' . Auth::id(),
        'Roles en sesión: ' . Auth::user()->getRoleNames()->toArray(),
        'Tiene super-admin: ' . (Auth::user()->hasRole('super-admin') ? 'SÍ' : 'NO')
    );
        $permissions = Permission::latest()->paginate(10);
        return view('users.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('users.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.unique' => 'Ya existe un permiso con este nombre.',
        ]);

        try {
            Permission::create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? 'web',
            ]);

            return redirect()->route('users.permissions.index')
                ->with('success', 'Permiso creado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear permiso: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear el permiso.');
        }
    }

    public function show(Permission $permission)
    {
        return view('users.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('users.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permission->id)],
            'guard_name' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.unique' => 'Ya existe un permiso con este nombre.',
        ]);

        try {
            $permission->name = $validated['name'];
            $permission->guard_name = $validated['guard_name'] ?? 'web';
            $permission->save();

            return redirect()->route('users.permissions.index')
                ->with('success', 'Permiso actualizado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar permiso: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar el permiso.');
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return redirect()->route('users.permissions.index')
                ->with('success', 'Permiso eliminado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar el permiso. Puede estar en uso.');
        }
    }
}