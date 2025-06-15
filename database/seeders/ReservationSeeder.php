<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        Reservation::create([
            'user_id' => 1,
            'booking_date' => now(),
            'status' => 'confirmée',
        ]);

        Reservation::create([
            'user_id' => 2,
            'booking_date' => now()->subDays(1),
            'status' => 'en attente',
        ]);

        Reservation::create([
            'user_id' => 3,
            'booking_date' => now()->subDays(2),
            'status' => 'annulée',
        ]);
    }
}