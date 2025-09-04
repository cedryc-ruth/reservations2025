<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Show;

class ShowSeeder extends Seeder
{
    public function run()
    {
        if (!Show::where('slug', 'romeo-juliette')->exists()) {
        Show::create([
            'slug' => 'romeo-juliette',
            'title' => 'Roméo et Juliette',
            'description' => 'Deux ados, trois échanges, un mariage, cinq morts. Une pub tragique pour l’amour instantané, écrit avant l’invention du cerveau préfrontal.',
            'poster_url' => 'romeojuliet.jpg',
            'duration' => 120,
            'created_in' => 2003,
            'location_id' => 1,
            'bookable' => true,
        ]);
    }

        if (!Show::where('slug', 'cyrano-bergerac')->exists()) {
        Show::create([
            'slug' => 'cyrano-bergerac',
            'title' => 'Cyrano de Bergerac',
            'description' => 'Un poète guerrier au nez intersidéral préfère écrire des lettres d’amour pour un autre plutôt que d’utiliser son propre charisme, parce que c’est plus noble de souffrir en alexandrins.',
            'poster_url' => 'cyrano.jpg',
            'duration' => 135,
            'created_in' => 2010,
            'location_id' => 2,
            'bookable' => true,
        ]);
    }
    if (!Show::where('slug', 'moliere-avare')->exists()) {
        Show::create([
            'slug' => 'moliere-avare',
            'title' => 'L\'Avare de Molière',
            'description' => 'Il cache son argent, surveille ses enfants, soupçonne tout le monde et finit ruiné, mais sans jamais sortir son portefeuille.',
            'poster_url' => 'lavare.jpg',
            'duration' => 110,
            'created_in' => 2017,
            'location_id' => 3,
            'bookable' => false,
        ]);
        }

        // 6 nouveaux spectacles aléatoires
        if (!Show::where('slug', 'le-cirque-des-reves')->exists()) {
            Show::create([
                'slug' => 'le-cirque-des-reves',
                'title' => 'Le Cirque des Rêves',
                'description' => 'Un spectacle magique où les acrobates volent entre les étoiles et les clowns racontent des histoires qui font pleurer de rire. Une ode à l\'enfance et à l\'imagination sans limites.',
                'poster_url' => 'no-poster.png',
                'duration' => 95,
                'created_in' => 2022,
                'location_id' => 1,
                'bookable' => true,
            ]);
        }

        if (!Show::where('slug', 'symphonie-electrique')->exists()) {
            Show::create([
                'slug' => 'symphonie-electrique',
                'title' => 'Symphonie Électrique',
                'description' => 'Un mélange explosif de musique classique et électronique. Les violons rencontrent les synthétiseurs dans une fusion audacieuse qui redéfinit les frontières musicales.',
                'poster_url' => 'no-poster.png',
                'duration' => 85,
                'created_in' => 2023,
                'location_id' => 2,
                'bookable' => true,
            ]);
        }

        if (!Show::where('slug', 'les-memoires-dun-robot')->exists()) {
            Show::create([
                'slug' => 'les-memoires-dun-robot',
                'title' => 'Les Mémoires d\'un Robot',
                'description' => 'Dans un futur proche, un robot développe des émotions et questionne sa propre existence. Une réflexion poétique sur l\'humanité et la technologie.',
                'poster_url' => 'no-poster.png',
                'duration' => 105,
                'created_in' => 2024,
                'location_id' => 3,
                'bookable' => true,
            ]);
        }

        if (!Show::where('slug', 'cafe-de-nuit')->exists()) {
            Show::create([
                'slug' => 'cafe-de-nuit',
                'title' => 'Café de Nuit',
                'description' => 'Dans un petit café parisien, les clients se croisent, se racontent leurs histoires et partagent leurs secrets. Un spectacle intimiste sur la solitude urbaine et les rencontres inattendues.',
                'poster_url' => 'no-poster.png',
                'duration' => 75,
                'created_in' => 2021,
                'location_id' => 1,
                'bookable' => true,
            ]);
        }

        if (!Show::where('slug', 'le-jardin-des-delices')->exists()) {
            Show::create([
                'slug' => 'le-jardin-des-delices',
                'title' => 'Le Jardin des Délices',
                'description' => 'Inspiré de l\'œuvre de Jérôme Bosch, ce spectacle visuel transporte le public dans un monde onirique peuplé de créatures fantastiques et de paysages surréalistes.',
                'poster_url' => 'no-poster.png',
                'duration' => 120,
                'created_in' => 2020,
                'location_id' => 2,
                'bookable' => false,
            ]);
        }

        if (!Show::where('slug', 'chroniques-martiennes')->exists()) {
            Show::create([
                'slug' => 'chroniques-martiennes',
                'title' => 'Chroniques Martiennes',
                'description' => 'Une adaptation théâtrale du roman de Ray Bradbury. L\'histoire de la colonisation de Mars vue à travers les yeux des premiers colons terriens.',
                'poster_url' => 'no-poster.png',
                'duration' => 140,
                'created_in' => 2019,
                'location_id' => 3,
                'bookable' => true,
            ]);
        }
    }
}