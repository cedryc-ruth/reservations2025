<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Locality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Location::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            [
                'slug'=>'the-art-center',
                'designation'=>'The Art Center',
                'address'=>'10 rue de la Vie',
                'locality_postal_code'=>'1000',  //'locality_id'=>1,
                'website'=>'www.the-art-center.be',
                'phone'=>'+32 04568956',
            ],
            [
                'slug'=>'nowhere-place',
                'designation'=>'Nowhere Place',
                'address'=>'125 avenue du Milieu',
                'locality_postal_code'=>'1050',  //'locality_id'=>1,
                'website'=>'www.nowhere.be',
                'phone'=>'+32 01268989',
            ],
            [
                'slug'=>'ground-zero',
                'designation'=>'Ground Zero',
                'address'=>'23 avenue du Ciel',
                'locality_postal_code'=>'1000',  //'locality_id'=>1,
                'website'=>'',
                'phone'=>'+32 05628956',
            ],
        ];

        DB::table('locations')->insert($data);
    }
}
