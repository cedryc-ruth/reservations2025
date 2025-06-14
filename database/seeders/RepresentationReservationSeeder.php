<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepresentationReservation;

class RepresentationReservationSeeder extends Seeder
{
    public function run()
    {
        RepresentationReservation::create([
            'representation_id' => 1,
            'reservation_id' => 1,
            'price_id' => 1,
            'quantity' => 2,
        ]);

        RepresentationReservation::create([
            'representation_id' => 2,
            'reservation_id' => 2,
            'price_id' => 2,
            'quantity' => 1,
        ]);

        RepresentationReservation::create([
            'representation_id' => 3,
            'reservation_id' => 3,
            'price_id' => 1,
            'quantity' => 3,
        ]);
    }
}