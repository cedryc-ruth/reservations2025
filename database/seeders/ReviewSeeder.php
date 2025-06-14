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
            'user_id' => 1,
            'show_id' => 1,
            'stars' => 4,
            'validated' => true,
            'review' => 'Excellent film, je recommande grandement !',
        ]);

        Review::create([
            'user_id' => 2,
            'show_id' => 2,
            'stars' => 3,
            'validated' => false,
            'review' => 'Pas mal mais un peu trop long...',
        ]);

        Review::create([
            'user_id' => 1,
            'show_id' => 2,
            'stars' => 5,
            'validated' => true,
            'review' => 'Une véritable claque visuelle.',
        ]);

    }
}
