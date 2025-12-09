<?php

use App\Http\Controllers\Expediente\ExpedienteController;
use App\Http\Controllers\Expediente\DocumentController;
use App\Http\Controllers\Expediente\ExpedienteLoanController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('expedientes', ExpedienteController::class);

    // Rutas para Documentos relacionados con Expedientes (nested resource)
    Route::resource('expedientes.documents', DocumentController::class)->shallow();

    // Rutas para Préstamos de Expedientes (nested resource)
    Route::resource('expedientes.loans', ExpedienteLoanController::class)->shallow();

    // Ruta adicional para ver historial de un expediente
    Route::get('expedientes/{expediente}/history', [ExpedienteController::class, 'history'])->name('expedientes.history');
});
