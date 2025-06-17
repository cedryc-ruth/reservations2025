<?php

use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RepresentationReservationController;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Show;
use App\Models\Representation;
use App\Models\Location;

// Page d'accueil user/frontend
Route::get('/', function () {
    return view('welcome');
});

// Redirection pour éviter "Route [login] not defined"
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// DEBUG PANEL - test des resources filament
Route::get('/debug-panels', function () {
    return Filament::getPanel('admin')->getResources();
});

// ARTISTS
Route::get('/artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/artists/{id}', [ArtistController::class, 'show'])
    ->where('id','[0-9]+')->name('artist.show');
Route::get('/artists/edit/{id}', [ArtistController::class, 'edit'])->name('artist.edit');
Route::put('/artists/{id}', [ArtistController::class, 'update'])->name('artist.update');
Route::get('/artists/create', [ArtistController::class, 'create'])->name('artist.create');
Route::post('/artists', [ArtistController::class, 'store'])->name('artist.store');
Route::delete('/artist/{id}', [ArtistController::class, 'destroy'])
	->where('id', '[0-9]+')->name('artist.delete');

// TYPES
Route::get('/types', [TypeController::class, 'index'])->name('type.index');
Route::get('/types/{id}', [TypeController::class, 'show'])->name('type.show');
Route::get('/types/edit/{id}', [TypeController::class, 'edit'])->name('type.edit');
Route::put('/types/{id}', [TypeController::class, 'update'])->name('type.update');
    // TODO store/create/delete

// SHOWS
Route::get('/shows', [ShowController::class, 'index'])->name('show.index');
Route::get('/shows/{id}', [ShowController::class, 'show'])->name('show.show');
    // TODO edit/create/delete si nécessaire

// LOCATIONS
Route::get('/locations', [LocationController::class, 'index'])->name('location.index');
Route::get('/locations/{id}', [LocationController::class, 'show'])
    ->where('id','[0-9]+')->name('location.show');
    // TODO create/edit/delete/update si nécessaire

// RESERVATIONS
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])
    ->where('id','[0-9]+')->name('reservation.show');
    // TODO create/store/delete si nécessaire

// REPRESENTATION - RESERVATION
Route::get('/representation-reservations', [RepresentationReservationController::class, 'index'])->name('representation_reservation.index');
Route::get('/representation-reservations/{id}', [RepresentationReservationController::class, 'show'])
    ->where('id','[0-9]+')->name('representation_reservation.show');
    // TODO edit/store/delete si nécessaire

// ROUTE D'EXPORT CSV - TOUT RESERVATION - BACKOFFICE
Route::get('/admin/export/all', function () {
    $resources = [
        'USERS' => User::all(),
        'RESERVATIONS' => Reservation::all(),
        'SHOWS' => Show::all(),
        'REPRESENTATIONS' => Representation::all(),
        'LOCATIONS' => Location::all(),
    ];

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="export_complet.csv"',
    ];

    return Response::stream(function () use ($resources) {
        echo "\xEF\xBB\xBF"; // UTF-8 BOM pour Excel

        $handle = fopen('php://output', 'w');

        foreach ($resources as $title => $collection) {
            fputcsv($handle, ["== $title =="]);

            if ($collection->isEmpty()) {
                fputcsv($handle, ['(aucune donnée)']);
                continue;
            }

            // En-têtes dynamiques
            fputcsv($handle, array_keys($collection->first()->getAttributes()), ';');

            foreach ($collection as $item) {
                fputcsv($handle, $item->toArray(), ';');
            }

            // Ligne vide
            fputcsv($handle, ['']);
        }

        fclose($handle);
    }, 200, $headers);
});