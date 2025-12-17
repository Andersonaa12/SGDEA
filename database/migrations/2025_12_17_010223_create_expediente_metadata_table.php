<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expediente_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediente_id')->constrained('expedientes')->onDelete('cascade');
            $table->foreignId('metadata_type_id')->constrained('metadata_types')->onDelete('restrict');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->index(['expediente_id', 'metadata_type_id']);
            $table->unique(['expediente_id', 'metadata_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediente_metadata');
    }
};