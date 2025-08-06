<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::apiResource('notes', NoteController::class)->middleware('auth:sanctum');
Route::controller(NoteController::class)->name('notes.')->group(function () {
    Route::post('notes/restore/{id}', 'restore')->name('restore')->middleware('auth:sanctum');
});
