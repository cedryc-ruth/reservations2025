<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Representation;

class RepresentationSeeder extends Seeder
{
    public function run()
    {
        Representation::create([
            'show_id' => 1, // Romeo & Juliette
            'schedule' => '2025-07-01 20:30:00',
            'location_id' => 1,
        ]);
        
        Representation::create([
            'show_id' => 2, // Cyrano de Bergerac
            'schedule' => '2025-07-03 20:30:00',
            'location_id' => 2,
        ]);

        Representation::create([
            'show_id' => 3, // L’Avare de Molière
            'schedule' => '2025-07-05 19:00:00',
            'location_id' => 3,
        ]);
        
    }
}
