<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'email' => 'bob@sull.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ],
            [

                'firstname' => 'Lydia',
                'lastname' => 'Smith',
                'langue'=>'en',
                'email' => 'lydia@smith.com',
                'password' => Hash::make('12345678'),
              'is_admin' => false,
            ],
            [
                'firstname' => 'Fred',
                'lastname' => 'Cury',
                'langue'=>'fr',
                'email' => 'fred@cury.com',
                'password' => Hash::make('12345678'),
              'is_admin' => false,
            ],
    
             [
                'firstname' => 'Marie',
                'lastname' => 'Dubois',
                'langue'=>'fr',
                'email' => 'marie@dubois.com',
                'password' => Hash::make('12345678'),
               'is_admin' => false,
            ],
             [
                'firstname' => 'Martin',
                'lastname' => 'Thomas',
                'langue'=>'fr',
                'email' => 'martin@thomas.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
             [
                'firstname' => 'Louise',
                'lastname' => 'Desmet',
                'langue'=>'nl',
                'email' => 'Louise@Desmet.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
             [
                'firstname' => 'Rafael',
                'lastname' => 'Martinez',
                'langue'=>'es',
                'email' => 'rafael@martinez.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
             [
                'firstname' => 'Thomas',
                'lastname' => 'Petit',
                'langue'=>'fr',
                'email' => 'thhomas@petit.com',
                'password' => Hash::make('12345678'),
                 'is_admin' => false,
            ], 
            [
                'firstname' => 'Nowak',
                'lastname' => ' Kochanowski',
                'langue'=>'pl',
                'email' => 'nowak@kochanowski.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Hamza',
                'lastname' => 'Naim',
                'langue'=>'ar',
                'email' => 'hamza@naim.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Hanane',
                'lastname' => 'Amar',
                'langue'=>'ar',
                'email' => 'hanane@amar.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Maeve',
                'lastname' => 'Kelly',
                'langue'=>'ir',
                'email' => 'maeve@kelly.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Niall',
                'lastname' => 'Ryan',
                'langue'=>'ir',
                'email' => 'niall@ryan.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            

        ];

        DB::table('users')->insert($data);
    }
}
