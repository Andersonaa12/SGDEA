<?php

use App\Http\Controllers\Trd\TrdController;
use App\Http\Controllers\Trd\SerieController;
use App\Http\Controllers\Trd\SubserieController;
use App\Http\Controllers\Trd\DocumentTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('trd')->middleware(['auth'])->group(function () {
    // TRD Routes
    Route::resource('trds', TrdController::class);

    // Serie Routes
    Route::resource('series', SerieController::class);

    // Subserie Routes
    Route::resource('subseries', SubserieController::class);

    // DocumentType Routes
    Route::resource('document-types', DocumentTypeController::class);
});