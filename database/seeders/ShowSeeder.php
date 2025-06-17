<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Show;

class ShowSeeder extends Seeder
{
    public function run()
    {
        Show::create([
            'slug' => 'romeo-juliette',
            'title' => 'Roméo et Juliette',
            'description' => 'Deux ados, trois échanges, un mariage, cinq morts. Une pub tragique pour l’amour instantané, écrit avant l’invention du cerveau préfrontal.',
            'poster_url' => '#',
            'duration' => 120,
            'created_in' => 2003,
            'location_id' => 1,
            'bookable' => true,
        ]);

        Show::create([
            'slug' => 'cyrano-bergerac',
            'title' => 'Cyrano de Bergerac',
            'description' => 'Un poète guerrier au nez intersidéral préfère écrire des lettres d’amour pour un autre plutôt que d’utiliser son propre charisme, parce que c’est plus noble de souffrir en alexandrins.',
            'poster_url' => '#',
            'duration' => 135,
            'created_in' => 2010,
            'location_id' => 2,
            'bookable' => true,
        ]);

        Show::create([
            'slug' => 'moliere-avare',
            'title' => 'L’Avare de Molière',
            'description' => 'Il cache son argent, surveille ses enfants, soupçonne tout le monde et finit ruiné, mais sans jamais sortir son portefeuille.',
            'poster_url' => '#',
            'duration' => 110,
            'created_in' => 2017,
            'location_id' => 3,
            'bookable' => false,
        ]);
    }
}