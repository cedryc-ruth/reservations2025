<?php

namespace Database\Seeders;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
            Review::create([
            'user_id' => 10,
            'show_id' => 1,
            'stars' => 5,
            'validated' => true,
            'review' => 'Une performance bouleversante. J\'en suis ressorti avec les larmes aux yeux.',
        ]);

        Review::create([
            'user_id' => 1,
            'show_id' => 2,
            'stars' => 4,
            'validated' => true,
            'review' => 'Je m\'identifie beaucoup au poète guerrier...',
        ]);

        Review::create([
            'user_id' => 2,
            'show_id' => 2,
            'stars' => 3,
            'validated' => false,
            'review' => 'Pas mal mais un peu trop long...',
        ]);

            Review::create([
            'user_id' => 8,
            'show_id' => 2,
            'stars' => 2,
            'validated' => true,
            'review' => 'Quelques longueurs mais globalement une belle redécouverte de ce classique.',
        ]);

    }
}
