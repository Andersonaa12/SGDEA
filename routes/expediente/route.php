<?php

use App\Http\Controllers\Expediente\ExpedienteController;
use App\Http\Controllers\Expediente\DocumentController;
use App\Http\Controllers\Expediente\ExpedienteLoanController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('expedientes', ExpedienteController::class);

    Route::resource('expedientes.documents', DocumentController::class)->shallow();

    Route::resource('expedientes.loans', ExpedienteLoanController::class)->shallow();

    Route::get('expedientes/{expediente}/history', [ExpedienteController::class, 'history'])->name('expedientes.history');

    Route::patch('expedientes/{expediente}/close', [ExpedienteController::class, 'close'])->name('expedientes.close');

    Route::get('expedientes/{expediente}/documents-list', [DocumentController::class, 'index'])->name('expedientes.documents-list');
    Route::get('expedientes/{expediente}/documents-upload', [DocumentController::class, 'create'])->name('expedientes.documents-upload');
});
