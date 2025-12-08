<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Usuario Administrador del sistema
        User::create([
            'name' => 'Administrador SGDEA',
            'identification' => '1000000001',
            'email' => 'admin@sgdea.test',
            'phone' => '3001234567',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => null,
            'position' => 'Administrador del Sistema',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        /* 
        User::create([
            'name' => 'Ana María López',
            'identification' => '12345678',
            'email' => 'jefe.archivo@sgdea.test',
            'phone' => '3109876543',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 1,
            'position' => 'Jefe de Archivo Central',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        User::create([
            'name' => 'Carlos Andrés Ramírez',
            'identification' => '87654321',
            'email' => 'gestion@sgdea.test',
            'phone' => '3205554433',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 2,
            'position' => 'Analista de Gestión Documental',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        User::create([
            'name' => 'Laura Gómez Pérez',
            'identification' => '11223344',
            'email' => 'historico@sgdea.test',
            'phone' => '3157778899',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 3,
            'position' => 'Archivista Histórico',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        User::create([
            'name' => 'Usuario Prueba',
            'identification' => '99999999',
            'email' => 'test@sgdea.test',
            'phone' => '3009998877',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 2,
            'position' => 'Funcionario',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        User::create([
            'name' => 'Ana María López',
            'identification' => '12345678',
            'email' => 'jefe.archivo@sgdea.test',
            'phone' => '3109876543',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 1,
            'position' => 'Jefe de Archivo Central',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        User::create([
            'name' => 'Carlos Andrés Ramírez',
            'identification' => '87654321',
            'email' => 'gestion@sgdea.test',
            'phone' => '3205554433',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 2,
            'position' => 'Analista de Gestión Documental',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        User::create([
            'name' => 'Laura Gómez Pérez',
            'identification' => '11223344',
            'email' => 'historico@sgdea.test',
            'phone' => '3157778899',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 3,
            'position' => 'Archivista Histórico',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        User::create([
            'name' => 'Usuario Prueba',
            'identification' => '99999999',
            'email' => 'test@sgdea.test',
            'phone' => '3009998877',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'section_id' => 2,
            'position' => 'Funcionario',
            'active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]); 
        */
    }
}