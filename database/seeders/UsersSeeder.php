<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'manager_user',
            'password' => Hash::make('1234'),
            'last_login' => now(),
            'is_active' => true,
            'role' => 'manager',
            'created_at' => now(),

        ]);

        DB::table('users')->insert([
            'username' => 'agent_user',
            'password' => Hash::make('1234'),
            'last_login' => now(),
            'is_active' => true,
            'role' => 'agent',
            'created_at' => now(),

        ]);
    }
}
