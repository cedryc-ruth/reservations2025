<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Artist::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            [
                'firstname'=>'Daniel',
                'lastname'=>'Marcelin'
            ],
            [
                'firstname'=>'Philippe',
                'lastname'=>'Laurent'
            ],
            [
                'firstname'=>'Marius',
                'lastname'=>'Von Mayenburg'
            ],
            [
                'firstname'=>'Sophie',
                'lastname'=>'Marceau'
            ],
            [
                'firstname'=>'Jean',
                'lastname'=>'Dujardin'
            ],
            [
                'firstname'=>'Marion',
                'lastname'=>'Cotillard'
            ],
            [
                'firstname'=>'Gérard',
                'lastname'=>'Depardieu'
            ],
            [
                'firstname'=>'Catherine',
                'lastname'=>'Deneuve'
            ],
            [
                'firstname'=>'Vincent',
                'lastname'=>'Cassel'
            ],
            [
                'firstname'=>'Juliette',
                'lastname'=>'Binoche'
            ],
            [
                'firstname'=>'Omar',
                'lastname'=>'Sy'
            ],
            [
                'firstname'=>'Audrey',
                'lastname'=>'Tautou'
            ],
            [
                'firstname'=>'Louis',
                'lastname'=>'Garrel'
            ],
            [
                'firstname'=>'Léa',
                'lastname'=>'Seydoux'
            ],
            [
                'firstname'=>'Mathieu',
                'lastname'=>'Amalric'
            ],
            [
                'firstname'=>'Isabelle',
                'lastname'=>'Huppert'
            ],
            [
                'firstname'=>'Fabrice',
                'lastname'=>'Luchini'
            ],
            [
                'firstname'=>'Karin',
                'lastname'=>'Viard'
            ],
            [
                'firstname'=>'François',
                'lastname'=>'Cluzet'
            ],
            [
                'firstname'=>'Valérie',
                'lastname'=>'Lemercier'
            ],
        ];

        DB::table('artists')->insert($data);
    }
}
