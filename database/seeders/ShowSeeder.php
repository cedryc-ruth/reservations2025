<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Show;
use App\Models\Tag;

class ShowSeeder extends Seeder
{
    public function run(): void
    {
        // Crée les tags si non présents
        $comedy  = Tag::firstOrCreate(['tag' => 'Comédie']);
        $drama   = Tag::firstOrCreate(['tag' => 'Drame']);
        $family  = Tag::firstOrCreate(['tag' => 'Famille']);
        $classic = Tag::firstOrCreate(['tag' => 'Classique']);

        $shows = [
            [
                'data' => [
                    'title' => 'Impro Party',
                    'slug' => 'impro-party',
                    'poster_url' => 'https://via.placeholder.com/150',
                    'duration' => 90,
                    'created_in' => 2023,
                    'location_id' => 1,
                    'bookable' => true,
                    'description' => 'Improvisation délirante avec le public.'
                ],
                'tags' => [$comedy->id]
            ],
            [
                'data' => [
                    'title' => 'La Tragédie du Temps',
                    'slug' => 'la-tragedie-du-temps',
                    'poster_url' => 'https://via.placeholder.com/150',
                    'duration' => 110,
                    'created_in' => 2021,
                    'location_id' => 2,
                    'bookable' => true,
                    'description' => 'Une fresque poétique sur le passage du temps et les souvenirs oubliés.'
                ],
                'tags' => [$drama->id]
            ],
            [
                'data' => [
                    'title' => 'Révolte au Grenier',
                    'slug' => 'revolte-au-grenier',
                    'poster_url' => 'https://via.placeholder.com/150',
                    'duration' => 85,
                    'created_in' => 2020,
                    'location_id' => 2,
                    'bookable' => true,
                    'description' => 'Une comédie familiale où les vieux jouets reprennent vie pour se rebeller.'
                ],
                'tags' => [$family->id]
            ],
            [
                'data' => [
                    'title' => 'Cabaret du Néant',
                    'slug' => 'cabaret-du-neant',
                    'poster_url' => 'https://via.placeholder.com/150',
                    'duration' => 75,
                    'created_in' => 2022,
                    'location_id' => 1,
                    'bookable' => false,
                    'description' => 'Un cabaret macabre mêlant humour noir, illusions et récits lugubres.'
                ],
                'tags' => [$classic->id]
            ]
        ];

        foreach ($shows as $entry) {
            $show = Show::create($entry['data']);
            $show->tags()->attach($entry['tags']);
        }
    }
}