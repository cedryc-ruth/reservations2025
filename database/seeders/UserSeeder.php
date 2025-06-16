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
                'name' => 'Bob',
                'email' => 'bob@sull.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
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
        ];

        DB::table('users')->insert($data);
    }
}
