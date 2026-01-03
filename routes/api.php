<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Structure\Section;
use App\Models\Structure\Subsection;
use App\Models\Trd\Subserie;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/sections', function (Request $request) {
    $structureId = $request->input('structure_id');
    if (!$structureId) {
        return response()->json(['error' => 'structure_id is required'], 400);
    }
    $sections = Section::where('structure_id', $structureId)
                       ->get(['id', 'code', 'name']);
    return response()->json($sections);
});

Route::get('/subsections', function (Request $request) {
    $sectionId = $request->input('section_id');
    if (!$sectionId) {
        return response()->json(['error' => 'section_id is required'], 400);
    }
    $subsections = Subsection::where('section_id', $sectionId)
                             ->get(['id', 'code', 'name']);
    return response()->json($subsections);
});

Route::get('/subseries', function (Request $request) {
    $serieId = $request->input('serie_id');
    if (!$serieId) {
        return response()->json(['error' => 'serie_id is required'], 400);
    }
    $subseries = Subserie::where('serie_id', $serieId)
                         ->get(['id', 'code', 'name']);
    return response()->json($subseries);
});