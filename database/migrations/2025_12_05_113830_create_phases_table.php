<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->integer('preservation_years')->nullable();
            $table->boolean('active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Índices adicionales (además del unique en code)
            $table->index('order');
            $table->index('active');
        });

        // Seed de las fases
        $phases = [
            [
                'code'               => 'MGMT',
                'name'               => 'Tramitación / Gestión',
                'order'              => 10,
                'preservation_years' => 5,
                'active'             => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'code'               => 'CENT',
                'name'               => 'Archivo Central',
                'order'              => 20,
                'preservation_years' => 10,
                'active'             => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'code'               => 'HIST',
                'name'               => 'Archivo Histórico',
                'order'              => 30,
                'preservation_years' => null,
                'active'             => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ];

        DB::table('phases')->insert($phases);
    }

    public function down(): void
    {
        Schema::dropIfExists('phases');
    }
};