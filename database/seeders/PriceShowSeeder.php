<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Show;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceShowSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyer les relations existantes
        DB::table('price_show')->truncate();
        
        $prices = Price::all();
        $shows = Show::all();
        
        // Lier tous les prix à tous les spectacles
        foreach ($shows as $show) {
            foreach ($prices as $price) {
                DB::table('price_show')->insert([
                    'price_id' => $price->id,
                    'show_id' => $show->id,
                ]);
            }
        }
    }
}
