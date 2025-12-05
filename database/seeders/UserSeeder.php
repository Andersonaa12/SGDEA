<?php

// database/seeders/UserSeeder.php
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Roles y Permisos (Spatie)
        $permissions = [
            'manage:structures', 'manage:sections', 'manage:trd', 'manage:series',
            'create:expediente', 'edit:expediente', 'view:expediente', 'loan:expediente',
            'upload:document', 'search:advanced', 'manage:workflow', 'generate:reports',
            'view:audit', 'manage:config'
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $archivistRole = Role::firstOrCreate(['name' => 'archivist']);
        $archivistRole->givePermissionTo(['create:expediente', 'edit:expediente', 'upload:document', 'loan:expediente', 'generate:reports']);

        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);
        $viewerRole->givePermissionTo(['view:expediente', 'search:advanced']);

        // Usuarios
        $admin = User::create([
            'name' => 'Admin SGDEA',
            'email' => 'admin@sgdea.co',
            'password' => bcrypt('password'),
            'section_id' => 1, // Asume seeder previo para sections
            'position' => 'Administrador',
        ]);
        $admin->assignRole('admin');

        // 5 archivistas
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Archivista $i",
                'email' => "archivista$i@sgdea.co",
                'password' => bcrypt('password'),
                'section_id' => 1,
                'position' => 'Archivista',
            ]);
            $user->assignRole('archivist');
        }

        // Datos adicionales: Estructura de ejemplo
        $structure = \App\Models\OrganizationalStructure::create([
            'version' => 'v1.0',
            'start_date' => now(),
            'active' => true,
        ]);

        $section = \App\Models\Section::create([
            'structure_id' => $structure->id,
            'code' => 'SEC001',
            'name' => 'Sección Principal',
            'responsible_user_id' => $admin->id,
        ]);

    }
}

// database/seeders/DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}