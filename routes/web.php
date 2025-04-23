<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/artists/{id}', [ArtistController::class, 'show'])->name('artist.show');
Route::get('/artists/edit/{id}', [ArtistController::class, 'edit'])->name('artist.edit');
Route::put('/artists/{id}', [ArtistController::class, 'update'])->name('artist.update');

Route::get('/types', [TypeController::class, 'index'])->name('type.index');
Route::get('/types/{id}', [TypeController::class, 'show'])->name('type.show');
Route::get('/types/edit/{id}', [TypeController::class, 'edit'])->name('type.edit');
Route::put('/types/{id}', [TypeController::class, 'update'])->name('type.update');