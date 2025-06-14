<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Show;

class ShowSeeder extends Seeder
{
    public function run(): void
    {
        $shows = [
            [
                'slug' => 'bohemian-rhapsody-live',
                'title' => 'Bohemian Rhapsody Live',
                'description' => 'Un hommage époustouflant à Freddie Mercury et Queen.',
                'poster_url' => 'https://example.com/posters/queen.jpg',
                'duration' => 120,
                'created_in' => 2023,
                'location_id' => 1,
                'bookable' => true,
            ],
            [
                'slug' => 'moliere-impro-show',
                'title' => 'Le Molière Impro Show',
                'description' => 'Une revisite moderne et drôle des classiques de Molière.',
                'poster_url' => 'https://example.com/posters/moliere.jpg',
                'duration' => 90,
                'created_in' => 2022,
                'location_id' => 2,
                'bookable' => true,
            ],
            [
                'slug' => 'standup-nights',
                'title' => 'Stand-Up Nights',
                'description' => 'Les meilleurs humoristes francophones réunis sur une même scène.',
                'poster_url' => 'https://example.com/posters/standup.jpg',
                'duration' => 100,
                'created_in' => 2021,
                'location_id' => 1,
                'bookable' => false,
            ],
        ];

        foreach ($shows as $data) {
            // Empêche l'insertion de doublons (basé sur le slug)
            Show::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
