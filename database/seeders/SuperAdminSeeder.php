<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsWithDescriptions = [
            // Módulo: Usuarios
            'users.index' => 'Ver lista de usuarios',
            'users.create' => 'Crear usuario',
            'users.store' => 'Guardar usuario',
            'users.show' => 'Ver detalles de usuario',
            'users.edit' => 'Editar usuario',
            'users.update' => 'Actualizar usuario',
            'users.destroy' => 'Eliminar usuario',
            'users.toggle-active' => 'Activar/desactivar usuario',
            'users.sync.sections' => 'Sincronizar secciones',
            'users.sync.subsections' => 'Sincronizar subsecciones',

            // Módulo: Roles (dentro de users)
            'users.roles.index' => 'Ver lista de roles',
            'users.roles.create' => 'Crear rol',
            'users.roles.store' => 'Guardar rol',
            'users.roles.show' => 'Ver detalles de rol',
            'users.roles.edit' => 'Editar rol',
            'users.roles.update' => 'Actualizar rol',
            'users.roles.destroy' => 'Eliminar rol',
            'users.roles.sync.permissions' => 'Sincronizar permisos en rol',

            // Módulo: Permisos (dentro de users)
            'users.permissions.index' => 'Ver lista de permisos',
            'users.permissions.create' => 'Crear permiso',
            'users.permissions.store' => 'Guardar permiso',
            'users.permissions.show' => 'Ver detalles de permiso',
            'users.permissions.edit' => 'Editar permiso',
            'users.permissions.update' => 'Actualizar permiso',
            'users.permissions.destroy' => 'Eliminar permiso',
        ];

        foreach ($permissionsWithDescriptions as $name => $description) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['description' => $description]
            );
        }

        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super-administrador', 'guard_name' => 'web'],
            ['description' => 'Rol con acceso total al sistema']
        );
        $superAdminRole->syncPermissions(Permission::all());

        $adminRole = Role::firstOrCreate(
            ['name' => 'administrador', 'guard_name' => 'web'],
            ['description' => 'Rol para gestión básica de usuarios y roles']
        );
        $adminPermissions = array_filter(array_keys($permissionsWithDescriptions), function ($perm) {
            return str_starts_with($perm, 'users.') && !str_starts_with($perm, 'users.permissions.');
        });
        $adminRole->syncPermissions($adminPermissions);

        $user = User::find(1);

        if ($user) 
        {
            $user->syncRoles('super-administrador');

            $user->syncPermissions(Permission::all());

            $this->command->info('Usuario ID 1 configurado como super-administrador con todos los permisos y roles asignados.');
        } else {
            $this->command->error('No se encontró usuario con ID 1. Créalo primero (ej: con User::factory() o manualmente).');
        }
    }
}