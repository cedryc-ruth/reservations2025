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
            'seats' => 2,
        ]);

        RepresentationReservation::create([
            'representation_id' => 2,
            'reservation_id' => 2,
            'seats' => 1,
        ]);

        RepresentationReservation::create([
            'representation_id' => 3,
            'reservation_id' => 3,
            'seats' => 3,
        ]);
    }
}