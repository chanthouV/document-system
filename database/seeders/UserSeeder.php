<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'department_id' => 1,
                'role_id' => 1
            ],
            [
                'name' => 'Finance Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'department_id' => 2,
                'role_id' => 1
            ],
        ]);
    }
}
