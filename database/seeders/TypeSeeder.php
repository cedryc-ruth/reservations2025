<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Type::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            ['type'=>'comédien'],
            ['type'=>'scénographe'],
            ['type'=>'auteur'],
        ];

        DB::table('types')->insert($data);
    }
}
