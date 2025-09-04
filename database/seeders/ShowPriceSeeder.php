<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Show;
use App\Models\Price;
use Illuminate\Support\Facades\DB;

class ShowPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les spectacles
        $shows = Show::all();
        
        // Récupérer tous les prix existants
        $prices = Price::all();
        
        if ($shows->isEmpty() || $prices->isEmpty()) {
            $this->command->info('Impossible de créer des associations : spectacles ou prix manquants');
            return;
        }

        // Supprimer les associations existantes
        DB::table('price_show')->truncate();

        // Créer des associations prix-spectacle pour chaque spectacle
        foreach ($shows as $show) {
            // Choisir 2-3 prix aléatoires pour chaque spectacle
            $randomPrices = $prices->random(rand(2, 3));
            
            foreach ($randomPrices as $price) {
                DB::table('price_show')->insert([
                    'show_id' => $show->id,
                    'price_id' => $price->id,
                ]);
            }
        }

        $this->command->info('Associations prix-spectacle créées avec succès !');
    }
}
