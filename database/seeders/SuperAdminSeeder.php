<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos para todas las rutas del módulo de usuarios
        $permissions = [
            // Users
            'users.index',
            'users.create',
            'users.store',
            'users.show',
            'users.edit',
            'users.update',
            'users.destroy',
            'users.toggle-active',
            'users.sync.sections',
            'users.sync.subsections',

            // Roles
            'users.roles.index',
            'users.roles.create',
            'users.roles.store',
            'users.roles.show',
            'users.roles.edit',
            'users.roles.update',
            'users.roles.destroy',
            'users.roles.sync.permissions',

            // Permissions
            'users.permissions.index',
            'users.permissions.create',
            'users.permissions.store',
            'users.permissions.show',
            'users.permissions.edit',
            'users.permissions.update',
            'users.permissions.destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear rol super-admin y asignarle TODOS los permisos
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web'
        ]);
        $superAdminRole->syncPermissions(Permission::all());

        // Crear rol admin (opcional, con todos los permisos por ahora; puedes limitarlos)
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        $adminRole->syncPermissions(Permission::all());  // O limita: $adminRole->syncPermissions(['users.index', ...]);

        // Asignar rol y permisos al usuario ID 1
        $user = User::find(1);

        if ($user) {
            // Asignar rol
            $user->syncRoles('super-admin');

            // Asignar permisos directos (para cubrir casos donde uses hasDirectPermission)
            $user->syncPermissions(Permission::all());

            $this->command->info('Usuario ID 1 configurado como super-admin con todos los permisos y roles asignados.');
        } else {
            $this->command->error('No se encontró usuario con ID 1. Créalo primero (ej: con factory o manualmente).');
        }
    }
}