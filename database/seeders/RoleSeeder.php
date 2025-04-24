<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();

        $data = [
            ['role'=>'admin'],
            ['role'=>'member'],
            ['role'=>'affiliate'],
            ['role'=>'press'],
        ];

        DB::table('roles')->insert($data);
    }
}
