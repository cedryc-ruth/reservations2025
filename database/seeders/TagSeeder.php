<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Show;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crée quelques tags
        $tags = [
            'Comédie',
            'Drame',
            'Famille',
            'Classique',
            'Improvisation'
        ];

        foreach ($tags as $t) {
            Tag::create(['tag' => $t]);
        }

        // Optionnel : associer aléatoirement des tags à des shows existants
        $shows = Show::all();
        $allTags = Tag::all();

        foreach ($shows as $show) {
            $show->tags()->attach(
                $allTags->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
