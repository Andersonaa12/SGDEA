<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->latest()->paginate(10);
        
        return view('users.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('users.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
        ]);

        try {
            $role = Role::create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? 'web',
            ]);

            if (isset($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }

            return redirect()->route('users.roles.index')
                ->with('success', 'Rol creado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear rol: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear el rol.');
        }
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return view('users.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load('permissions');
        return view('users.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'guard_name' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
        ]);

        try {
            $role->name = $validated['name'];
            $role->guard_name = $validated['guard_name'] ?? 'web';
            $role->save();

            if (isset($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }

            return redirect()->route('users.roles.index')
                ->with('success', 'Rol actualizado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar rol: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar el rol.');
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return redirect()->route('users.roles.index')
                ->with('success', 'Rol eliminado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar el rol. Puede estar en uso.');
        }
    }

    public function syncPermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        try {
            $role->syncPermissions($validated['permissions']);

            return redirect()->back()->with('success', 'Permisos asignados exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al asignar permisos.');
        }
    }
}