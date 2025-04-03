<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/artists/{id}', [ArtistController::class, 'show'])->name('artist.show');

Route::get('/types', [TypeController::class, 'index'])->name('type.index');
Route::get('/types/{id}', [TypeController::class, 'show'])->name('type.show');