<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RepresentationReservationController;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Show;
use App\Models\Representation;
use App\Models\Location;
use App\Http\Controllers\ReviewController;
use Spatie\Feed\FeedItem;
use Spatie\Feed\Feed;

// Page d'accueil user/frontend
Route::get('/', function () {
    return redirect('/shows');
});

// Redirection login Laravel vers admin login Filament (si utilisé)
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Tableau de bord (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Gestion du profil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

// SHOWS
Route::get('/shows', [ShowController::class, 'index'])->name('show.index');
Route::get('/shows/{id}', [ShowController::class, 'show'])->name('show.show');

// BOOKING (protégé par authentification)
Route::middleware('auth')->group(function () {
    Route::get('/booking/{showId}', [App\Http\Controllers\BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::get('/booking/confirmation/{reservationId}', [App\Http\Controllers\BookingController::class, 'confirmation'])->name('booking.confirmation');
});

// PAYMENT
Route::post('/payment/create', [App\Http\Controllers\PaymentController::class, 'createPaymentSession'])->name('payment.create');
Route::get('/payment/success/{reservation}', [App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel/{reservation}', [App\Http\Controllers\PaymentController::class, 'paymentCancel'])->name('payment.cancel');
Route::post('/payment/webhook', [App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');

// USER RESERVATIONS
Route::middleware('auth')->group(function () {
    Route::get('/my-reservations', [App\Http\Controllers\UserReservationController::class, 'index'])->name('user-reservations.index');
    Route::get('/my-reservations/{id}', [App\Http\Controllers\UserReservationController::class, 'show'])->name('user-reservations.show');
    Route::post('/my-reservations/{id}/cancel', [App\Http\Controllers\UserReservationController::class, 'cancel'])->name('user-reservations.cancel');
    Route::get('/my-reservations/{id}/download-ticket', [App\Http\Controllers\UserReservationController::class, 'downloadTicket'])->name('user-reservations.download-ticket');
});


// LOCATIONS
Route::get('/locations', [LocationController::class, 'index'])->name('location.index');
Route::get('/locations/{id}', [LocationController::class, 'show'])
    ->where('id','[0-9]+')->name('location.show');


//REVIEW 
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');



// RESERVATIONS
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])
    ->where('id','[0-9]+')->name('reservation.show');


// REPRESENTATION - RESERVATION
Route::get('/representation-reservations', [RepresentationReservationController::class, 'index'])->name('representation_reservation.index');
Route::get('/representation-reservations/{id}', [RepresentationReservationController::class, 'show'])
    ->where('id','[0-9]+')->name('representation_reservation.show');

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




function registerCsvExport(string $uri, string $modelClass)
{
    Route::get("/admin/export/$uri", function () use ($uri, $modelClass) {
        $collection = $modelClass::all();

        return Response::stream(function () use ($collection, $uri) {
            echo "\xEF\xBB\xBF"; // UTF-8 BOM pour Excel
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ["== " . strtoupper($uri) . " =="]);
            if ($collection->isEmpty()) {
                fputcsv($handle, ['(aucune donnée)']);
            } else {
                fputcsv($handle, array_keys($collection->first()->getAttributes()), ';');
                foreach ($collection as $item) {
                    fputcsv($handle, $item->toArray(), ';');
                }
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"export_{$uri}.csv\"",
        ]);
    })->name("export.$uri");
}

    // Appels simples
    registerCsvExport('users', \App\Models\User::class);
    registerCsvExport('shows', \App\Models\Show::class);
    registerCsvExport('reviews', \App\Models\Review::class);
    registerCsvExport('reservations', \App\Models\Reservation::class);
    registerCsvExport('representations', \App\Models\Representation::class);
    registerCsvExport('artists', \App\Models\Artist::class);
    registerCsvExport('locations', \App\Models\Location::class);
    registerCsvExport('types', \App\Models\Type::class);

// FLUX RSS
Route::feeds();

require __DIR__.'/auth.php';

