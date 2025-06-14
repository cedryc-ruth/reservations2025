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
            'poster_url' => '#',
            'duration' => 120,
            'created_in' => 2003,
            'location_id' => 1,
            'bookable' => true,
        ]);

        Show::create([
            'slug' => 'cyrano-bergerac',
            'title' => 'Cyrano de Bergerac',
            'poster_url' => '#',
            'duration' => 135,
            'created_in' => 2010,
            'location_id' => 2,
            'bookable' => true,
        ]);

        Show::create([
            'slug' => 'moliere-avare',
            'title' => 'L’Avare de Molière',
            'poster_url' => '#',
            'duration' => 110,
            'created_in' => 2017,
            'location_id' => 3,
            'bookable' => false,
        ]);
    }
}