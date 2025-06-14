<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            [
                'firstname' => 'Bob',
                'lastname' => 'Sull',
                'langue'=>'en',
                'login'=>'BobSull',
                'email' => 'bob@sull.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'firstname' => 'Lydia',
                'lastname' => 'Smith',
                'langue'=>'en',
                'login'=>'Lydia25',
                'email' => 'lydia@smith.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'firstname' => 'Fred',
                'lastname' => 'Cury',
                'langue'=>'fr',
                'login'=>'FCury',
                'email' => 'fred@cury.com',
                'password' => bcrypt('12345678'),
            ],
    
             [
                'firstname' => 'Marie',
                'lastname' => 'Dubois',
                'langue'=>'fr',
                'login'=>'MarieDb',
                'email' => 'marie@dubois.com',
                'password' => bcrypt('12345678'),
            ],
             [
                'firstname' => 'Martin',
                'lastname' => 'Thomas',
                'langue'=>'fr',
                'login'=>'Mtho',
                'email' => 'martin@thomas.com',
                'password' => bcrypt('12345678'),
            ],
             [
                'firstname' => 'Louise',
                'lastname' => 'Desmet',
                'langue'=>'nl',
                'login'=>'Lou',
                'email' => 'Louise@Desmet.com',
                'password' => bcrypt('12345678'),
            ],
             [
                'firstname' => 'Rafael',
                'lastname' => 'Martinez',
                'langue'=>'es',
                'login'=>'rMar',
                'email' => 'rafael@martinez.com',
                'password' => bcrypt('12345678'),
            ],
             [
                'firstname' => 'Thomas',
                'lastname' => 'Petit',
                'langue'=>'fr',
                'login'=>'thoamsp',
                'email' => 'thhomas@petit.com',
                'password' => bcrypt('12345678'),
            ], 
            [
                'firstname' => 'Nowak',
                'lastname' => ' Kochanowski',
                'langue'=>'pl',
                'login'=>'Noko',
                'email' => 'nowak@kochanowski.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'firstname' => 'Hamza',
                'lastname' => 'Naim',
                'langue'=>'ar',
                'login'=>'Hamza1003',
                'email' => 'hamza@naim.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'firstname' => 'Hanane',
                'lastname' => 'Amar',
                'langue'=>'ar',
                'login'=>'hanamar',
                'email' => 'hanane@amar.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'firstname' => 'Maeve',
                'lastname' => 'Kelly',
                'langue'=>'ir',
                'login'=>'justKelly',
                'email' => 'maeve@kelly.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'firstname' => 'Niall',
                'lastname' => 'Ryan',
                'langue'=>'ir',
                'login'=>'Ryan2025',
                'email' => 'niall@ryan.com',
                'password' => bcrypt('12345678'),
            ],
            

        ];

        DB::table('users')->insert($data);
    }
}
