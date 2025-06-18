<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $memberRole = Role::where('role', 'member')->first();
       
        $users = User::where('is_admin', 0)->get();

        foreach ($users as $user) {
            $user->roles()->syncWithoutDetaching([$memberRole->id]);
        }  
    }
}
