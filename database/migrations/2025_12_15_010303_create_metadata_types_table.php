<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metadata_types', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique();
            $table->string('name');
            $table->string('input_type')->default('text');
            $table->json('options')->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        DB::table('metadata_types')->insert([
            [
                'key'         => 'category',
                'name'        => 'Categoría',
                'input_type'  => 'select',
                'options'     => json_encode(['Administrativo', 'Contractual', 'Disciplinario', 'Financiero', 'Otros']),
                'required'    => true,
                'order'       => 10,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'retention',
                'name'        => 'Tiempo de Retención (años)',
                'input_type'  => 'number',
                'options'     => null,
                'required'    => false,
                'order'       => 20,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'access_level',
                'name'        => 'Nivel de Acceso',
                'input_type'  => 'select',
                'options'     => json_encode(['Público', 'Restringido', 'Confidencial']),
                'required'    => true,
                'order'       => 30,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'priority',
                'name'        => 'Prioridad',
                'input_type'  => 'select',
                'options'     => json_encode(['Baja', 'Media', 'Alta', 'Urgente']),
                'required'    => true,
                'order'       => 40,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'status',
                'name'        => 'Estado Interno',
                'input_type'  => 'select',
                'options'     => json_encode(['Activo', 'En Revisión', 'Cerrado', 'Archivado']),
                'required'    => false,
                'order'       => 50,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('metadata_types');
    }
};