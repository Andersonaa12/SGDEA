<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class migrateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:migrateUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra usuarios desde la base de datos roldanillo_personal.vu_personal a la tabla users de Laravel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $defaultConfig = config('database.connections.mysql');
            $roldanilloConfig = $defaultConfig;
            $roldanilloConfig['database'] = 'roldanillo_personal';
            $roldanilloConfig['charset'] = 'utf8';
            $roldanilloConfig['collation'] = 'utf8_general_ci';
            Config::set('database.connections.roldanillo', $roldanilloConfig);

            DB::purge('roldanillo');

            $oldUsers = DB::connection('roldanillo')
                ->table('vu_personal')
                ->where('per_brand_ID', 38)
                ->where('per_did_ID', '!=', 73)
                ->whereNotNull('per_email')
                ->get();

            $this->info('Encontrados ' . count($oldUsers) . ' registros para migrar.');

            foreach ($oldUsers as $oldUser) {
                // Mapear los campos
                $name = trim(
                    ($oldUser->per_nombre1 ?? '') . ' ' .
                    ($oldUser->per_nombre2 ?? '') . ' ' .
                    ($oldUser->per_apellido1 ?? '') . ' ' .
                    ($oldUser->per_apellido2 ?? '')
                );

                $identification = $oldUser->per_cedula;

                // Email: usar per_email si existe, de lo contrario generar uno temporal único
                $email = $oldUser->per_email;

                // Validar si el email ya existe en la tabla users
                $existingUser = User::where('email', $email)->first();
                if ($existingUser) {
                    if ($existingUser->identification !== $identification) {
                        $this->warn("El email {$email} ya existe para otro usuario (identification: {$existingUser->identification}), saltando usuario {$identification}.");
                        continue;
                    }
                    // Si es el mismo identification, procederá a actualizar
                }

                // Teléfono: preferir per_mobile, fallback a per_telefono
                $phone = $oldUser->per_mobile ?? $oldUser->per_telefono ?? null;

                // Contraseña: establecer una por defecto hashed (cámbiala si necesitas algo específico)
                $password = Hash::make($oldUser->per_password);

                // Posición: per_cargo es int (FK probable), no hay mapeo, lo dejamos como string descriptivo o null
                $position = $oldUser->per_cargo;

                // Activo: basado en per_estado
                $active = TRUE;

                // Section ID: no mapeo directo de per_area_id a section_id, lo dejamos null
                // Si tienes un mapeo, ajústalo aquí
                $section_id = null;

                // Crear o actualizar el usuario (usar updateOrCreate para manejar duplicados por identification)
                User::updateOrCreate(
                    ['identification' => $identification],
                    [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'password' => $password,
                        'section_id' => $section_id,
                        'position' => $position,
                        'active' => $active,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]
                );
            }

            $this->info('Migración completada exitosamente.');
        } catch (\Exception $e) {
            $this->error('Error durante la migración: ' . $e->getMessage());
        }
    }
}