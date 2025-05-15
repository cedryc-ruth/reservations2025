<?php

namespace Database\Seeders;

use App\Models\Locality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Locality::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            [
                'postal_code'=>'1000',
                'locality'=>'Bruxelles',
            ],
            [
                'postal_code'=>'1040',
                'locality'=>'Etterbeek',
            ],
            [
                'postal_code'=>'1050',
                'locality'=>'Ixelles',
            ],
            [
                'postal_code'=>'1170',
                'locality'=>'Watermael-Boitsfort',
            ],
        ];

        DB::table('localities')->insert($data);
    }
}
