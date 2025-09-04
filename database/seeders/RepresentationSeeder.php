<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Representation;

class RepresentationSeeder extends Seeder
{
    public function run()
    {
        // Nettoyer les représentations existantes (sans truncate à cause des contraintes FK)
        Representation::query()->delete();
        
        // Représentations pour Roméo et Juliette (ID: 2)
        Representation::create([
            'show_id' => 2,
            'schedule' => '2025-12-15 20:30:00',
            'location_id' => 1,
        ]);
        
        Representation::create([
            'show_id' => 2,
            'schedule' => '2025-12-22 20:30:00',
            'location_id' => 1,
        ]);
        
        Representation::create([
            'show_id' => 2,
            'schedule' => '2025-12-29 20:30:00',
            'location_id' => 1,
        ]);

        // Représentations pour Cyrano de Bergerac (ID: 3)
        Representation::create([
            'show_id' => 3,
            'schedule' => '2025-12-16 20:30:00',
            'location_id' => 2,
        ]);
        
        Representation::create([
            'show_id' => 3,
            'schedule' => '2025-12-23 20:30:00',
            'location_id' => 2,
        ]);
        
        Representation::create([
            'show_id' => 3,
            'schedule' => '2025-12-30 20:30:00',
            'location_id' => 2,
        ]);

        // Représentations pour L'Avare de Molière (ID: 4)
        Representation::create([
            'show_id' => 4,
            'schedule' => '2025-12-17 19:00:00',
            'location_id' => 3,
        ]);
        
        Representation::create([
            'show_id' => 4,
            'schedule' => '2025-12-24 19:00:00',
            'location_id' => 3,
        ]);

        // Représentations pour Le Cirque des Rêves (ID: 5)
        Representation::create([
            'show_id' => 5,
            'schedule' => '2025-12-18 20:00:00',
            'location_id' => 1,
        ]);
        
        Representation::create([
            'show_id' => 5,
            'schedule' => '2025-12-25 20:00:00',
            'location_id' => 1,
        ]);
        
        Representation::create([
            'show_id' => 5,
            'schedule' => '2026-01-01 20:00:00',
            'location_id' => 1,
        ]);

        // Représentations pour Symphonie Électrique (ID: 6)
        Representation::create([
            'show_id' => 6,
            'schedule' => '2025-12-19 21:00:00',
            'location_id' => 2,
        ]);
        
        Representation::create([
            'show_id' => 6,
            'schedule' => '2025-12-26 21:00:00',
            'location_id' => 2,
        ]);

        // Représentations pour Les Mémoires d'un Robot (ID: 7)
        Representation::create([
            'show_id' => 7,
            'schedule' => '2025-12-20 20:30:00',
            'location_id' => 3,
        ]);
        
        Representation::create([
            'show_id' => 7,
            'schedule' => '2025-12-27 20:30:00',
            'location_id' => 3,
        ]);
        
        Representation::create([
            'show_id' => 7,
            'schedule' => '2026-01-03 20:30:00',
            'location_id' => 3,
        ]);

        // Représentations pour Café de Nuit (ID: 8)
        Representation::create([
            'show_id' => 8,
            'schedule' => '2025-12-21 19:30:00',
            'location_id' => 1,
        ]);
        
        Representation::create([
            'show_id' => 8,
            'schedule' => '2025-12-28 19:30:00',
            'location_id' => 1,
        ]);

        // Représentations pour Le Jardin des Délices (ID: 9)
        Representation::create([
            'show_id' => 9,
            'schedule' => '2025-12-22 20:00:00',
            'location_id' => 2,
        ]);
        
        Representation::create([
            'show_id' => 9,
            'schedule' => '2025-12-29 20:00:00',
            'location_id' => 2,
        ]);

        // Représentations pour Chroniques Martiennes (ID: 10)
        Representation::create([
            'show_id' => 10,
            'schedule' => '2025-12-23 20:30:00',
            'location_id' => 3,
        ]);
        
        Representation::create([
            'show_id' => 10,
            'schedule' => '2025-12-30 20:30:00',
            'location_id' => 3,
        ]);
        
        Representation::create([
            'show_id' => 10,
            'schedule' => '2026-01-06 20:30:00',
            'location_id' => 3,
        ]);
    }
}
