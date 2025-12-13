<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Structure\Section;
use App\Models\Structure\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'section', 'creator', 'updater')->latest()->paginate(10);
        return view('users.users.index', compact('users'));
    }

    public function create()
    {
        $sections = Section::all();
        $subsections = Subsection::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.users.create', compact('sections', 'subsections', 'roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identification' => 'required|string|max:50|unique:users,identification',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'section_id' => 'nullable|exists:sections,id',
            'position' => 'nullable|string|max:255',
            'active' => 'sometimes|in:on',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
            'sections' => 'nullable|array',
            'sections.*.section_id' => 'exists:sections,id',
            'sections.*.role_in_section' => 'nullable|string|max:255',
            'subsections' => 'nullable|array',
            'subsections.*.subsection_id' => 'exists:subsections,id',
            'subsections.*.role_in_subsection' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'identification.required' => 'La identificación es obligatoria.',
            'identification.unique' => 'Ya existe un usuario con esta identificación.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Ya existe un usuario con este correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        try {
            $user = new User();

            $user->name = $validated['name'];
            $user->identification = $validated['identification'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'] ?? null;
            $user->password = Hash::make($validated['password']);
            $user->section_id = $validated['section_id'] ?? null;
            $user->position = $validated['position'] ?? null;
            $user->active = $request->has('active');
            $user->created_by = Auth::id();
            $user->updated_by = Auth::id();

            $user->save();

            // Assign roles and permissions
            if (isset($validated['roles'])) {
                $user->syncRoles($validated['roles']);
            }
            if (isset($validated['permissions'])) {
                $user->syncPermissions($validated['permissions']);
            }

            // Sync sections and subsections
            if (isset($validated['sections'])) {
                $sectionsData = [];
                foreach ($validated['sections'] as $section) {
                    $sectionsData[$section['section_id']] = ['role_in_section' => $section['role_in_section'] ?? null];
                }
                $user->sections()->sync($sectionsData);
            }
            if (isset($validated['subsections'])) {
                $subsectionsData = [];
                foreach ($validated['subsections'] as $subsection) {
                    $subsectionsData[$subsection['subsection_id']] = ['role_in_subsection' => $subsection['role_in_subsection'] ?? null];
                }
                $user->subsections()->sync($subsectionsData);
            }

            return redirect()->route('users.index')
                ->with('success', 'Usuario creado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear usuario: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al crear el usuario.');
        }
    }

    public function show(User $user)
    {
        $user->load('roles', 'permissions', 'section', 'sections', 'subsections', 'creator', 'updater');
        return view('users.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $sections = Section::all();
        $subsections = Subsection::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $user->load('roles', 'permissions', 'sections', 'subsections');
        return view('users.users.edit', compact('user', 'sections', 'subsections', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identification' => ['required', 'string', 'max:50', Rule::unique('users', 'identification')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'section_id' => 'nullable|exists:sections,id',
            'position' => 'nullable|string|max:255',
            'active' => 'sometimes|in:on',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
            'sections' => 'nullable|array',
            'sections.*.section_id' => 'exists:sections,id',
            'sections.*.role_in_section' => 'nullable|string|max:255',
            'subsections' => 'nullable|array',
            'subsections.*.subsection_id' => 'exists:subsections,id',
            'subsections.*.role_in_subsection' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'identification.required' => 'La identificación es obligatoria.',
            'identification.unique' => 'Ya existe un usuario con esta identificación.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Ya existe un usuario con este correo.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        try {
            $user->name = $validated['name'];
            $user->identification = $validated['identification'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'] ?? null;
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->section_id = $validated['section_id'] ?? null;
            $user->position = $validated['position'] ?? null;
            $user->active = $request->has('active');
            $user->updated_by = Auth::id();

            $user->save();

            // Sync roles and permissions
            if (isset($validated['roles'])) {
                $user->syncRoles($validated['roles']);
            }
            if (isset($validated['permissions'])) {
                $user->syncPermissions($validated['permissions']);
            }

            // Sync sections and subsections
            if (isset($validated['sections'])) {
                $sectionsData = [];
                foreach ($validated['sections'] as $section) {
                    $sectionsData[$section['section_id']] = ['role_in_section' => $section['role_in_section'] ?? null];
                }
                $user->sections()->sync($sectionsData);
            }
            if (isset($validated['subsections'])) {
                $subsectionsData = [];
                foreach ($validated['subsections'] as $subsection) {
                    $subsectionsData[$subsection['subsection_id']] = ['role_in_subsection' => $subsection['role_in_subsection'] ?? null];
                }
                $user->subsections()->sync($subsectionsData);
            }

            return redirect()->route('users.index')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar usuario: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar el usuario.');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'Usuario eliminado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar el usuario. Puede estar en uso.');
        }
    }

    public function toggleActive(User $user)
    {
        try {
            $user->active = !$user->active;
            $user->updated_by = Auth::id();
            $user->save();

            return redirect()->route('users.index')
                ->with('success', 'Estado del usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al cambiar el estado del usuario.');
        }
    }

    public function syncSections(Request $request, User $user)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.section_id' => 'exists:sections,id',
            'sections.*.role_in_section' => 'nullable|string|max:255',
        ]);

        try {
            $sectionsData = [];
            foreach ($validated['sections'] as $section) {
                $sectionsData[$section['section_id']] = ['role_in_section' => $section['role_in_section'] ?? null];
            }
            $user->sections()->sync($sectionsData);

            return redirect()->back()->with('success', 'Secciones asignadas exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al asignar secciones.');
        }
    }

    public function syncSubsections(Request $request, User $user)
    {
        $validated = $request->validate([
            'subsections' => 'required|array',
            'subsections.*.subsection_id' => 'exists:subsections,id',
            'subsections.*.role_in_subsection' => 'nullable|string|max:255',
        ]);

        try {
            $subsectionsData = [];
            foreach ($validated['subsections'] as $subsection) {
                $subsectionsData[$subsection['subsection_id']] = ['role_in_subsection' => $subsection['role_in_subsection'] ?? null];
            }
            $user->subsections()->sync($subsectionsData);

            return redirect()->back()->with('success', 'Subsecciones asignadas exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al asignar subsecciones.');
        }
    }
}