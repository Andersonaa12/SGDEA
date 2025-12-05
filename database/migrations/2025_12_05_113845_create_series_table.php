<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('trd_id');
            
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('retention_management_years'); 
            $table->integer('retention_central_years');
            $table->enum('final_disposition', ['CT', 'E', 'S', 'M']); 
            $table->text('disposition_procedure')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('series', function (Blueprint $table) {
            $table->foreign('trd_id')
                  ->references('id')
                  ->on('trds')
                  ->onDelete('cascade');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('updated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropForeign(['trd_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        
        Schema::dropIfExists('series');
    }
};