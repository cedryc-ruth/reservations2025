<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Type;
use App\Models\Show;
use App\Models\ArtistType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistTypeShowSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les relations artiste-type
        $artists = Artist::all();
        $types = Type::all();
        $shows = Show::all();

        // Assigner des types aux artistes
        $artistTypeData = [];
        foreach ($artists as $artist) {
            // Chaque artiste peut avoir 1-2 types
            $randomTypes = $types->random(rand(1, 2));
            foreach ($randomTypes as $type) {
                $artistTypeData[] = [
                    'artist_id' => $artist->id,
                    'type_id' => $type->id,
                ];
            }
        }

        // Insérer les relations artiste-type
        DB::table('artist_type')->insert($artistTypeData);

        // Récupérer les artist_types créés
        $artistTypes = ArtistType::with(['artist', 'type'])->get();

        // Lier les artistes aux spectacles
        $artistTypeShowData = [];
        foreach ($shows as $show) {
            // Chaque spectacle aura 2-5 artistes
            $randomArtistTypes = $artistTypes->random(rand(2, 5));
            foreach ($randomArtistTypes as $artistType) {
                $artistTypeShowData[] = [
                    'artist_type_id' => $artistType->id,
                    'show_id' => $show->id,
                ];
            }
        }

        // Insérer les relations artist_type-show
        DB::table('artist_type_show')->insert($artistTypeShowData);
    }
}
