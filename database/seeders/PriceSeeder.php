<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Price::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            [
                'type'=>'normal',
                'price'=>15.90,
                'description'=>'Prix normal adulte.',
                'start_date'=>'2024-01-01',
                'end_date'=>'9999-12-31',
            ],
            [
                'type'=>'enfant',
                'price'=>7.90,
                'description'=>'Tarif enfant <12 ans.',
                'start_date'=>'2020-01-01',
                'end_date'=>'9999-12-31',
            ],
            [
                'type'=>'senior',
                'price'=>12.90,
                'description'=>'Tarif senior 65+ ans.',
                'start_date'=>'2020-01-01',
                'end_date'=>'9999-12-31',
            ],
            [
                'type'=>'etudiant',
                'price'=>10.90,
                'description'=>'Tarif étudiant avec carte.',
                'start_date'=>'2020-01-01',
                'end_date'=>'9999-12-31',
            ],
            [
                'type'=>'groupe',
                'price'=>11.90,
                'description'=>'Tarif groupe 10+ personnes.',
                'start_date'=>'2020-01-01',
                'end_date'=>'9999-12-31',
            ],
            [
                'type'=>'premium',
                'price'=>25.90,
                'description'=>'Place premium avec accès VIP.',
                'start_date'=>'2020-01-01',
                'end_date'=>'9999-12-31',
            ],
        ];

        DB::table('prices')->insert($data);
    }
}
