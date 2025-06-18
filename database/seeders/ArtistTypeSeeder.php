<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;
use App\Models\Type;

class ArtistTypeSeeder extends Seeder
{
    public function run(): void
    {
        // On récupère les artistes
        $artist1 = Artist::where('firstname', 'Jean')->where('lastname', 'Dupont')->first();
        $artist2 = Artist::where('firstname', 'Claire')->where('lastname', 'Moreau')->first();

        // On récupère les types
        $typeChanteur = Type::where('type', 'chanteur')->first();
        $typeComedien = Type::where('type', 'comédien')->first();

        // On attache les types aux artistes (relation many-to-many)
        if ($artist1 && $typeChanteur) {
            $artist1->types()->attach($typeChanteur->id);
        }

        if ($artist2 && $typeComedien) {
            $artist2->types()->attach($typeComedien->id);
        }

        // Tu peux en ajouter d'autres ici si tu veux lier plus d'artistes et de types
    }
}
