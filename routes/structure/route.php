<?php

use App\Http\Controllers\Structure\OrganizationalStructureController;
use App\Http\Controllers\Structure\SectionController;
use App\Http\Controllers\Structure\SubsectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('structure')->middleware(['auth'])->group(function () {
    // OrganizationalStructur
    Route::resource('organizational-structures', OrganizationalStructureController::class);

    // Section Routes
    Route::resource('sections', SectionController::class);

    // Subsection Routes
    Route::resource('subsections', SubsectionController::class);
});