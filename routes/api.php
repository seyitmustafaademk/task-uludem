<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;

Route::prefix('/')->middleware('auth:sanctum')->group(function () {
    Route::prefix('/auth')->name('auth.')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register')->withoutMiddleware('auth:sanctum');
        Route::post('/login', [AuthController::class, 'login'])->name('login')->withoutMiddleware('auth:sanctum');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::prefix('/note')->name('notes.')->group(function () {
        Route::get('/', [NoteController::class, 'show'])->name('show');
        Route::post('/', [NoteController::class, 'show'])->name('show');
        Route::get('/{id}', [NoteController::class, 'show'])->name('show');
        Route::put('/{id}', [NoteController::class, 'update'])->name('update');
        Route::delete('/{id}', [NoteController::class, 'destroy'])->name('destroy');
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});


