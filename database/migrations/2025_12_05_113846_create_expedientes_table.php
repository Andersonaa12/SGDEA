<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('subject');
            $table->text('detail')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('expedientes');
            $table->foreignId('structure_id')->constrained('organizational_structures')->onDelete('cascade');
            $table->foreignId('section_id')->constrained();
            $table->foreignId('subsection_id')->nullable()->constrained();
            $table->foreignId('serie_id')->constrained();
            $table->foreignId('subserie_id')->constrained();
            $table->foreignId('support_type_id')->constrained('support_types')->comment('FIS = físico, ELE = electrónico, AMB = ambos');
            $table->foreignId('phase_id')->constrained('phases')->default(1)->comment('Fase actual en el ciclo vital del expediente');
            $table->date('opening_date')->useCurrent();
            $table->date('closing_date')->nullable();
            $table->integer('version')->default(1);
            $table->enum('status', ['open', 'closed', 'archived'])->default('open');
            $table->json('metadata')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
