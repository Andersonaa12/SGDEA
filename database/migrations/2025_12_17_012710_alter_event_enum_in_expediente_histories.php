<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expediente_histories', function (Blueprint $table) {
            $table->enum('event', [
                'created',
                'updated',
                'deleted',
                'phase_change',
                'close',
                'document_added',
                'loan_added' 
            ])->change();
        });
    }

    public function down(): void
    {
        Schema::table('expediente_histories', function (Blueprint $table) {
            $table->enum('event', ['created', 'updated', 'phase_change', 'close'])->change();
        });
    }
};