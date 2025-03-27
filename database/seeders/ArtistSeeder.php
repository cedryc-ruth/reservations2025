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
        Artist::truncate();

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
        ];

        DB::table('artists')->insert($data);
    }
}
