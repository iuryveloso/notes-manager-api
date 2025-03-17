<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->name('user.')->middleware('auth:sanctum')->group(function () {
    Route::get('user', 'show')->name('show');
    Route::patch('user/update', 'update')->name('update');
    Route::post('user/update/avatar', 'updateAvatar')->name('update.avatar');
    Route::patch('user/update/password', 'updatePassword')->name('update.password');
});

Route::apiResource('todos', TodoController::class)->middleware('auth:sanctum');
Route::controller(TodoController::class)->name('todos.')->middleware('auth:sanctum')->group(function () {
    Route::post('todos/restore/{id}', 'restore')->name('restore');
});
