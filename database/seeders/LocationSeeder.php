<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'slug' => 'theatre-central',
            'designation' => 'Théâtre Central',
            'address' => 'Rue du Théâtre 1',
            'locality_postal_code' => '1000',
            'website' => 'https://theatrecentral.be',
            'phone' => '021234567',
        ]);

        Location::create([
            'slug' => 'theatre-memoire',
            'designation' => 'Théâtre de la Mémoire',
            'address' => 'Rue des Réminiscences 42',
            'locality_postal_code' => '1000',
            'website' => 'https://memoire.theatre.be',
            'phone' => '021234568',
        ]);
    }
}