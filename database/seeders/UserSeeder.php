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
        User::truncate();

        $data = [
            [
                'name' => 'Bob',
                'email' => 'bob@sull.com',
                'password' => '12345678',
            ],
            [
                'name' => 'Lydia',
                'email' => 'lydia@sull.com',
                'password' => '12345678',
            ],
            [
                'name' => 'Fred',
                'email' => 'fred@sull.com',
                'password' => '12345678',
            ],
        ];

        DB::table('users')->insert($data);
    }
}
