<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_physical')->default(false);
            $table->boolean('is_electronic')->default(false);
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('support_types')->insert([
            [
                'code'          => 'FIS',
                'name'          => 'Físico',
                'description'   => 'Soporte exclusivamente físico (papel, carpeta, etc.)',
                'is_physical'   => true,
                'is_electronic' => false,
                'active'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'code'          => 'ELE',
                'name'          => 'Electrónico',
                'description'   => 'Soporte exclusivamente electrónico (PDF/A, TIFF, etc.)',
                'is_physical'   => false,
                'is_electronic' => true,
                'active'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'code'          => 'AMB',
                'name'          => 'Físico y Electrónico (Ambos)',
                'description'   => 'El expediente tiene soporte físico y su versión digital',
                'is_physical'   => true,
                'is_electronic' => true,
                'active'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('support_types');
    }
};