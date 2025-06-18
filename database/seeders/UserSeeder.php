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
                'login'=>'BobSull',
                'email' => 'bob@sull.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [

                'firstname' => 'Lydia',
                'lastname' => 'Smith',
                'langue'=>'en',
                'login'=>'Lydia25',
                'email' => 'lydia@smith.com',
                'password' => Hash::make('12345678'),
              'is_admin' => false,
            ],
            [
                'firstname' => 'Fred',
                'lastname' => 'Cury',
                'langue'=>'fr',
                'login'=>'FCury',
                'email' => 'fred@cury.com',
                'password' => Hash::make('12345678'),
              'is_admin' => false,

                'name' => 'Lydia',
                'email' => 'lydia@sull.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'name' => 'Fred',
                'email' => 'fred@sull.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,

            ],
    
             [
                'firstname' => 'Marie',
                'lastname' => 'Dubois',
                'langue'=>'fr',
                'login'=>'MarieDb',
                'email' => 'marie@dubois.com',
                'password' => Hash::make('12345678'),
               'is_admin' => false,
            ],
             [
                'firstname' => 'Martin',
                'lastname' => 'Thomas',
                'langue'=>'fr',
                'login'=>'Mtho',
                'email' => 'martin@thomas.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
             [
                'firstname' => 'Louise',
                'lastname' => 'Desmet',
                'langue'=>'nl',
                'login'=>'Lou',
                'email' => 'Louise@Desmet.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
             [
                'firstname' => 'Rafael',
                'lastname' => 'Martinez',
                'langue'=>'es',
                'login'=>'rMar',
                'email' => 'rafael@martinez.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
             [
                'firstname' => 'Thomas',
                'lastname' => 'Petit',
                'langue'=>'fr',
                'login'=>'thoamsp',
                'email' => 'thhomas@petit.com',
                'password' => Hash::make('12345678'),
                 'is_admin' => false,
            ], 
            [
                'firstname' => 'Nowak',
                'lastname' => ' Kochanowski',
                'langue'=>'pl',
                'login'=>'Noko',
                'email' => 'nowak@kochanowski.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Hamza',
                'lastname' => 'Naim',
                'langue'=>'ar',
                'login'=>'Hamza1003',
                'email' => 'hamza@naim.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Hanane',
                'lastname' => 'Amar',
                'langue'=>'ar',
                'login'=>'hanamar',
                'email' => 'hanane@amar.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Maeve',
                'lastname' => 'Kelly',
                'langue'=>'ir',
                'login'=>'justKelly',
                'email' => 'maeve@kelly.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'firstname' => 'Niall',
                'lastname' => 'Ryan',
                'langue'=>'ir',
                'login'=>'Ryan2025',
                'email' => 'niall@ryan.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            

        ];

        DB::table('users')->insert($data);
    }
}
