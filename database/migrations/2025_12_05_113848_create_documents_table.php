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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediente_id')->constrained()->onDelete('cascade');
            $table->foreignId('document_type_id')->constrained();
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->string('converted_from')->nullable();
            $table->bigInteger('size');
            $table->date('document_date');
            $table->integer('folio')->nullable();
            $table->boolean('analog')->default(false);
            $table->text('physical_location')->nullable();
            $table->boolean('ocr_applied')->default(false);
            $table->text('ocr_text')->nullable();
            $table->boolean('signed')->default(false);
            $table->string('signature_provider')->nullable();
            $table->json('metadata');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            $table->index('ocr_text', 'fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
