<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RepresentationReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/artists/{id}', [ArtistController::class, 'show'])
    ->where('id','[0-9]+')->name('artist.show');
Route::get('/artists/edit/{id}', [ArtistController::class, 'edit'])->name('artist.edit');
Route::put('/artists/{id}', [ArtistController::class, 'update'])->name('artist.update');
Route::get('/artists/create', [ArtistController::class, 'create'])->name('artist.create');
Route::post('/artists', [ArtistController::class, 'store'])->name('artist.store');
Route::delete('/artist/{id}', [ArtistController::class, 'destroy'])
	->where('id', '[0-9]+')->name('artist.delete');

Route::get('/types', [TypeController::class, 'index'])->name('type.index');
Route::get('/types/{id}', [TypeController::class, 'show'])->name('type.show');
Route::get('/types/edit/{id}', [TypeController::class, 'edit'])->name('type.edit');
Route::put('/types/{id}', [TypeController::class, 'update'])->name('type.update');

Route::get('/shows', [ShowController::class, 'index'])->name('show.index');
Route::get('/shows/{id}', [ShowController::class, 'show'])->name('show.show');

Route::get('/locations', [LocationController::class, 'index'])->name('location.index');
Route::get('/locations/{id}', [LocationController::class, 'show'])
    ->where('id','[0-9]+')->name('location.show');

Route::get('/reservations', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])
    ->where('id','[0-9]+')->name('reservation.show');

Route::get('/representation-reservations', [RepresentationReservationController::class, 'index'])->name('representation_reservation.index');
Route::get('/representation-reservations/{id}', [RepresentationReservationController::class, 'show'])
    ->where('id','[0-9]+')->name('representation_reservation.show');