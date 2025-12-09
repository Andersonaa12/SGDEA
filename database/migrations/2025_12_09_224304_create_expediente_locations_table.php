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
        Schema::create('expediente_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediente_id')->constrained('expedientes')->onDelete('cascade');

            $table->string('box', 50);
            $table->string('folder', 50);
            $table->enum('type', ['Tomo', 'Legajo', 'Libro', 'Otros'])->default('Legajo');
            $table->string('volume_number', 20)->nullable();
            $table->integer('folios_count')->nullable(); 
            $table->text('additional_details')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['box', 'folder']);
            $table->index('type');
            $table->index('expediente_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediente_locations');
    }
};
